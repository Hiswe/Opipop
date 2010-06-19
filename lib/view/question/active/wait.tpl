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

