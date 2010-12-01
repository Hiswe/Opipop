<div id="userContainer" class="firstBackground">
    <div id="user" class="horizontalCenter">
        <h4>
            Informations
            <a href="{{ROOT_PATH}}remote/info?info=user_information" class="info_bulle nyroModal" title="informations"><i class="icon iconInfo">informations</i></a>
        </h4>

        <div id="user_card" class="box">
            <div id="user_feelings"></div>
            <script type="text/javascript+protovis">Graph.feeling('user_feelings', {{feeling_data}});</script>
            <img id="userAvatar" src="{{ROOT_PATH}}{{profile_avatar}}" alt="{{profile_login}}" />            
            <h1>{{profile_login}}</h1>
            <div id="profileInfo">
                <dl>
                    <dt>Votes : </dt>
                    <dd>{{profile_totalVote}}</dd>
                </dl>
                <dl>
                    <dt>Bonnes prédictions : </dt>
                    <dd>{{profile_totalPredictionWon}}</dd>
                </dl>
                <dl>
                    <dt>Mauvaises prédictions : </dt>
                    <dd>{{profile_totalPredictionLost}}</dd>
                </dl>
                <dl>
                    <dt>Précision des prédictions : </dt>
                    <dd>{{profile_predictionAccuracy}}%</dd>
                </dl>
            </div>
            <div id="distance">
                <div class="country">
                    <h5>Distance avec l'opinion national</h5>
                    <div class="distance">{{profile_global_distance}}m</div>
                    <img class="user" src="{{ROOT_PATH}}media/layout/icon48x48/{{profile_sex}}/blue/white_brown.png" />
                </div>

                <div class="friend">
                    <h5>Distance avec l'opinion des amis</h5>
                    <div class="distance">{{profile_friend_distance}}m</div>
                    <img class="user" src="{{ROOT_PATH}}media/layout/icon48x48/{{profile_sex}}/blue/white_brown.png" />
                </div>
            </div>                                                              
            <div id="user_proximity">
                <h5>Quels amis le connaissent le mieux</h5>
                <img class="user" src="{{ROOT_PATH}}media/layout/icon48x48/{{profile_sex}}/blue/white_brown.png" />
                <div class="content">
                    <div class="percent position0"><span>0%</span></div>
                    <div class="percent position25"><span>25%</span></div>
                    <div class="percent position50"><span>50%</span></div>
                    <div class="percent position75"><span>75%</span></div>
                    <div class="percent position100"><span>100%</span></div>
                <!-- LOOP friend -->
                    <!-- LOOP friend.stat -->
                    <img class="avatar" style="left:{{friend.stat.predictionAccuracy_his}}%;z-index:{{friend.stat.predictionAccuracy_his}};" title="{{friend.login}} ({{friend.stat.predictionAccuracy_his}}%)" src="{{ROOT_PATH}}{{friend.avatar_small}}" />
                    <!-- END friend.stat -->
                <!-- END friend -->
                </div>
            </div>
        <div class="clear"></div>
    </div>
</div>
<div id="friendContainer" class="secondBackground">
    <div id="friend" class="horizontalCenter">
        <div id="friend_header">
            <h4>
                Amis
                <a href="{{ROOT_PATH}}remote/info?info=user_friends" class="info_bulle nyroModal" title="informations"><i class="icon iconInfo">informations</i></a>
            </h4>
            <!-- SECTION private -->
            <form id="user_search">
                <label>
                    <input id="user_search_query" type="text" maxlength="32" name="query" value="" />
                </label>
                <div class="overlay">Rechercher un amis ...</div>
            </form>
            <!-- END private -->
        </div>

        <!-- SECTION private -->
        <ul id="user_search_result"></ul>
        <hr></hr>
        <!-- END private -->
        <ul id="user_friends" class="box">
            <!-- SECTION noFriends -->
            <li class="noFriends">Auncun amis pour l'instant ...</li>
            <!-- END noFriends -->

            <!-- LOOP request -->
            <li>
                <ul class="edit">
                    <li id="request_{{request.id}}"><a href="#" id="accept_{{request.id}}" class="button" title="accept"><i class="icon iconAdd"></i>accept</a></li>
                    <li id="request_{{request.id}}"><a href="#" id="reject_{{request.id}}" class="button" title="reject"><i class="icon iconRemove"></i>reject</a></li>
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
            <li>
                <!-- SECTION private -->
                <ul class="edit">
                    <li><a href="#" id="friend_{{friend.id}}" class="button" title="remove"><i class="icon iconRemove"></i>effacer</a></li>
                </ul>
                <!-- END private -->
                <ul class="stat">
                    <!-- LOOP friend.stat -->
                    <li>précision de prédictions : <strong>{{friend.stat.predictionAccuracy_my}}%</strong></li>
                    <!-- END friend.stat -->
                </ul>

                <a href="{{ROOT_PATH}}{{friend.login}}" title="{{friend.login}}">
                    <img class="avatar" src="{{ROOT_PATH}}{{friend.avatar_medium}}" />
                    <strong class="login">{{friend.login}}</strong>
                </a>
            </li>
            <!-- END friend -->
        </ul>
    </div>
</div>
