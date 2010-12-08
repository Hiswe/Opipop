<div id="topContainer">
        <div id="top" class="horizontalCenter">
            <!-- SECTION logged -->
            <div class="userBox box">
                <a href="{{ROOT_PATH}}{{user_login}}" class="avatar"><img src="{{user_avatarURL}}" /></a>
                <div class="info">
                    <a href="{{ROOT_PATH}}{{user_login}}" class="name"><span>{{user_login}}</span></a>
                    <p class="linkList">
                        <a class="nyroModal" href="{{ROOT_PATH}}remote/user/edit?userId={{user_id}}">paramètres</a>
                        <span>|</span>
                        <a href="{{ROOT_PATH}}logout">déconnexion</a>
                    </p>
                </div>
            </div>
            <!-- END logged -->

            <!-- SECTION notLogged -->
            <a href="{{ROOT_PATH}}remote/login" class="login button nyroModal" class="">Connectez vous !</a>
            <!-- END notLogged -->

            <h1><a class="logo" href="{{ROOT_PATH}}">OpipPop</a></h1>
            <!--<p class="baseLine"><a href="{{ROOT_PATH}}question/{{didyouknow_guid}}-{{didyouknow_id}}">{{didyouknow_label}}</a></p>-->

            <!-- SECTION feedback -->
            <p class="message feedback">{{feedback}}</p>
            <!-- END feedback -->

            <!-- SECTION warning -->
            <p class="message warning">{{warning}}</p>
            <!-- END warning -->
        </div>
</div>
