
        <!-- INCLUDE block/top.tpl -->

        <h1>{user_login}</h1>
		<div><img src="{ROOT_PATH}media/avatar/{avatar}" alt="{user_login}" /></div>

        <!-- INCLUDE block/user_menu.tpl -->

        <h4>Friends:</h4>
        <ul>
            <!-- LOOP friend -->
            <li class="user"><a href="{ROOT_PATH}{friend.login}"><img src="{ROOT_PATH}media/avatar/{friend.avatar}" alt="{friend.login}" /> {friend.login}</a></li>
            <!-- END friend -->
        </ul>

        <!-- SECTION friendPendingRequest -->
        <h4>Friend requests:</h4>
        <ul>
            <!-- LOOP request -->
            <li class="user"><a href="{ROOT_PATH}{request.login}"><img src="{ROOT_PATH}media/avatar/{request.avatar}" alt="{request.login}" /> {request.login}</a>: <span id="request_{request.id}"><a href="javascript:user_requestFriend({request.id}, true);">accept</a> / <a href="javascript:user_requestFriend({request.id}, false);">reject</a></span></li>
            <!-- END request -->
        </ul>
        <!-- END friendPendingRequest -->

        <h4>Stats:</h4>
		<ul>
			<li><strong>vote count:</strong> {user_totalVote}</li>
			<li><strong>prediction won:</strong> {user_totalPredictionWon}</li>
			<li><strong>prediction lost:</strong> {user_totalPredictionLost}</li>
			<li><strong>prediction accuracy:</strong> {user_predictionAccuracy}%</li>
			<li><strong>distance from popular opinion:</strong> {user_global_distance}m</li>
			<li><strong>distance from your friends opinion:</strong> {user_friend_distance}m</li>
			<li><strong>personality:</strong>
				<ul>
					<!-- LOOP feeling -->
					<li><strong>{feeling.label}:</strong> {feeling.percent}%</li>
					<!-- END feeling -->
				</ul>
			</li>
		</ul>
		<div><img src="{ROOT_PATH}media/chart/{personality_chart}" /></div>

