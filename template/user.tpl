
        <!-- INCLUDE block/top.tpl -->

        <h1>{user_login}</h1>

		<ul>
			<li><strong>vote count:</strong> {user_totalVote}</li>
			<li><strong>prediction won:</strong> {user_totalPredictionWon}</li>
			<li><strong>prediction lost:</strong> {user_totalPredictionLost}</li>
			<li><strong>prediction accuracy:</strong> {user_predictionAccuracy}%</li>
			<li><strong>distance from popular opinion:</strong> {user_distance}m</li>
		</ul>

        <!-- INCLUDE block/user_menu.tpl -->

