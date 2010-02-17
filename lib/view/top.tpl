
        <div id="header">
            <a href="{ROOT_PATH}">You Survey</a>
            <p>Did you know ?</p>
            <p><a href="{ROOT_PATH}question/{didyouknow_guid}-{didyouknow_id}">{didyouknow_label}</a></p>
        </div>

        <div id="userBox">
			<!-- SECTION logged -->
            <a href="{ROOT_PATH}{user_login}">{user_login}</a> (<a href="{ROOT_PATH}logout">logout</a>)
            <!-- END logged -->
			<!-- SECTION notLogged -->
            <a href="{ROOT_PATH}login">Login / register</a>
            <!-- END notLogged -->
        </div>

        <!-- SECTION feedback -->
        <p><i>{feedback}</i></p>
        <!-- END feedback -->

