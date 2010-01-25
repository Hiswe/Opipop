
        <a href="{ROOT_PATH}">You Survey</a>

        <h4>User logged:</h4>
        <ul id="userLogged">
            <!-- LOOP userLogged -->
            <li><a href="{ROOT_PATH}{userLogged.guid}">{userLogged.login}</a></li>
            <!-- END userLogged -->
            <li><a href="{ROOT_PATH}login">connect a new user</a></li>
        </ul>

		<h4>Categories:</h4>
		<ul>
			<!-- LOOP category -->
			<li>
				<strong>{category.label}:</strong>
				<ul>
					<li><a href="{ROOT_PATH}{category.guid}-{category.id}">current polls</a></li>
					<li><a href="{ROOT_PATH}{category.guid}-{category.id}/archives">past polls</a></li>
				</ul>
			</li>
			<!-- END category -->
		</ul>


