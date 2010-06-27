
        <div class="frame" id="question">

            <h1>{{question_label}}</h1>
            <p class="info">This question started on the {{question_start_date}} and ended on the {{question_end_date}}.</p>

            <div class="graph_women">
                <p>Femmes :</p>
                <script type="text/javascript+protovis">
                    var vis = new pv.Panel()
                        .width(120)
                        .height(120);

                    var wedge = vis.add(pv.Wedge)
                        .data({{question_women_data}})
                        .left(60)
                        .bottom(60)
                        .innerRadius(function() 20)
                        .outerRadius(function() 60)
                        .angle(function(d) d.value * 2 * Math.PI)
                        .lineWidth(8)
                        .strokeStyle('rgba(255,255,255,0.8)')
                        .fillStyle(function(d) d.color);

                    vis.render();
                </script>
            </div>

            <div class="graph_men">
                <p>Hommes :</p>
                <script type="text/javascript+protovis">
                    var vis = new pv.Panel()
                        .width(120)
                        .height(120);

                    var wedge = vis.add(pv.Wedge)
                        .data({{question_men_data}})
                        .left(60)
                        .bottom(60)
                        .innerRadius(function() 20)
                        .outerRadius(function() 60)
                        .angle(function(d) d.value * 2 * Math.PI)
                        .lineWidth(8)
                        .strokeStyle('rgba(255,255,255,0.8)')
                        .fillStyle(function(d) d.color);

                    vis.render();
                </script>
            </div>

            <a class="button nyroModal mapLink" href="{{ROOT_PATH}}remote/question/map?questionId={{question_id}}">Carte de france</a>

            <div class="graph_global">
                <script type="text/javascript+protovis">
                    var vis = new pv.Panel()
                        .width(250)
                        .height(250);

                    var wedge = vis.add(pv.Wedge)
                        .data({{question_data}})
                        .left(125)
                        .bottom(125)
                        .innerRadius(function() 50)
                        .outerRadius(function() 125)
                        .angle(function(d) d.value * 2 * Math.PI)
                        .lineWidth(8)
                        .strokeStyle('rgba(255,255,255,0.8)')
                        .fillStyle(function(d) d.color);

                    vis.render();
                </script>
            </div>

            <ul class="answers">
                <!-- LOOP answer -->
                <li class="key{{answer.key}}">
                    <div class="label">{{answer.percentFormated}}%<strong>{{answer.label}}</strong></div>
                </li>
                <!-- END answer -->
            </ul>

        </div>

        <script type="text/javascript">Question.initResults();</script>

        <ul id="share">
            <li><a href="http://twitter.com/home?status={{question_label_urlencoded}} {{ROOT_PATH}}question/p-{{question_id}}" target="_blank" title="share this question on Twitter !">Tweet this ! <img src="{{ROOT_PATH}}media/layout/tshare.png" /></a></li>
            <li><a href="http://www.facebook.com/sharer.php?u={{ROOT_PATH}}question/{{question_guid}}-{{question_id}}&t={{question_label_urlencoded}}" target="_blank" title="share this question on Facebook !">Post on facebook <img src="{{ROOT_PATH}}media/layout/fbshare.png" /></a></li>
        </ul>

