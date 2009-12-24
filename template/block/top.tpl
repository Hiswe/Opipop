
        <a href="{ROOT_PATH}">You Survey</a>

        <h4>Menu:</h4>
        <ul id="menu">
            <li><a href="{ROOT_PATH}login">connect a new user</a></li>
            <li><a href="{ROOT_PATH}">current polls</a></li>
            <li><a href="{ROOT_PATH}archives">past polls</a></li>
        </ul>

        <h4>User logged:</h4>
        <ul id="userLogged">
            <!-- LOOP userLogged -->
            <li>{userLogged.login}</li>
            <!-- END userLogged -->
        </ul>

