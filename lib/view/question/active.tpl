<div id="activeContainer" class="firstBackground">
    <div id="active" class="horizontalCenter">
        <div class="clear"></div>

        <h4>
            Sondages en cours
            <a href="{{ROOT_PATH}}remote/info?info=question_active" class="info_bulle nyroModal" title="informations"><i class="icon iconInfo">informations</i></a>
        </h4>

        <ul id="question_active">
            <!-- LOOP question -->
            <li class="question box" id="{{question.id}}">

                <dt class="preview">
                    <img src="{{ROOT_PATH}}{{question.image}}" alt="{{question.label}}" />
                    <p>fin du sondage dans {{question.time}}</p>
                </dt>

                <h2>{{question.label}}</h2>

                <!--
                <div class="share">
                    <a href="http://twitter.com/home?status={{question.label_urlencoded}} {{ROOT_PATH}}question/p-{{question.id}}" target="_blank" title="share this question on Twitter !"><img src="{{ROOT_PATH}}media/layout/tshare.png" /></a>
                    <a href="http://www.facebook.com/sharer.php?u={{ROOT_PATH}}question/{{question.guid}}-{{question.id}}&t={{question.label_urlencoded}}" target="_blank" title="share this question on Facebook !"><img src="{{ROOT_PATH}}media/layout/fbshare.png" /></a>
                </div>
                -->

                <div class="right">

                    <ul class="answers">
                        <!-- LOOP question.answer -->
                        <li class="answer droppable" id="answer.{{question.id}}.{{question.answer.id}}">
                            <strong class="label">{{question.answer.label}} :</strong>
                            <ul class="group">
                                <!-- LOOP question.answer.user -->
                                <li class="user draggable {{question.answer.user.class}}" id="{{question.answer.user.class}}.{{question.id}}.{{question.answer.user.id}}">
                                    <img class="avatar" src="{{ROOT_PATH}}{{question.answer.user.image}}" alt="{{question.answer.user.login}}" />
                                    <span>{{question.answer.user.label}}</span>
                                </li>
                                <!-- END question.answer.user -->
                                <!-- LOOP question.answer.friend -->
                                <li class="friend draggable {{question.answer.friend.class}}" id="friend.{{question.id}}.{{question.answer.friend.userId}}.{{question.answer.friend.id}}">
                                    <img class="avatar" src="{{ROOT_PATH}}{{question.answer.friend.avatar}}" alt="{{question.answer.friend.login}}" />
                                    <span>{{question.answer.friend.login}}</span>
                                </li>
                                <!-- END question.answer.friend -->
                                <li class="message"><!-- LOOP question.answer.message -->{{question.answer.message.label}}<!-- END question.answer.message --></li>
                            </ul>
                            <div class="clear_left"></div>
                        </li>
                        <!-- END question.answer -->
                    </ul>

                    <ul class="pending droppable" id="pending.{{question.id}}">
                        <li><strong class="label">En attente :</strong></li>
                        <ul class="group">
                            <!-- LOOP question.pendingUser -->
                            <li class="user draggable {{question.pendingUser.class}}" id="{{question.pendingUser.class}}.{{question.id}}.{{question.pendingUser.id}}">
                                <img class="avatar" src="{{ROOT_PATH}}{{question.pendingUser.avatar}}" alt="{{question.pendingUser.login}}" />
                                <span>{{question.pendingUser.label}}</span>
                            </li>
                            <!-- END question.pendingUser -->
                            <!-- LOOP question.pendingFriend -->
                            <li class="friend draggable {{question.pendingFriend.class}}" id="friend.{{question.id}}.{{question.pendingFriend.userId}}.{{question.pendingFriend.id}}">
                                <img class="avatar" src="{{ROOT_PATH}}{{question.pendingFriend.avatar}}" alt="{{question.pendingFriend.login}}" />
                                <span>{{question.pendingFriend.login}}</span>
                            </li>
                            <!-- END question.pendingFriend -->
                            <li class="message"><!-- LOOP question.message -->{{question.message.label}}<!-- END question.message --></li>
                        </ul>
                        <div class="clear"></div>
                    </ul>

                </div>

                <div class="clear"></div>

            </li>
            <!-- END question -->
        </ul>
    </div>
</div>
