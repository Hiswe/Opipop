
        <ul id="questionArchiveContainer">
            <!-- LOOP question_archive -->
            <li class="Archives frame">
                <div class="content">
                    <h3 class="label"><a href="{ROOT_PATH}question/{question_archive.guid}-{question_archive.id}">{question_archive.label}</a></h3>
                    <div id="graph{question_archive.id}" class="graph">
                        <script type="text/javascript">
                            new pv.Panel()
                                .canvas('graph{question_archive.id}')
                                .width(60)
                                .height(60)
                            .add(pv.Wedge)
                                .data({question_archive.data})
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

                    <!-- LOOP question_archive.answer -->
                    <p class="answer key{question_archive.answer.key}">{question_archive.answer.percentFormated}% {question_archive.answer.label}</p>
                    <!-- END question_archive.answer -->

                    <p class="info">Terminé {question_archive.time}</p>
                </div>
            </li>
            <!-- END question_archive -->
        </ul>

        <!-- SECTION question_archive_navigation -->
        <div id="morePolls">
            <a href="{ROOT_PATH}" id="previousQuestionButton" class="button">&lt;&lt;</a>
            <a href="{ROOT_PATH}" id="nextQuestionButton" class="button">&gt;&gt;</a>
        </div>
        <!-- END question_archive_navigation -->

