
        <div>
            <a href="{ROOT_PATH}">You Survey</a><span> - </span>
            <!-- LOOP userLogged -->
            <a href="{ROOT_PATH}{userLogged.login}">{userLogged.login}</a>
            <!-- END userLogged -->
			<!-- SECTION login -->
            <a href="{ROOT_PATH}login">Login / register</a>
            <!-- END login -->
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


