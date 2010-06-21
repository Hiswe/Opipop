
        <div id="colRight">
            <div id="user" class="frame">
                <img class="avatar" src="{ROOT_PATH}{profile_avatar}" alt="{profile_login}" />
                <ul class="info">
                    <li><h1>{profile_login}</h1></li>
                    <li>{profile_gender} - {profile_region}</li>
                    <li>{profile_totalVote} votes</li>
                </ul>
                <p class="distance_global">Distance par rapport a l'opinion public:<strong>{profile_global_distance} mètres</strong></p>
                <p class="distance_friend">Distance par rapport a vos amis:<strong>{profile_friend_distance} mètres</strong></p>
            </div>

            <h4>Friends:</h4>
            <ul id="friends">
                <!-- LOOP friendPredictionAccuracy -->
                <li class="frame">
                    <a href="{ROOT_PATH}{friendPredictionAccuracy.login}" title="{friendPredictionAccuracy.login}">
                        <img src="{ROOT_PATH}{friendPredictionAccuracy.avatar}" />
                        <strong>{friendPredictionAccuracy.login}</strong>
                    </a>
                    <span>précision de vos prédictions: {friendPredictionAccuracy.percent}%</span>
                </li>
                <!-- END friendPredictionAccuracy -->
            </ul>
        </div>

        <div id="colLeft">
            <h4>Statistiques:</h4>
        </div>

        <!-- DONt TOUCH ABOVE I WILL MAKE IT RIGHT LATER :) -->

        <!--
        <ul id="friends">
            <!-- LOOP friend -->
            <li class="user"><a href="{ROOT_PATH}{friend.login}"><img src="{ROOT_PATH}{friend.avatar}" alt="{friend.login}" /> {friend.login}</a></li>
            <!-- END friend -->
        </ul>

        <ul id="menu">
            <!-- SECTION friendRequest -->
            <li><a href="javascript:User.addToFriend({profile_id}, true);" id="addToFriend_{profile_id}" class="{friendRequest_action}">{friendRequest_message}</a></li>
            <!-- END friendRequest -->
            <!-- SECTION private -->
            <li><a href="{ROOT_PATH}{profile_login}">profile</a></li>
            <li><a href="{ROOT_PATH}{profile_login}/edit">edit infos</a></li>
            <!-- END private -->
        </ul>

        <!-- SECTION friendPendingRequest -->
        <h4>Friend requests:</h4>
        <ul>
            <!-- LOOP request -->
            <li class="user"><a href="{ROOT_PATH}{request.login}"><img src="{ROOT_PATH}{request.avatar}" alt="{request.login}" /> {request.login}</a>: <span id="request_{request.id}"><a href="javascript:User.requestFriend({request.id}, true);">accept</a> / <a href="javascript:User.requestFriend({request.id}, false);">reject</a></span></li>
            <!-- END request -->
        </ul>
        <!-- END friendPendingRequest -->

        <h4>Stats:</h4>
        <ul>
            <li><strong>vote count:</strong> {profile_totalVote}</li>
            <li><strong>prediction won:</strong> {profile_totalPredictionWon}</li>
            <li><strong>prediction lost:</strong> {profile_totalPredictionLost}</li>
            <li><strong>prediction accuracy:</strong> {profile_predictionAccuracy}%</li>
            <li><strong>distance from popular opinion:</strong> {profile_global_distance}m</li>
        </ul>
        <ul>
            <li><strong>distance from your friends opinion:</strong> {profile_friend_distance}m</li>
        </ul>
        <ul>
            <li>
                <ul>
                    <!-- LOOP feeling -->
                    <li><strong>{feeling.label}:</strong> {feeling.percent}%</li>
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
                    .data({feeling_data})
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

