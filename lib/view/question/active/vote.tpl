
    <dt>Give your opinion:</dt>

    <!-- LOOP answer -->
    <li class="answer">
        <button type="button" onclick="javascript:Question.selectAnswer($(this), {question_id}, {answer.id}, 'vote');" class="answer">{answer.label}</button>
    </li>
    <!-- END answer -->

    <li>
        <button type="button" onclick="javascript:Question.save($(this), {question_id}, 'vote');" class="save hide">save</button>
    </li>

