
        <script type="text/javascript">
            var question_userLogin = '{user_login}';
            var question_userId = {user_id};
        </script>

        <ul id="questions">
            <!-- LOOP question -->
            <dl id="question_{question.id}">
                <dt>
                    <h2 class="{question.class}">{question.label}</h2>
                    <span>{question.time}</span>
                    <div class="share">
                        <a href="http://twitter.com/home?status={question.label_urlencoded} {ROOT_PATH}question/p-{question.id}" target="_blank" title="share this question on Twitter !"><img src="{ROOT_PATH}media/layout/tshare.png" /></a>
                        <a href="http://www.facebook.com/sharer.php?u={ROOT_PATH}question/{question.guid}-{question.id}&t={question.label_urlencoded}" target="_blank" title="share this question on Facebook !"><img src="{ROOT_PATH}media/layout/fbshare.png" /></a>
                    </div>
                </dt>
                <div class="content">{question.content}</div>
            <dl>
            <!-- END question -->
        </ul>

        <div id="questionArchiveContainer"></div>

        <div id="morePolls"><a href="javascript:return false;" id="morePollsButton">More polls</a></div>
        <script type="text/javascript">question_initList();</script>

