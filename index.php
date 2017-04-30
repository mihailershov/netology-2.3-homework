<?php

// Если был получен POST-запрос с файлом, то проверяем, подходит ли он
if (isset($_POST['upload'])) {

    // Редирект на страницу с тестами через три секунды
    header('refresh:3; url=list.php');

    // Определяем массив со всеми файлами из папки с тестами
    if (!empty(glob('tests/*.json'))) {
        $allFiles = glob('tests/*.json');
    } else {
        $allFiles = [0];
    }

    // Определяем загружаемый файл
    $uploadfile = 'tests/' . basename($_FILES['testfile']['name']);

    // Прогоняем файл по if'ам, если не подходит - выкидываем ошибку
    if (pathinfo($_FILES['testfile']['name'], PATHINFO_EXTENSION) !== 'json') {
        $result = "<p class='error'>Можно загружать файлы только с расширением json</p>";
    } else if ($_FILES["testfile"]["size"] > 1024 * 1024 * 1024) {
        $result = "<p class='error'>Размер файла превышает три мегабайта</p>";
    } else if (in_array($uploadfile, $allFiles, true)) {
        $result = "<p class='error'>Файл с таким именем уже существует.</p>";
    } else if (move_uploaded_file($_FILES['testfile']['tmp_name'], $uploadfile)) {
        $result = "<p class='success'>Файл корректен и успешно загружен на сервер</p>";
    } else {
        $result = "<p class='error'>Произошла ошибка</p>";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles/admin.css">
</head>
<body>

<!-- Если файл был отправлен, то выводить информацию о файле и уведомление об успешной загрузке/ошибке -->

<?php if (isset($_POST['upload'])): ?>
    <a href="<?php $_SERVER['HTTP_REFERER'] ?>"><div>< Назад</div></a>
    <?php echo $result; ?><br>
    <h1>Вы будете перенаправлены на страницу с тестами через 3 секунды...</h1>
<?php endif; ?>

<!-- Если файл или форма теста не была отправлена, то выводить форму загрузки и форму создания теста -->

<?php if (isset($_POST['create']) === false && isset($_POST['upload']) === false): ?>

    <form id="load-json" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Загрузите свой тест в формате json</legend>
            <input type="file" name="testfile" id="uploadfile" required>
            <input type="submit" value="Добавить в базу" id="submit-upload" name="upload">
        </fieldset>
    </form>

    <div class="all-tests">
        <fieldset>
            <a href="list.php">Посмотреть все тесты >></a>
        </fieldset>
    </div>

    <form method="POST" id="create-json">
        <fieldset>
            <legend>Или создайте тест прямо на сайте <span style="background-color:palevioletred; padding: 2px;">(в данный момент не работает)</span></legend>
            <div class="question-block1 question-container">
                <p class="question-number">1 вопрос</p>
                <div class="question">
                    <p>Вопрос: </p><input type="text" name="question1" required><br>
                </div>
                <p>Ответ 1: </p><input type="text" name="answer1" class="answer" required><br>
                <p>Ответ 2: </p><input type="text" name="answer2" class="answer" required><br>
                <p>Ответ 3: </p><input type="text" name="answer3" class="answer"><br>
                <p>Ответ 4: </p><input type="text" name="answer4" class="answer"><br>
                <p class="correct-answer-p">Правильный ответ:</p>
                <div class="correct-answer">
                    1<input type="radio" name="radiobutton" class="first-correct">&nbsp&nbsp;&nbsp;
                    2<input type="radio" name="radiobutton" class="second-correct">&nbsp&nbsp&nbsp;
                    3<input type="radio" name="radiobutton" class="third-correct">&nbsp&nbsp;&nbsp;
                    4<input type="radio" name="radiobutton" class="fourth-correct">
                </div>
            </div>

            <div class="buttons">
                <input type="submit" name="create">
                <button id="add-question" type="button">Добавить еще один вопрос</button>
            </div>

        </fieldset>
    </form>

<?php endif; ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="js/admin.js"></script>
</body>
</html>