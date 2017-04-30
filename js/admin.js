$(function () {


    $('#add-question').on('click', function () {
        var div = $('.question-container').length;

        $('.question-block' + div).after(
            '<div class="question-block' + parseInt(div + 1) + ' question-container">' +
            '<p class="question-number">' + parseInt(div + 1) + ' вопрос' + '</p>' +
            '<div class="question">' +
            'Вопрос: <input type="text" name="question required"><br>' +
            '</div>' +
            '<p>Ответ 1: </p><input type="text" name="answer1" class="answer" required><br>' +
            '<p>Ответ 2: </p><input type="text" name="answer2" class="answer" required><br>' +
            '<p>Ответ 3: </p><input type="text" name="answer3" class="answer"><br>' +
            '<p>Ответ 4: </p><input type="text" name="answer4" class="answer"><br>' +
            '<p class="correct-answer-p">Правильный ответ:</p>' +
            '<div class="correct-answer">' +
            '1<input type="radio" name="radiobutton" class="first-correct">&nbsp;&nbsp;&nbsp;' +
            '2<input type="radio" name="radiobutton" class="second-correct">&nbsp;&nbsp;&nbsp;' +
            '3<input type="radio" name="radiobutton" class="third-correct">&nbsp;&nbsp;&nbsp;' +
            '4<input type="radio" name="radiobutton" class="fourth-correct">' +
            '</div>' +
            '<button type="button" class="delete-question">Удалить вопрос</button>' +
            '</div>'
        );
        $('body').animate({
            scrollTop: document.body.scrollHeight
        }, 500);
    });


    $('body').on('click', '.delete-question', function () {
        $(this).closest('.question-container').animate({
            "opacity": "0",
        }, 500, function () {
            $(this).remove();

            $('.question-container').each(function () {
                var position = $(this).index('.question-container') + 1,
                    nextPosition = $(this).index('.question-container') + 2;
                $(this).addClass('question-block' + position).removeClass('question-block' + nextPosition);
            });

            $('.question-number').each(function () {
                var position = $(this).index('.question-number') + 1;
                $(this).html(position + ' вопрос');
            });
        });
    });


});