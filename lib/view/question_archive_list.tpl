
        <ul id="questionArchiveList">
            <!-- LOOP question -->
            <li class="question">
                <div class="label"><a href="{ROOT_PATH}question/{question.guid}-{question.id}">{question.label}</a></div>
                <div id="graph{question.id}" class="graph">
                    <script type="text/javascript">
                        vis_simplePie('graph{question.id}', 100, 100, {question.data});
                    </script>
                </div>
                <ul class="answers">
                    <!-- LOOP question.answer -->
                    <li class="answer key{question.answer.key}">{question.answer.label}<br/>{question.answer.percentFormated}</li>
                    <!-- END question.answer -->
                </ul>
            </li>
            <!-- END question -->
        </ul>

