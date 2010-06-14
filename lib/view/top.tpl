
        <div id="header">
            <a href="{ROOT_PATH}">OpipPop</a>
            <p>Did you know ?</p>
            <p><a href="{ROOT_PATH}question/{didyouknow_guid}-{didyouknow_id}">{didyouknow_label}</a></p>
            
            <div id="userBox">
                <!-- SECTION logged -->
                <a href="{ROOT_PATH}{user_login}">{user_login}</a> (<a href="{ROOT_PATH}logout">logout</a>)
                <!-- END logged -->
                <!-- SECTION notLogged -->
                <span id="login_link" class="link">Login</span>
                <!-- END notLogged -->
            </div>
                <!-- SECTION notLogged -->            
            <form id="login" method="post" name="login" action="javascript:Login.submit();">
                <input id="login_login" type="text" maxlength="32" name="login" value="" />
                <input id="login_password" type="password" maxlength="128" name="password" value="" />
                <input type="submit" name="submit" value="login">
                <a id="register" href="{ROOT_PATH}register">register</a>
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

