
        <!-- INCLUDE block/top.tpl -->

        <h4>Past questions:</h4>
        <ul id="questionList">
            <!-- LOOP question -->
            <li>
                <div class="question"><span>{question.date}</span> <a href="{ROOT_PATH}poll/{question.id}">{question.label}</a></div>
            </li>
            <!-- END question -->
        </ul>

        <!-- SECTION pagination -->
        <div class="pagination">
            <!-- SECTION pagination_prev -->
            <a href="{ROOT_PATH}{pagination_prev}" class="prev">&#60;&#60; prev</a>
            <!-- END pagination_prev -->

            <ul>
                <!-- LOOP pagination_1 -->
                <li class="{pagination_1.class}"><a href="{ROOT_PATH}{pagination_1.link}">{pagination_1.n}</a></li>
                <!-- END pagination_1 -->

                <!-- SECTION pagination_space1 -->
                <li><span>...</span></li>
                <!-- END pagination_space1 -->

                <!-- LOOP pagination_2 -->
                <li class="{pagination_2.class}"><a href="{ROOT_PATH}{pagination_2.link}">{pagination_2.n}</a></li>
                <!-- END pagination_2 -->

                <!-- SECTION pagination_space2 -->
                <li><span>...</span></li>
                <!-- END pagination_space2 -->

                <!-- LOOP pagination_3 -->
                <li class="{pagination_3.class}"><a href="{ROOT_PATH}{pagination_3.link}">{pagination_3.n}</a></li>
                <!-- END pagination_3 -->
            </ul>

            <!-- SECTION pagination_next -->
            <a href="{ROOT_PATH}{pagination_next}" class="next">next &#62;&#62;</a>
            <!-- END pagination_next -->
        </div>
        <!-- END pagination -->

