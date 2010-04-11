
        <ul id="questionArchiveList">
            <!-- LOOP question -->
            <li class="question">
                <div class="label"><a href="{ROOT_PATH}question/{question.guid}-{question.id}">{question.label}</a></div>
                <div id="graph{question.id}" class="graph">
                    <script type="text/javascript">
                        new pv.Panel()
                            .canvas('graph{question.id}')
                            .width(100)
                            .height(100)
                        .add(pv.Wedge)
                            .data({question.data})
                            .left(50)
                            .bottom(50)
                            .innerRadius(12)
                            .outerRadius(50)
                            .angle(function(d){ return d.value * 2 * Math.PI; })
                            .lineWidth(2)
                            .strokeStyle('white')
                            .fillStyle(function(d){ return d.color; })
                        .root.render();
                    </script>
                </div>
                <ul class="answers">
                    <!-- LOOP question.answer -->
                    <li class="answer key{question.answer.key}">{question.answer.label}<br/>{question.answer.percentFormated}</li>
                    <!-- END question.answer -->
                </ul>
            </li>
            <!-- END question -->
        </ul>

