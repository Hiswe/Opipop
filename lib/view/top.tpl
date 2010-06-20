
        <div id="header">
            <h1><a id="logo" href="{ROOT_PATH}">OpipPop</a></h1>
            <p><a href="{ROOT_PATH}question/{didyouknow_guid}-{didyouknow_id}">{didyouknow_label}</a></p>

            <!-- SECTION logged -->
            <div id="userBox" class="frame">
                <a href="{ROOT_PATH}{user_login}" class="avatar"><img src="{ROOT_PATH}{user_avatarUri}" /></a>
                <div class="info">
                    <a href="{ROOT_PATH}{user_login}" class="login"><span>{user_login}</span></a>
                    <p class="linkList"><a href="{ROOT_PATH}{user_login}">profile</a><span>|</span><a href="{ROOT_PATH}logout">déconnexion</a></p>
                </div>
            </div>
            <!-- END logged -->

            <!-- SECTION notLogged -->
            <span id="login_link" class="button">Login</span>
            <form id="login" method="post" name="login" action="javascript:Login.submit();">
                <input id="login_login" type="text" maxlength="32" name="login" value="" />
                <input id="login_password" type="password" maxlength="128" name="password" value="" />
                <input type="submit" name="submit" value="login">
                <a id="registerLink" href="{ROOT_PATH}register">register</a>
            </form>
            <script type="text/javascript">Login.init();</script>
            <!-- END notLogged -->
        </div>

        <div><a href="{ROOT_PATH}submit">>> Propose a survey</a></div>

        <!-- SECTION feedback -->
        <p><i>{feedback}</i></p>
        <!-- END feedback -->

        <!-- SECTION warning -->
        <p><i>{warning}</i></p>
        <!-- END warning -->

