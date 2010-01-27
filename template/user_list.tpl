
        <!-- INCLUDE block/top.tpl -->

        <h4>Users:</h4>
        <ul id="userList">
            <!-- LOOP user -->
            <li><strong><a href="{ROOT_PATH}{user.login}">{user.login}</a></strong>
                <ul>
                    <li>nb vote: {user.vote}</li>
                    <li>registered since {user.register_since}</li>
                </ul>
            </li>
            <!-- END user -->
        </ul>

        <!-- INCLUDE block/pagination.tpl -->

