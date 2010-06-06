
            <ul id="share">
                <li><a href="http://twitter.com/home?status={question_label_urlencoded} {ROOT_PATH}question/p-{question_id}" target="_blank" title="share this question on Twitter !">Tweet this ! <img src="{ROOT_PATH}media/layout/tshare.png" /></a></li>
                <li><a href="http://www.facebook.com/sharer.php?u={ROOT_PATH}question/{question_guid}-{question_id}&t={question_label_urlencoded}" target="_blank" title="share this question on Facebook !">Post on facebook <img src="{ROOT_PATH}media/layout/fbshare.png" /></a></li>
            </ul>

            <h1 id="question">{question_label}</h1>

            <p id="questionInfo">This question started on the {question_start_date} and ended on the {question_end_date}.</p>

            <ul id="result">
                <!-- LOOP answer -->
                <li name="answer_{answer.id}" class="answer key{answer.key}">
                    <div class="label">{answer.label}</div>
                    <ul>
                        <!-- LOOP answer.user -->
                        <li name="user_{answer.user.id}" class="user {answer.user.class}"><a href="{ROOT_PATH}{answer.user.login}"><img src="{ROOT_PATH}{answer.user.avatar}" alt="{answer.user.login}" /><span>{answer.user.login}</span></a></li>
                        <!-- END answer.user -->
                        <!-- LOOP answer.friend -->
                        <li name="user_{answer.friend.id}" class="friend {answer.friend.class}"><a href="{ROOT_PATH}{answer.friend.login}"><img src="{ROOT_PATH}{answer.friend.avatar}" alt="{answer.friend.login}" /><span>{answer.friend.login}</span></a></li>
                        <!-- END answer.friend -->
                    </ul>
                </li>
                <!-- END answer -->
            </ul>

            <div id="questionResults">
                <ul class="menu">
                    <li class="button"><span class="link">Graph</span></li>
                    <li class="button"><span class="link">Map</span></li>
                    <li class="button"><span class="link">Details</span></li>
                </ul>

                <div class="tab">
                    <script type="text/javascript+protovis">
                        var vis = new pv.Panel()
                            .width(300)
                            .height(300);

                        var wedge = vis.add(pv.Wedge)
                            .data({question_data})
                            .left(150)
                            .bottom(150)
                            .innerRadius(function() 50)
                            .outerRadius(function() 150)
                            .angle(function(d) d.value * 2 * Math.PI)
                            .lineWidth(8)
                            .strokeStyle('white')
                            .fillStyle(function(d) d.color);

                        //var anchor = wedge.anchor('center')
                        //    .add(pv.Label)
                        //    .font('22px sans-serif')
                        //    .textStyle('white')
                        //    .text(function(d) (d.value * 100).toFixed(1) + '%');

                        wedge.add(pv.Label)
                            .font('22px sans-serif')
                            .textStyle('white')
                            .text(function(d) (d.value * 100).toFixed(1) + '%')
                            .left(function() 95 * Math.cos(wedge.midAngle()) + 150)
                            .bottom(function() -95 * Math.sin(wedge.midAngle()) + 150)
                            .textAlign("center")
                            .textBaseline("middle");

                        vis.render();
                    </script>
                </div>

                <div class="tab">
                    <div id="map"></div>
                    <script type="text/javascript" src="{ROOT_PATH}js/vis/map.js.php?questionId={question_id}"></script>
                </div>

                <div class="tab">
                    <div class="title">Men</div>
                    <div class="sexRepartition">
                        <!-- LOOP detailsMale -->
                        <div class="progress_{detailsMale.key}" style="width: {detailsMale.percent}%">{detailsMale.percentFormated}%</div>
                        <!-- END detailsMale -->
                    </div>

                    <div class="title">Women</div>
                    <div class="sexRepartition">
                        <!-- LOOP detailsFemale -->
                        <div class="progress_{detailsFemale.key}" style="width: {detailsFemale.percent}%">{detailsFemale.percentFormated}%</div>
                        <!-- END detailsFemale -->
                    </div>
                </div>
            </div>

            <script type="text/javascript">question_initResults();</script>

