
    <dt>Guess what will be the most popual answer:</dt>

    <!-- LOOP answer -->
    <li class="answer">
        <button type="button" onclick="javascript:question_selectAnswer(this, {question_id}, {answer.id}, 'guess');" class="answer">{answer.label}</button>
    </li>
    <!-- END answer -->

    <li>
        <button type="button" onclick="javascript:question_save(this, {question_id}, 'guess');" class="save hide">save</button>
    </li>

