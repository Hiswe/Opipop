
    <div id="question_gender" class="modal">

        <h2>#{question_label}</h2>

        <div class="graph">
            <div id="graph_men"></div>

            <p>Hommes :</p>
            <ul>
                <!-- LOOP question_men -->
                <li class="key#{question_men.key}">#{question_men.label} : <strong>#{question_men.percent}%</strong></li>
                <!-- END question_men -->
            </ul>
        </div>

        <div class="graph">
            <div id="graph_women"></div>
            <p>Femmes :</p>
            <ul>
                <!-- LOOP question_women -->
                <li class="key#{question_women.key}">#{question_women.label} : <strong>#{question_women.percent}%</strong></li>
                <!-- END question_women -->
            </ul>
        </div>

        <script type="text/javascript">Graph.gender('graph_men', 'mal', #{question_men_data});</script>
        <script type="text/javascript">Graph.gender('graph_women', 'femal', #{question_women_data});</script>

        <div class="clear"></div>
    </div>

