<header>
	<div class="wrapper">
		<a href="#/ranking" class="icon-trophy" title="Classement général"></a>
		<h1>{{ rally_name }}</h1>
		<div id="check_refresh">
			<input id="refresh" type="checkbox" checked="true" />
			<label for="refresh"><span aria-hidden="true" class="icon-loop-alt2"></span></label>
		</div>
	</div>
</header>

<nav>
	<div class="wrapper">
		<ul>
			<li><a href="#/rally" class="menu_actif">Results</a></li>
			<li><a href="#/stages">Stages</a></li>
			<li><a href="#" class="menu_disable">Prevision</a></li>
		</ul>	
	</div>
</nav>

<div id="content" class="page_rally">
	<ol class="wrapper">
		<li ng-repeat="time in times" class="table">
			<span class="cell">
				{{ time.rank }}
			</span>
			<span class="cell">
				{{ time.driver }}
			</span>
			<span class="cell last-col" ng-hide="time.rank == 1 || time.retired">
				<p>+{{ time.best }}</p>
				<p class="small-text">+{{ time.previous }}</p>
			</span>	
		</li>
		<li class="after_new_stage">
			After SS6 Santana da Serra 1 (running)
		</li>
		<li class="before_new_stage">
			Before SS6 Santana da Serra 1 (running)
		</li>
	</ol>	
</div>	<!--#content-->