
    <p class="questionLabel">Devinez quelle sera la réponse la plus populaire :</p>

    <!-- LOOP answer -->
    <a href="#" class="questionChoice" onclick="javascript:Question.selectAnswer($(this), {question_id}, {answer.id}, 'guess');" class="answer">{answer.label}</a>
    <!-- END answer -->
    <button type="button" onclick="javascript:Question.save($(this), {question_id}, 'guess');" class="save hide">save</button>

