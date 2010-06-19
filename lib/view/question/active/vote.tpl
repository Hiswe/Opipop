    <p class="questionLabel">Donnez votre opinion :</p>
    <!-- LOOP answer -->
        <a href="#" class="questionChoice" onclick="javascript:Question.selectAnswer($(this), {question_id}, {answer.id}, 'vote');" class="answer">{answer.label}</a>
    <!-- END answer -->

        <button type="button" onclick="javascript:Question.save($(this), {question_id}, 'vote');" class="save hide">save</button>

