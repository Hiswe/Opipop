
    <ul class="friends">
        <!-- LOOP friend -->
        <li class="user">
            <a href="{{ROOT_PATH}}{{friend.login}}"><img src="{{ROOT_PATH}}{{friend.avatar}}" alt="{{friend.login}}" /><span>{{friend.login}}</span></a>
            <ul>
                <!-- LOOP friend.answer -->
                <li><span>{{friend.answer.label}}</span><input type="radio" class="guess" name="{{friend.answer.questionId}}-{{friend.answer.friendId}}" value="{{friend.answer.friendId}}-{{friend.answer.id}}" {{friend.answer.checked}}{{friend.answer.disabled}}/></li>
                <!-- END friend.answer -->
            </ul>
        </li>
        <!-- END friend -->
        <!-- SECTION save -->
        <div><button type="button" onclick="javascript:Question.guessFriend($(this), {{question_id}});">save</button></div>
        <!-- END save -->
    </ul>

