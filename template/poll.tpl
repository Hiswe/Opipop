
            <!-- INCLUDE block/top.tpl -->

            <h2 id="question"><span>{question_date}</span> <a href="{ROOT_PATH}poll/{question_id}">{question_label}</a></h2>
            <ul id="result">
                <!-- LOOP answer -->
                <li id="answer_{answer.id}" class="answer">{answer.label}
                    <ul>
                        <!-- LOOP answer.user -->
                        <li id="user_{answer.user.id}" class="user">{answer.user.login}</li>
                        <!-- END answer.user -->
                    </ul>
                </li>
                <!-- END answer -->
            </ul>

            <div id="farm">
                <ul>
                    <!-- LOOP user -->
                    <li id="user_{user.id}" class="user">{user.login}</li>
                    <!-- END user -->
                </ul>
            </div>

            <script type="text/javascript">poll_init({poll_parameters});</script>

