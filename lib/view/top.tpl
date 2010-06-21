
        <div id="header">
            <h1><a id="logo" href="{ROOT_PATH}">OpipPop</a></h1>
            <p><a class="baseLine" href="{ROOT_PATH}question/{didyouknow_guid}-{didyouknow_id}">{didyouknow_label}</a></p>

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
            <a href="#login" class="nyroModal button" id="login_link">Login</a>
            <div id="login">
                <div id="loginContent">
                    <div class="side1">
                        <form id="login_form" method="post" name="login" action="javascript:Login.submit();">
                            <label>
                                <em>Login:</em>
                                <input id="login_login" type="text" maxlength="32" name="login" value="" />
                            </label>
                            <label>
                                <em>Mot de passe:</em>
                                <input id="login_password" type="password" maxlength="128" name="password" value="" />
                            </label>
                            <input type="submit" name="submit" value="Connexion">
                        </form>
                    </div>
                    <div class="side2">
                        <p>Vous n'étez pas encore inscrit ?<br/><br/>Créez un compte et en moins d'une minute partagez vos opinions avec tous vos amis.</p>
                        <a href="{ROOT_PATH}register" class="button">Créer un compte</a>
                    </div>
                </div>
            </div>
            <!-- END notLogged -->
        </div>

        <!-- SECTION feedback -->
        <p><i>{feedback}</i></p>
        <!-- END feedback -->

        <!-- SECTION warning -->
        <p><i>{warning}</i></p>
        <!-- END warning -->

