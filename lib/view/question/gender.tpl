
    <div id="question_gender" class="modal">

        <div class="graph">
            <p>Hommes :</p>
            <div id="graph_men"></div>
            <script type="text/javascript">
                var size = 150;
                var vis = new pv.Panel()
                    .canvas('graph_men')
                    .width(size)
                    .height(size);

                var wedge = vis.add(pv.Wedge)
                    .data({{question_men_data}})
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
            <ul>
                <!-- LOOP question_men -->
                <li class="key{{question_men.key}}">{{question_men.label}}: {{question_men.percent}}%</li>
                <!-- END question_men -->
            </ul>
        </div>

        <div class="graph">
            <p>Femmes :</p>
            <div id="graph_women"></div>
            <script type="text/javascript">
                var size = 150;
                var vis = new pv.Panel()
                    .canvas('graph_women')
                    .width(size)
                    .height(size);

                var wedge = vis.add(pv.Wedge)
                    .data({{question_women_data}})
                    .left(size/2)
                    .bottom(size/2)
                    .innerRadius(function(){ return size/4; })
                    .outerRadius(function(){ return size/2; })
                    .angle(function(d){ return d.value * 2 * Math.PI; })
                    .lineWidth(8)
                    .strokeStyle('rgba(255,255,255,0.8)')
                    .fillStyle(function(d){ return d.color});

                vis.render();
            </script>
            <ul>
                <!-- LOOP question_women -->
                <li class="key{{question_women.key}}">{{question_women.label}}: {{question_women.percent}}%</li>
                <!-- END question_women -->
            </ul>
        </div>

        <div class="clear"></div>

    </div>

