
    <div id="question_map" class="modal">
        <h2>{{question_label}}</h2>

        <ul>
            <!-- LOOP answer -->
            <li class="key{{answer.key}}">{{answer.label}} : <strong>{{answer.percent}}%</strong></li>
            <!-- END answer -->
        </ul>

        <div id="question_map_graph" class="modal"></div>
    </div>
    <script type="text/javascript">Graph.map('question_map_graph', {{map_regionColors}}, {{map_regionValues}});</script>

