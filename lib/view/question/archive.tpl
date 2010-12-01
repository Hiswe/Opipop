<!-- SECTION NOT_AJAX -->
<div id="archiveContainer" class="secondBackground">
    <div id="archive" class="horizontalCenter">
        <h4>
            Sondages passés
            <a href="{{ROOT_PATH}}remote/info?info=question_archive" class="info_bulle nyroModal" title="informations"><i class="icon iconInfo">informations</i></a>
        </h4>
        <!-- END NOT_AJAX -->

        <ul id="question_archive" class="box">
            <!-- LOOP question_archive -->
            <li class="question">
                <div class="content">
                    <!--<p class="info">Terminé {{question_archive.time}}</p>-->

                    <a class="gender link button nyroModal" href="{{ROOT_PATH}}remote/question/gender?questionId={{question_archive.id}}"><i class="icon iconGender"></i>Répartition H/F</a>
                    <!-- SECTION v2 -->
                    <a class="map link button nyroModal" href="{{ROOT_PATH}}remote/question/map?questionId={{question_archive.id}}"><i class="icon iconMap"></i>National</a>
                    <!-- END v2 -->

                    <div id="graph{{question_archive.id}}" class="graph">
                        <script type="text/javascript">Graph.archive('graph{{question_archive.id}}', {{question_archive.data}}, 75);</script>
                    </div>

                    <h2 class="label">{{question_archive.label}}</h2>

                    <!-- LOOP question_archive.answer -->
                    <p class="answer key{{question_archive.answer.key}}">{{question_archive.answer.percentFormated}}% {{question_archive.answer.label}}</p>
                    <!-- END question_archive.answer -->
                </div>
            </li>
            <!-- END question_archive -->
        </ul>

        <!-- SECTION AJAX -->
        <script type="text/javascript">$('#question_archive a.nyroModal').nyroModal();</script>
        <!-- END AJAX -->

        <!-- SECTION NOT_AJAX -->
        <div id="question_archive_navigation">
            <a href="{{ROOT_PATH}}" id="previousQuestionButton" class="button disable">&lt;&lt; précédent</a>
            <a href="{{ROOT_PATH}}" id="nextQuestionButton" class="button">suivant &gt;&gt;</a>
        </div>
    </div>
</div>
<!-- END NOT_AJAX -->
