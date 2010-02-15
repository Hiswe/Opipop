
        <div id="header">
            <a href="{ROOT_PATH}">You Survey</a>
            <p>Did you know ?</p>
            <p><a href="{ROOT_PATH}question/{didyouknow_guid}-{didyouknow_id}">{didyouknow_label}</a></p>
        </div>

        <div id="userBox">
			<!-- SECTION logged -->
            <a href="{ROOT_PATH}{user_login}">{user_login}</a> (<a href="{ROOT_PATH}logout">logout</a>)
            <!-- END logged -->
			<!-- SECTION notLogged -->
            <a href="{ROOT_PATH}login">Login / register</a>
            <!-- END notLogged -->
        </div>

		<h4><a href="{ROOT_PATH}users">Community</a></h4>

		<h4>Categories:</h4>
		<ul>
			<!-- LOOP category -->
			<li>
				<strong>{category.label}:</strong>
				<ul>
					<li><a href="{ROOT_PATH}category/{category.guid}">current polls</a></li>
					<li><a href="{ROOT_PATH}category/{category.guid}/archives">past polls</a></li>
				</ul>
			</li>
			<!-- END category -->
		</ul>

        <!-- SECTION feedback -->
        <p><i>{feedback}</i></p>
        <!-- END feedback -->


