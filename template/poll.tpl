
            <!-- INCLUDE block/top.tpl -->

            <h1 id="question">{question_label}</h1>

            <!-- SECTION active -->
			<p>This poll will end in {question_end_time}.</p>
            <ul id="result">
                <!-- LOOP answer -->
                <li name="answer_{answer.id}" class="answer">{answer.label}
                    <ul>
                        <!-- LOOP answer.user -->
                        <li name="user_{answer.user.id}" class="user {answer.user.class}"><img src="{ROOT_PATH}media/avatar/{answer.user.avatar}" alt="{answer.user.login}" /> {answer.user.login}</li>
                        <!-- END answer.user -->
                    </ul>
                </li>
                <!-- END answer -->
            </ul>

            <div id="farm">
                <ul>
                    <!-- LOOP user -->
                    <li name="user_{user.id}" class="user voted unregistered"><img src="{ROOT_PATH}media/avatar/{user.avatar}" alt="{user.login}" /> {user.login}</li>
                    <li name="user_{user.id}" class="user guessed unregistered"><img src="{ROOT_PATH}media/avatar/{user.avatar}" alt="{user.login}" /> {user.login}</li>
                    <!-- END user -->
                </ul>
            </div>

            <div id="saveButton">Save results</div>

            <script type="text/javascript">poll_initVote({poll_parameters});</script>
            <!-- END active -->

            <!-- SECTION inactive -->
			<p>This poll started on the {question_start_date} and ended on the {question_end_date}.</p>
            <ul id="result">
                <!-- LOOP answer -->
                <li name="answer_{answer.id}" class="answer">({answer.percentFormated}%) {answer.label}
                    <div class="progress" name="{answer.percent}"></div>
                    <ul>
                        <li><strong>Mal:</strong> {answer.percent_male}%</li>
                        <li><strong>Female:</strong> {answer.percent_female}%</li>
                    </ul>
                    <ul>
                        <!-- LOOP answer.user -->
                        <li name="user_{answer.user.id}" class="user {answer.user.class}"><a href="{ROOT_PATH}{answer.user.login}"><img src="{ROOT_PATH}media/avatar/{answer.user.avatar}" alt="{answer.user.login}" /> {answer.user.login}</a></li>
                        <!-- END answer.user -->
                    </ul>
                </li>
                <!-- END answer -->
            </ul>

            <script type="text/javascript">poll_initResult();</script>
            <!-- END inactive -->

