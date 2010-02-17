
        <ul id="questionActiveList">
            <!-- LOOP question -->
            <li class="question key_{question.key}">
                <div class="label"><img class="star" src="{ROOT_PATH}media/layout/star.png" />{question.label}</div>
                <ul class="answers">
                    <!-- LOOP question.answer -->
                    <li class="answer">{question.answer.label}</li>
                    <!-- END question.answer -->
                </ul>
                <div class="share">
                    <a href="http://twitter.com/home?status={question_label_urlencoded} {ROOT_PATH}question/p-{question_id}" target="_blank" title="share this question on Twitter !"><img src="{ROOT_PATH}media/layout/tshare.png" /></a>
                    <a href="http://www.facebook.com/sharer.php?u={ROOT_PATH}question/{question_guid}-{question_id}&t={question_label_urlencoded}" target="_blank" title="share this question on Facebook !"><img src="{ROOT_PATH}media/layout/fbshare.png" /></a>
                </div>
                <div class="infos">{question.time}</div>
            </li>
            <!-- END question -->
        </ul>

        <div id="questionArchiveContainer"></div>

        <div id="morePolls"><a href="javascript:return false;" id="morePollsButton">More polls</a></div>
        <script type="text/javascript">question_initList();</script>

