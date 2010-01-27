
        <!-- INCLUDE block/top.tpl -->

        <h4>Users:</h4>

        <form id="user_search" method="post" name="user_search" action="javascript:user_search_submit();">
            <div><label>Query: <input id="user_search_query" type="text" maxlength="32" name="query" value="{search_query}" /></label></div>
            <div><input type="submit" name="submit" value="Search"></div>
        </form>

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

