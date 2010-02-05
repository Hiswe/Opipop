
        <!-- INCLUDE block/top.tpl -->

        <h4>Users:</h4>

        <form id="user_search" method="post" name="user_search" action="javascript:user_search_submit();">
            <div><label>Query: <input id="user_search_query" type="text" maxlength="32" name="query" value="{search_query}" /></label></div>
            <div><input type="submit" name="submit" value="Search"></div>
        </form>

        <ul id="userList">
            <!-- LOOP user -->
            <li><strong class="user"><a href="{ROOT_PATH}{user.login}"><img src="{ROOT_PATH}{user.avatar}" alt="{user.login}" /> {user.login}</a></strong>
                <ul>
                    <!-- LOOP user.friendRequest -->
                    <li><a href="javascript:user_addToFriend({user.id});" id="addToFriend_{user.id}" class="{user.friendRequest.action}">{user.friendRequest.message}</a></li>
                    <!-- END user.friendRequest -->
                </ul>
            </li>
            <!-- END user -->
        </ul>

        <!-- INCLUDE block/pagination.tpl -->

