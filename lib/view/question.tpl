
        <div class="frame" id="question">
            <h1>{{question_label}}</h1>
            <p class="info">Début: {{question_start_date}} - Fin: {{question_end_date}}.</p>

            <p class="image"><img src="{{ROOT_PATH}}{{question_image}}" alt="{{question_label}}" /></p>

            <div class="links">
                <div>
                    <a class="link button nyroModal" href="{{ROOT_PATH}}remote/question/gender?questionId={{question_id}}">Répartition H/F</a>
                </div>
                <div>
                    <a class="link button nyroModal" href="{{ROOT_PATH}}remote/question/map?questionId={{question_id}}">Carte de france</a>
                </div>
            </div>

            <div class="details">
                <div class="graph_global">
                    <script type="text/javascript">
                        var size = 190;

                        var vis = new pv.Panel()
                            .width(size)
                            .height(size);

                        var wedge = vis.add(pv.Wedge)
                            .data({{question_data}})
                            .left(size/2)
                            .bottom(size/2)
                            .innerRadius(function(){ return size/4; })
                            .outerRadius(function(){ return size/2; })
                            .angle(function(d){ return d.value * 2 * Math.PI; })
                            .lineWidth(8)
                            .strokeStyle('rgba(255,255,255,0.8)')
                            .fillStyle(function(d){ return d.color; });

                        vis.render();
                    </script>
                </div>

                <ul class="answers">
                    <!-- LOOP answer -->
                    <li class="key{{answer.key}}">
                        <div class="label">{{answer.label}} {{answer.percentFormated}}%</div>
                    </li>
                    <!-- END answer -->
                </ul>
            </div>
        </div>

        <script type="text/javascript">Question.initResults();</script>

        <ul id="share">
            <li><a href="http://twitter.com/home?status={{question_label_urlencoded}} {{ROOT_PATH}}question/p-{{question_id}}" target="_blank" title="share this question on Twitter !">Tweet this ! <img src="{{ROOT_PATH}}media/layout/tshare.png" /></a></li>
            <li><a href="http://www.facebook.com/sharer.php?u={{ROOT_PATH}}question/{{question_guid}}-{{question_id}}&t={{question_label_urlencoded}}" target="_blank" title="share this question on Facebook !">Post on facebook <img src="{{ROOT_PATH}}media/layout/fbshare.png" /></a></li>
        </ul>

        <!-- SECTION logged -->
        <h4>Moi :</h4>

        <ul>
            <li>mon vote: {{user_vote}}</li>
            <li>mon pronostique: {{user_guess}}</li>
            <li>mon pronostique concernat mes amis:
                <ul>
                    <!-- LOOP userGuessesAboutFriends -->
                    <li>
                        <a href="{{ROOT_PATH}}{{userGuessesAboutFriends.guid}}">
                            <img class="avatar" src="{{ROOT_PATH}}{{userGuessesAboutFriends.avatar}}" alt="{{userGuessesAboutFriends.login}}" />
                            <span>{{userGuessesAboutFriends.login}}</span>
                        </a>
                        <strong>{{userGuessesAboutFriends.label}}</strong>
                    </li>
                    <!-- END userGuessesAboutFriends -->
                </ul>
            </li>
        </ul>

        <h4>Mes amis :</h4>

        <ul>
            <li>leurs votes:
                <ul>
                    <!-- LOOP userFriendsVotes -->
                    <li>
                        <a href="{{ROOT_PATH}}{{userFriendsVotes.guid}}">
                            <img class="avatar" src="{{ROOT_PATH}}{{userFriendsVotes.avatar}}" alt="{{userFriendsVotes.login}}" />
                            <span>{{userFriendsVotes.login}}</span>
                        </a>
                        <strong>{{userFriendsVotes.label}}</strong>
                    </li>
                    <!-- END userFriendsVotes -->
                </ul>
            </li>
            <li>leurs pronostiques me concernant moi:
                <ul>
                    <!-- LOOP userFriendsGuessAboutMe -->
                    <li>
                        <a href="{{ROOT_PATH}}{{userFriendsGuessAboutMe.guid}}">
                            <img class="avatar" src="{{ROOT_PATH}}{{userFriendsGuessAboutMe.avatar}}" alt="{{userFriendsGuessAboutMe.login}}" />
                            <span>{{userFriendsGuessAboutMe.login}}</span>
                        </a>
                        <strong>{{userFriendsGuessAboutMe.label}}</strong>
                    </li>
                    <!-- END userFriendsGuessAboutMe -->
                </ul>
            </li>
        </ul>

        <!-- END logged -->

