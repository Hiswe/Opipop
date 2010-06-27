
    <div id="question_gender" class="modal">
        <div class="graph_men">
            <p>Hommes :</p>
            <div id="graph_men"></div>
            <script type="text/javascript">
                var vis = new pv.Panel()
                    .canvas('graph_men')
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

        <div class="graph_women">
            <p>Femmes :</p>
            <div id="graph_women"></div>
            <script type="text/javascript">
                var vis = new pv.Panel()
                    .canvas('graph_women')
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
    </div>

