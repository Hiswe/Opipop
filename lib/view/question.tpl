
            <!-- INCLUDE block/top.tpl -->

            <h1 id="question">{question_label}</h1>

			<p id="questionInfo">This question started on the {question_start_date} and ended on the {question_end_date}.</p>

            <div id="graph">
                <script type="text/javascript+protovis">
                    var vis = new pv.Panel()
                        .width(300)
                        .height(300);
                    vis.s = 0;

                    var wedge = vis.add(pv.Wedge)
                        .data(pv.normalize([33.3, 66.7]))
                        .left(150)
                        .bottom(150)
                        .innerRadius(function() 50 * vis.s)
                        .outerRadius(function() 150 * vis.s)
                        .angle(function(d) d * 2 * Math.PI)
                        .lineWidth(8)
                        .strokeStyle('white')
                        .fillStyle(function(d) (d > 0.5) ? 'CornflowerBlue' : 'fuchsia');

                    wedge.add(pv.Label)
                        .font('22px sans-serif')
                        .textStyle('white')
                        .text(function(d) (d * 100).toFixed(1) + '%')
                        .left(function() (95 * vis.s) * Math.cos(wedge.midAngle()) + 150)
                        .bottom(function() (-95 * vis.s) * Math.sin(wedge.midAngle()) + 150)
                        .textAlign("center")
                        .textBaseline("middle");

                    vis_render(vis, 1000, 'easeOutQuint');
                </script>
            </div>

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

            <ul id="share">
                <li><a href="http://twitter.com/home?status={question_label_urlencoded} {ROOT_PATH}question/p-{question_id}" target="_blank" title="share this question on Twitter !">Tweet this ! <img src="{ROOT_PATH}media/layout/tshare.png" /></a></li>
                <li><a href="http://www.facebook.com/sharer.php?u={ROOT_PATH}question/{question_guid}-{question_id}&t={question_label_urlencoded}" target="_blank" title="share this question on Facebook !">Post on facebook <img src="{ROOT_PATH}media/layout/fbshare.png" /></a></li>
            </ul>

