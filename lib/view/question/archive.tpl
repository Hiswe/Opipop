
        <!-- SECTION NOT_AJAX -->
        <h4>Sondages passés:</h4>
        <!-- END NOT_AJAX -->

        <ul id="question_archive">
            <!-- LOOP question_archive -->
            <li class="question box">
                <div class="content">
                    <!--<p class="info">Terminé {{question_archive.time}}</p>-->

                    <a class="gender link button nyroModal" href="{{ROOT_PATH}}remote/question/gender?questionId={{question_archive.id}}">Répartition H/F</a>

                    <div id="graph{{question_archive.id}}" class="graph">
                        <script type="text/javascript">
                            new pv.Panel()
                                .canvas('graph{{question_archive.id}}')
                                .width(60)
                                .height(60)
                            .add(pv.Wedge)
                                .data({{question_archive.data}})
                                .left(30)
                                .bottom(30)
                                .innerRadius(12)
                                .outerRadius(30)
                                .angle(function(d){{ return d.value * 2 * Math.PI; }})
                                .lineWidth(2)
                                .strokeStyle('white')
                                .fillStyle(function(d){{ return d.color; }})
                            .root.render();
                        </script>
                    </div>

                    <h2 class="label"><a href="{{ROOT_PATH}}question/{{question_archive.guid}}-{{question_archive.id}}">{{question_archive.label}}</a></h2>

                    <!-- LOOP question_archive.answer -->
                    <p class="answer key{{question_archive.answer.key}}">{{question_archive.answer.percentFormated}}% {{question_archive.answer.label}}</p>
                    <!-- END question_archive.answer -->
                </div>
            </li>
            <!-- END question_archive -->
        </ul>

        <!-- SECTION NOT_AJAX -->
        <div id="question_archive_navigation">
            <a href="{{ROOT_PATH}}" id="previousQuestionButton" class="button disable">&lt;&lt; précédent</a>
            <a href="{{ROOT_PATH}}" id="nextQuestionButton" class="button">suivant &gt;&gt;</a>
        </div>
        <!-- END NOT_AJAX -->

