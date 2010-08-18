
        <div id="user_colRight">

            <h4>Vous :</h4>

            <div id="user_card" class="box">
                <img class="avatar" src="{{ROOT_PATH}}{{profile_avatar}}" alt="{{profile_login}}" />

                <h1>{{profile_login}}</h1>

                <ul class="info">
                    <li>{{profile_gender}} - {{profile_region}}</li>
                    <li>{{profile_totalVote}} votes</li>
                </ul>

                <p class="stat">Distance par rapport a l'opinion public : <strong>{{profile_global_distance}} mètres</strong></p>
                <p class="stat">Distance par rapport a vos amis : <strong>{{profile_friend_distance}} mètres</strong></p>
                <p class="stat">Nombre de votes : <strong>{{profile_totalVote}}</strong></p>
                <p class="stat">Nombre de bonnes prédictions : <strong>{{profile_totalPredictionWon}}</strong></p>
                <p class="stat">Nombre de mauvaises prédictions : <strong>{{profile_totalPredictionLost}}</strong></p>
                <p class="stat">Précision des prédictions : <strong>{{profile_predictionAccuracy}}%</strong></p>

                <div class="clear"></div>
            </div>

            <h4>Friends:</h4>

            <ul id="user_friends">
                <!-- LOOP friend -->
                <li class="box">
                    <!-- SECTION private -->
                    <ul class="edit">
                        <li><a href="#" id="friend_{{friend.id}}" class="button" title="remove">effacer</a></li>
                    </ul>
                    <ul class="stat">
                        <!-- LOOP friend.stat -->
                        <li>précision de mes prédictions : <strong>{{friend.stat.predictionAccuracy}}%</strong></li>
                        <!-- END friend.stat -->
                    </ul>
                    <!-- END private -->

                    <a href="{{ROOT_PATH}}{{friend.login}}" title="{{friend.login}}">
                        <img class="avatar" src="{{ROOT_PATH}}{{friend.avatar}}" />
                        <strong class="login">{{friend.login}}</strong>
                    </a>
                </li>
                <!-- END friend -->
            </ul>
        </div>

        <div id="user_colLeft">
            <h4>Vos statistiques :</h4>
        </div>

        <!-- DONT TOUCH ABOVE I WILL MAKE IT RIGHT LATER :) -->

        <!--
        <ul id="menu">
            <!-- SECTION friendRequest -->
            <li><a href="javascript:User.addToFriend({{profile_id}}, true);" id="addToFriend_{{profile_id}}" class="{{friendRequest_action}}">{{friendRequest_message}}</a></li>
            <!-- END friendRequest -->
            <!-- SECTION private -->
            <li><a href="{{ROOT_PATH}}{{profile_login}}">profile</a></li>
            <li><a href="{{ROOT_PATH}}{{profile_login}}/edit">edit infos</a></li>
            <!-- END private -->
        </ul>

        <!-- SECTION friendPendingRequest -->
        <h4>Friend requests:</h4>
        <ul>
            <!-- LOOP request -->
            <li class="user"><a href="{{ROOT_PATH}}{{request.login}}"><img src="{{ROOT_PATH}}{{request.avatar}}" alt="{{request.login}}" /> {{request.login}}</a>: <span id="request_{{request.id}}"><a href="javascript:User.requestFriend({{request.id}}, true);">accept</a> / <a href="javascript:User.requestFriend({{request.id}}, false);">reject</a></span></li>
            <!-- END request -->
        </ul>
        <!-- END friendPendingRequest -->

        <h4>Feelings:</h4>
        <ul>
            <li>
                <ul>
                    <!-- LOOP feeling -->
                    <li><strong>{{feeling.label}}:</strong> {{feeling.percent}}%</li>
                    <!-- END feeling -->
                </ul>
            </li>
        </ul>

        <div id="userFeeling">
            <script type="text/javascript+protovis">
                var vis = new pv.Panel()
                    .width(300)
                    .height(300);

                var wedge = vis.add(pv.Wedge)
                    .data({{feeling_data}})
                    .left(150)
                    .bottom(150)
                    .outerRadius(function(d) Math.sqrt(d.value) * 150)
                    .angle(2 * Math.PI / 5)
                    .lineWidth(8)
                    .strokeStyle('white')
                    .fillStyle(function(d) d.color);

                wedge.add(pv.Label)
                    .left(function() 45 * Math.cos(wedge.midAngle()) + 150)
                    .bottom(function() -45 * Math.sin(wedge.midAngle()) + 150)
                    .text(function(d) d.value)
                    .textAlign("center")
                    .textBaseline("middle")
                    .font('14px sans-serif')
                    .textStyle('Grey');

                wedge.add(pv.Label)
                    .left(function() 110 * Math.cos(wedge.midAngle()) + 150)
                    .bottom(function() -110 * Math.sin(wedge.midAngle()) + 150)
                    .textAlign("center")
                    .textBaseline("middle")
                    .font('10px sans-serif')
                    .textStyle('Grey')
                    .text(function(d) d.label);

                vis.render();
            </script>
        </div>
        -->

