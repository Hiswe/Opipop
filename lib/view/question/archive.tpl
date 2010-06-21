
            <!-- LOOP question -->
            <li class="questionArchives frame">
                <div class="content">
                    <h3 class="label"><a href="{ROOT_PATH}question/{question.guid}-{question.id}">{question.label}</a></h3>
                    <div id="graph{question.id}" class="graph">
                        <script type="text/javascript">
                            new pv.Panel()
                                .canvas('graph{question.id}')
                                .width(60)
                                .height(60)
                            .add(pv.Wedge)
                                .data({question.data})
                                .left(30)
                                .bottom(30)
                                .innerRadius(12)
                                .outerRadius(30)
                                .angle(function(d){ return d.value * 2 * Math.PI; })
                                .lineWidth(2)
                                .strokeStyle('white')
                                .fillStyle(function(d){ return d.color; })
                            .root.render();
                        </script>
                    </div>

                    <!-- LOOP question.answer -->
                    <p class="answer key{question.answer.key}">{question.answer.percentFormated}% {question.answer.label}</p>
                    <!-- END question.answer -->

                    <p class="info">Terminé {question.time}</p>
                </div>
            </li>
            <!-- END question -->

