
        <!-- INCLUDE block/top.tpl -->

        <h2>Login an existing user</h2>
        <form id="login" method="post" name="login" action="javascript:login_submit();">
            <div><label>Login: <input id="login_login" type="text" maxlength="32" name="login" value="" /></label></div>
            <div><label>Password: <input id="login_password" type="password" maxlength="128" name="password" value="" /></label></div>
            <div><input type="submit" name="submit" value="login"></div>
        </form>
        <script type="text/javascript">login_init();</script>

        <h2>Register a new user</h2>
        <form id="register" method="post" name="register" action="javascript:register_submit();">
            <div><label>Login: <input id="register_login" type="text" maxlength="32" name="login" value="" /></label></div>
            <div><label>Email: <input id="register_email" type="text" maxlength="320" name="email" value="" /></label></div>
            <div><label>Password: <input id="register_password_1" type="password" maxlength="128" name="password_1" value="" /></label></div>
            <div><label>Confirm password: <input id="register_password_2" type="password" maxlength="128" name="password_2" value="" /></label></div>
            <div><input type="submit" name="submit" value="register"></div>
        </form>
        <script type="text/javascript">register_init();</script>

