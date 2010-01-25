
            <!-- INCLUDE block/top.tpl -->

            <h1 id="question">{question_label}</h1>

			<p>This poll started on the {question_start_date} and ended on the {question_end_date}.</p>

            <!-- SECTION active -->
            <ul id="result">
                <!-- LOOP answer -->
                <li id="answer_{answer.id}" class="answer">{answer.label}
                    <ul>
                        <!-- LOOP answer.user -->
                        <li id="user_{answer.user.id}" class="user {answer.user.class}">{answer.user.login}</li>
                        <!-- END answer.user -->
                    </ul>
                </li>
                <!-- END answer -->
            </ul>

            <div id="farm">
                <ul>
                    <!-- LOOP user -->
                    <li id="user_{user.id}" class="user unregistered"><a href="{ROOT_PATH}{user.guid}">{user.login}</a></li>
                    <!-- END user -->
                </ul>
            </div>

            <div id="saveButton">Save results</div>

            <script type="text/javascript">poll_initVote({poll_parameters});</script>
            <!-- END active -->

            <!-- SECTION inactive -->
            <ul id="result">
                <!-- LOOP answer -->
                <li id="answer_{answer.id}" class="answer">({answer.percentFormated}%) {answer.label}
                    <div class="progress" name="{answer.percent}"></div>
                    <ul>
                        <!-- LOOP answer.user -->
                        <li id="user_{answer.user.id}" class="user {answer.user.class}"><a href="{ROOT_PATH}{answer.user.guid}">{answer.user.login}</a></li>
                        <!-- END answer.user -->
                    </ul>
                </li>
                <!-- END answer -->
            </ul>

            <script type="text/javascript">poll_initResult();</script>
            <!-- END inactive -->

