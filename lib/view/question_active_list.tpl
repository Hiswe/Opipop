
        <script type="text/javascript">
            var question_userLogin = '{user_login}';
            var question_userId = {user_id};
        </script>

        <ul id="questionActiveList">
            <!-- LOOP question -->
            <li id="question_{question.id}" class="question">
                <div class="label"><!-- LOOP question.active --><img class="star" src="{ROOT_PATH}media/layout/star.png" /><!-- END question.active -->{question.label}</div>
                <div class="share">
                    <a href="http://twitter.com/home?status={question.label_urlencoded} {ROOT_PATH}question/p-{question.id}" target="_blank" title="share this question on Twitter !"><img src="{ROOT_PATH}media/layout/tshare.png" /></a>
                    <a href="http://www.facebook.com/sharer.php?u={ROOT_PATH}question/{question.guid}-{question.id}&t={question.label_urlencoded}" target="_blank" title="share this question on Facebook !"><img src="{ROOT_PATH}media/layout/fbshare.png" /></a>
                </div>
                <div class="infos">{question.time}</div>
                <div class="message"></div>
                <ul class="answers">
                    <!-- LOOP question.vote --><li class="answer"><button type="button" class="vote" id="vote_{question.vote.id}">{question.vote.label}</button></li><!-- END question.vote -->
                    <!-- LOOP question.guess --><li class="answer"><button type="button" class="guess" id="guess_{question.guess.id}">{question.guess.label}</button></li><!-- END question.guess -->
                </ul>
                <div class="save"><span class="link" onclick="javascript:question_saveResult({question.id});">save</span></div>
                <ul class="answers">
                    <!-- LOOP question.answer -->
                    <li class="answer" id="answer_{question.id}_{question.answer.id}">
                        <span class="label">{question.answer.label}</span>
                        <ul class="users">
                        <!-- LOOP question.answer.user -->
                        <li name="user_{question.answer.user.id}" class="user {question.answer.user.class}"><a href="{ROOT_PATH}{question.answer.user.login}"><img src="{ROOT_PATH}{question.answer.user.avatar}" alt="{question.answer.user.login}" /><span>{question.answer.user.login}</span></a></li>
                        <!-- END question.answer.user -->
                        </ul>
                    </li>
                    <!-- END question.answer -->
                </ul>
                <div class="clear"></div>
            </li>
            <script type="text/javascript">question_initVote({question.id});</script>
            <!-- END question -->
        </ul>

        <div id="questionArchiveContainer"></div>

        <div id="morePolls"><a href="javascript:return false;" id="morePollsButton">More polls</a></div>
        <script type="text/javascript">question_initList();</script>

