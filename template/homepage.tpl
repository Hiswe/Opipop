
        <!-- INCLUDE block/top.tpl -->

        <h4>Questions:</h4>
        <ul id="questionList">
            <!-- LOOP question -->
            <li>
                <div class="question"><span>{question.date}</span> <a href="{ROOT_PATH}poll/{question.id}">{question.label}</a></div>
                <ul class="answer">
                    <!-- LOOP question.answer -->
                    <li>{question.answer.label}</li>
                    <!-- END question.answer -->
                </ul>
            </li>
            <!-- END question -->
        </ul>

