
        <ul id="questions">
            <!-- LOOP question -->
            <li class="question frame" id="{{question.id}}">

                <h2>{{question.label}}</h2>

                <div class="share">
                    <a href="http://twitter.com/home?status={{question.label_urlencoded}} {{ROOT_PATH}}question/p-{{question.id}}" target="_blank" title="share this question on Twitter !"><img src="{{ROOT_PATH}}media/layout/tshare.png" /></a>
                    <a href="http://www.facebook.com/sharer.php?u={{ROOT_PATH}}question/{{question.guid}}-{{question.id}}&t={{question.label_urlencoded}}" target="_blank" title="share this question on Facebook !"><img src="{{ROOT_PATH}}media/layout/fbshare.png" /></a>
                </div>

                <dt>
                    <img src="{{ROOT_PATH}}{{question.image}}" alt="{{question.label}}" />
                </dt>

                <div class="clear">

                    <ul class="answers">
                        <!-- LOOP question.answer -->
                        <li class="answer droppable" id="answer.{{question.id}}.{{question.answer.id}}">
                            <strong>{{question.answer.label}}</strong>
                            <ul class="user">
                                <!-- LOOP question.answer.user -->
                                <li class="draggable {{question.answer.user.class}}" id="{{question.answer.user.class}}.{{question.id}}.{{question.answer.user.id}}">
                                    <img class="avatar" src="{{ROOT_PATH}}{{question.answer.user.avatar}}" alt="{{question.answer.user.login}}" />
                                    {{question.answer.user.label}}
                                </li>
                                <!-- END question.answer.user -->
                            </ul>
                            <ul class="friend">
                                <!-- LOOP question.answer.friend -->
                                <li class="draggable {{question.answer.friend.class}}" id="friend.{{question.id}}.{{question.answer.friend.userId}}.{{question.answer.friend.id}}">
                                    <img class="avatar" src="{{ROOT_PATH}}{{question.answer.friend.avatar}}" alt="{{question.answer.friend.login}}" />
                                    {{question.answer.friend.login}}
                                </li>
                                <!-- END question.answer.friend -->
                            </ul>
                        </li>
                        <!-- END question.answer -->
                    </ul>

                    <ul class="pending droppable" id="pending.{{question.id}}">
                        <strong>En attente :</strong>
                        <!-- LOOP question.pendingUser -->
                        <li class="draggable {{question.pendingUser.class}}" id="{{question.pendingUser.class}}.{{question.id}}.{{question.pendingUser.id}}">
                            <img class="avatar" src="{{ROOT_PATH}}{{question.pendingUser.avatar}}" alt="{{question.pendingUser.login}}" />
                            {{question.pendingUser.label}}
                        </li>
                        <!-- END question.pendingUser -->
                        <!-- LOOP question.pendingFriend -->
                        <li class="draggable {{question.pendingFriend.class}}" id="friend.{{question.id}}.{{question.pendingFriend.userId}}.{{question.pendingFriend.id}}">
                            <img class="avatar" src="{{ROOT_PATH}}{{question.pendingFriend.avatar}}" alt="{{question.pendingFriend.login}}" />
                            {{question.pendingFriend.login}}
                        </li>
                        <!-- END question.pendingFriend -->
                    </ul>

                </div>

            </li>
            <!-- END question -->
        </ul>

