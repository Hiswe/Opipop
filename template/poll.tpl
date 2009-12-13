
            <!-- INCLUDE block/top.tpl -->

            <!-- LOOP question -->
            <li>
                <h4 class="question"><span>{question.date}</span> <a href="{ROOT_PATH}poll/{question.id}">{question.label}</a></h4>
                <ul class="answer">
                    <!-- LOOP question.answer -->
                    <li>{question.answer.label}</li>
                    <!-- END question.answer -->
                </ul>
            </li>
            <!-- END question -->

