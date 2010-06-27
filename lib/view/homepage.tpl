
        <ul id="questions">
            <!-- LOOP question -->
            <li class="question frame">
                <h2 class="{question.class} questionTitle">{question.label}</h2>
                <dl id="question_{question.id}" class="questionContent">
                        <!-- <span>{question.time}</span> -->
                    <dt>
                        <img src="{ROOT_PATH}{question.image}" alt="{question.label}" />
                    </dt>
                    <dd class="content">
                        {question.content}
                    </dd>
                    <!-- <dd class="friends">
                    <span class="link" onclick="javascript:Question.guessFriend($(this), {question.id});">Guess what your friend will answer ...</span>
                    </dd> -->
                </dl>
                <div class="share">
                    <span class="dureeSondage">Fin du sondage {question.time}</span>
                    <a href="http://twitter.com/home?status={question.label_urlencoded} {ROOT_PATH}question/p-{question.id}" target="_blank" title="share this question on Twitter !"><img src="{ROOT_PATH}media/layout/tshare.png" /></a>
                    <a href="http://www.facebook.com/sharer.php?u={ROOT_PATH}question/{question.guid}-{question.id}&t={question.label_urlencoded}" target="_blank" title="share this question on Facebook !"><img src="{ROOT_PATH}media/layout/fbshare.png" /></a>
                </div>
            </li>
            <!-- END question -->
        </ul>

