
        <div id="top">
            <!-- SECTION logged -->
            <div class="userBox box">
                <a href="{{ROOT_PATH}}{{user_login}}" class="avatar"><img src="{{ROOT_PATH}}{{user_avatarUri}}" /></a>
                <div class="info">
                    <a href="{{ROOT_PATH}}{{user_login}}" class="login"><span>{{user_login}}</span></a>
                    <p class="linkList"><a href="{{ROOT_PATH}}{{user_login}}">profile</a><span>|</span><a href="{{ROOT_PATH}}logout">déconnexion</a></p>
                </div>
            </div>
            <!-- END logged -->

            <h1><a class="logo" href="{{ROOT_PATH}}">OpipPop</a></h1>
            <p class="baseLine"><a href="{{ROOT_PATH}}question/{{didyouknow_guid}}-{{didyouknow_id}}">{{didyouknow_label}}</a></p>

            <!-- SECTION notLogged -->
            <a href="{{ROOT_PATH}}remote/login" class="button nyroModal" id="login_link">Login</a>
            <!-- END notLogged -->

            <!-- SECTION feedback -->
            <p class="feedback">{{feedback}}</p>
            <!-- END feedback -->

            <!-- SECTION warning -->
            <p class="warning">{{warning}}</p>
            <!-- END warning -->
        </div>

