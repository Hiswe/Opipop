
            <!-- INCLUDE block/top.tpl -->

            <h1 id="question">{question_label}</h1>

            <p id="questionInfo">This question started on the {question_start_date} and ended on the {question_end_date}.</p>

            <div id="graph">
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

