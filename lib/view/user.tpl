
        <div id="user_colRight">
            <h4>Statistiques :</h4>

            <div id="user_statistiques" class="box">
                <h5>Profile :</h5>
                <div id="user_feelings"></div>

                <div id="user_distance">
                    <h5>Distance avec l'opinion national :</h5>
                    <div class="country">
                        <div class="distance">{{profile_global_distance}}m</div>
                        <img class="user" src="{{ROOT_PATH}}media/layout/icon48x48/{{profile_sex}}/blue/white_brown.png" />
                    </div>

                    <h5>Distance avec l'opinion des amis :</h5>
                    <div class="friend">
                        <div class="distance">{{profile_friend_distance}}m</div>
                        <img class="user" src="{{ROOT_PATH}}media/layout/icon48x48/{{profile_sex}}/blue/white_brown.png" />
                    </div>
                </div>
            </div>

            <script type="text/javascript+protovis">Graph.feeling('user_feelings', {{feeling_data}});</script>
        </div>

        <div id="user_colLeft">

            <h4>Informations :</h4>

            <div id="user_card" class="box">
                <img class="avatar" src="{{ROOT_PATH}}{{profile_avatar}}" alt="{{profile_login}}" />

                <h1>{{profile_login}}</h1>

                <ul class="info">
                    <li>{{profile_gender}} - {{profile_region}}</li>
                </ul>

                <p class="stat">Nombre de votes : <strong>{{profile_totalVote}}</strong></p>
                <p class="stat">Nombre de bonnes prédictions : <strong>{{profile_totalPredictionWon}}</strong></p>
                <p class="stat">Nombre de mauvaises prédictions : <strong>{{profile_totalPredictionLost}}</strong></p>
                <p class="stat">Précision des prédictions : <strong>{{profile_predictionAccuracy}}%</strong></p>

                <ul class="menu">
                    <!-- SECTION friendRequest -->
                    <li><a href="#" id="friend_{{profile_id}}" class="button" title="{{friendRequest_action}}">{{friendRequest_message}}</a></li>
                    <!-- END friendRequest -->
                    <!-- SECTION private -->
                    <li><a class="button nyroModal" href="{{ROOT_PATH}}remote/user/edit?userId={{user_id}}">paramètres</a></li>
                    <!-- END private -->
                </ul>

                <div class="clear_left"></div>
            </div>

            <h4>Amis :</h4>

            <ul id="user_friends">
                <!-- SECTION noFriends -->
                <li class="noFriends">Auncun amis pour l'instant ...</li>
                <!-- END noFriends -->

                <!-- LOOP request -->
                <li class="box">
                    <ul class="edit">
                        <li id="request_{{request.id}}"><a href="#" id="accept_{{request.id}}" class="button" title="accept">accept</a></li>
                        <li id="request_{{request.id}}"><a href="#" id="reject_{{request.id}}" class="button" title="reject">reject</a></li>
                    </ul>

                    <ul class="stat">
                        <li>Cette personne veux rentrer dans vos amis ...</li>
                    </ul>

                    <a href="{{ROOT_PATH}}{{request.login}}" title="{{request.login}}">
                        <img class="avatar" src="{{ROOT_PATH}}{{request.avatar}}" alt="{{request.login}}" />
                        <strong class="login">{{request.login}}</strong>
                    </a>
                </li>
                <!-- END request -->

                <!-- LOOP friend -->
                <li class="box">
                    <!-- SECTION private -->
                    <ul class="edit">
                        <li><a href="#" id="friend_{{friend.id}}" class="button" title="remove">effacer</a></li>
                    </ul>
                    <!-- END private -->
                    <ul class="stat">
                        <!-- LOOP friend.stat -->
                        <li>précision de prédictions : <strong>{{friend.stat.predictionAccuracy}}%</strong></li>
                        <!-- END friend.stat -->
                    </ul>

                    <a href="{{ROOT_PATH}}{{friend.login}}" title="{{friend.login}}">
                        <img class="avatar" src="{{ROOT_PATH}}{{friend.avatar}}" />
                        <strong class="login">{{friend.login}}</strong>
                    </a>
                </li>
                <!-- END friend -->
            </ul>
        </div>

