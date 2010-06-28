
        <ul id="questions">
            <!-- LOOP question -->
            <li class="question frame" id="{{question.id}}">
                <h2 class="{{question.class}} questionTitle">{{question.label}}</h2>

                <div class="clear">

                    <ul>
                        <!-- LOOP question.answer -->
                        <li class="answer droppable" id="answer.{{question.id}}.{{question.answer.id}}">
                            <strong>{{question.answer.label}}</strong>
                            <ul class="user">
                                <!-- LOOP question.answer.user -->
                                <li class="draggable {{question.answer.user.class}}" id="{{question.answer.user.class}}.{{question.id}}.{{question.answer.user.id}}">{{question.answer.user.login}}</li>
                                <!-- END question.answer.user -->
                            </ul>
                            <ul class="friend">
                                <!-- LOOP question.answer.friend -->
                                <li class="draggable {{question.answer.friend.class}}" id="friend.{{question.id}}.{{question.answer.friend.userId}}.{{question.answer.friend.id}}">{{question.answer.friend.login}}</li>
                                <!-- END question.answer.friend -->
                            </ul>
                        </li>
                        <!-- END question.answer -->
                    </ul>

                    <ul class="pending droppable" id="pendding.{{question.id}}">
                        <!-- LOOP question.pendingUser -->
                        <li class="draggable {{question.pendingUser.class}}" id="{{question.pendingUser.class}}.{{question.id}}.{{question.pendingUser.id}}">{{question.pendingUser.label}}</li>
                        <!-- END question.pendingUser -->
                        <!-- LOOP question.pendingFriend -->
                        <li class="draggable {{question.pendingFriend.class}}" id="friend.{{question.id}}.{{question.pendingFriend.userId}}.{{question.pendingFriend.id}}">{{question.pendingFriend.login}}</li>
                        <!-- END question.pendingFriend -->
                    </ul>

                </div>

            </li>
            <!-- END question -->
        </ul>

