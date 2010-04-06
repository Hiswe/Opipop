
    <!-- LOOP answer -->
    <li>
        <span>{answer.label}</span>
        <ul>
            <!-- LOOP answer.user -->
            <li class="user {answer.user.class}">
                <a href="{ROOT_PATH}{answer.user.login}"><img src="{ROOT_PATH}{answer.user.avatar}" alt="{answer.user.login}" /><span>{answer.user.login}</span></a>
            </li>
            <!-- END answer.user -->
        </ul>
    </li>
    <!-- END answer -->

