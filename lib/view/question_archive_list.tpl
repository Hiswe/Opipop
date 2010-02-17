
        <ul id="questionArchiveList">
            <!-- LOOP question -->
            <li class="question key_{question.key}">
                <div class="label"><a href="{ROOT_PATH}question/{question.guid}-{question.id}">{question.label}</a></div>
                <ul class="answers">
                    <!-- LOOP question.answer -->
                    <li class="answer">{question.answer.label}</li>
                    <!-- END question.answer -->
                </ul>
            </li>
            <!-- END question -->
        </ul>

