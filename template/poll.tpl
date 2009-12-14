
            <!-- INCLUDE block/top.tpl -->

            <!-- LOOP question -->
            <h2 id="question"><span>{question.date}</span> <a href="{ROOT_PATH}poll/{question.id}">{question.label}</a></h2>
            <ul id="answer">
                <!-- LOOP question.answer -->
                <li>{question.answer.label}<ul></ul></li>
                <!-- END question.answer -->
            </ul>
            <!-- END question -->

            <ul id="farm">
                <!-- LOOP userLogged -->
                <li id="user_{userLogged.id}" class="user">{userLogged.login}</li>
                <!-- END userLogged -->
            </ul>

            <script type="text/javascript">poll_init();</script>

