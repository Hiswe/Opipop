
            <!-- INCLUDE block/top.tpl -->

            <h2 id="question"><span>{question_date}</span> <a href="{ROOT_PATH}poll/{question_id}">{question_label}</a></h2>

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
                    <li id="user_{user.id}" class="user unregistered">{user.login}</li>
                    <!-- END user -->
                </ul>
            </div>

            <div id="saveButton">Save results</div>

            <script type="text/javascript">poll_initVote({poll_parameters});</script>
            <!-- END active -->

            <!-- SECTION inactive -->
            <ul id="result">
                <!-- LOOP answer -->
                <li id="answer_{answer.id}" class="answer">{answer.label}
                    <ul>
                        <!-- LOOP answer.user -->
                        <li id="user_{answer.user.id}" class="user">{answer.user.login}</li>
                        <!-- END answer.user -->
                    </ul>
                    <div>{answer.progress} ({answer.percentFormated}%)</div>
                    <div class="progress" name="{answer.percent}"></div>
                </li>
                <!-- END answer -->
            </ul>

            <script type="text/javascript">poll_initResult();</script>
            <!-- END inactive -->

