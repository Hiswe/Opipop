
        <h4>Friends:</h4>
        <ul>
            <!-- LOOP friend -->
            <li class="user"><a href="{ROOT_PATH}{friend.login}"><img src="{ROOT_PATH}{friend.avatar}" alt="{friend.login}" /> {friend.login}</a></li>
            <!-- END friend -->
        </ul>

        <!-- SECTION friendPendingRequest -->
        <h4>Friend requests:</h4>
        <ul>
            <!-- LOOP request -->
            <li class="user"><a href="{ROOT_PATH}{request.login}"><img src="{ROOT_PATH}{request.avatar}" alt="{request.login}" /> {request.login}</a>: <span id="request_{request.id}"><a href="javascript:profile_requestFriend({request.id}, true);">accept</a> / <a href="javascript:profile_requestFriend({request.id}, false);">reject</a></span></li>
            <!-- END request -->
        </ul>
        <!-- END friendPendingRequest -->

        <h4>Stats:</h4>
		<ul>
			<li><strong>vote count:</strong> {profile_totalVote}</li>
			<li><strong>prediction won:</strong> {profile_totalPredictionWon}</li>
			<li><strong>prediction lost:</strong> {profile_totalPredictionLost}</li>
			<li><strong>prediction accuracy:</strong> {profile_predictionAccuracy}%</li>
			<li><strong>distance from popular opinion:</strong> {profile_global_distance}m</li>
		</ul>
		<ul>
			<li><strong>distance from your friends opinion:</strong> {profile_friend_distance}m</li>
			<li><strong>prediction accuracy toward your friends:</strong>
                <ul>
                    <!-- LOOP friendPredictionAccuracy -->
                    <li><strong>{friendPredictionAccuracy.login}:</strong> {friendPredictionAccuracy.percent}%</li>
                    <!-- END friendPredictionAccuracy -->
                </ul>
			</li>
		</ul>
		<ul>
			<li><strong>personality:</strong>
				<ul>
					<!-- LOOP feeling -->
					<li><strong>{feeling.label}:</strong> {feeling.percent}%</li>
					<!-- END feeling -->
				</ul>
			</li>
		</ul>
		<div><img src="{ROOT_PATH}media/chart/{personality_chart}" /></div>

