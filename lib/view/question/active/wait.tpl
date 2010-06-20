<<<<<<< HEAD

    <li class="user vote">
        <a href="{ROOT_PATH}{user_login}"><img src="{ROOT_PATH}{user_avatar}" alt="{user_login}" /><span>{user_login}</span></a>
        <p>mon opinion: <strong>{user_vote}</strong></p>
    </li>
    <li class="user guess">
        <p>mon pronostique: <strong>{user_guess}</strong></p>
    </li>
=======
    <p class="questionLabel">Résultats :</p>
    <!-- LOOP answer -->
        <span>{answer.label}</span>
                    <!-- LOOP answer.user -->
            <p class="user {answer.user.class}">
                <a href="{ROOT_PATH}{answer.user.login}"><img src="{ROOT_PATH}{answer.user.avatar}" alt="{answer.user.login}" /><span>{answer.user.login}</span>                    
                    </a>
                    <span>Mon opinion</span>
                    <span>Mon pronostique</span>                    
            </p>
            <!-- END answer.user -->
    <!-- END answer -->
>>>>>>> hiswe/master

