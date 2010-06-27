
            <div id="login" class="modal">
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
                    <a href="{{ROOT_PATH}}remote/register" class="nyroModal button">Créer un compte</a>
                </div>
            </div>

