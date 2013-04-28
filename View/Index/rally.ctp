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

<div id="content" class="page_rally" data-pull>
	<ol class="wrapper">
		<li ng-show="showStage" class="after_new_stage">
			After {{ stagename }}
		</li>
		<li ng-repeat="time in times | filter:{last_stage: firstStage}" class="table">
			<span class="cell">
				{{ time.rank }}
			</span>
			<span class="cell">
				{{ time.driver }}
			</span>
			<span class="cell last-col" ng-hide="time.rank == 1 || time.retired">
				<p>{{ time.best }}</p>
				<p class="small-text">{{ time.previous }}</p>
			</span>	
		</li>
		
		<li ng-show="showStage" class="before_new_stage">
			Before {{ stagename }}
		</li>
		<li ng-show="showStage" ng-repeat="time in times | filter:{last_stage: '!'+firstStage}" class="table">
			<span class="cell">
				{{ time.rank }}
			</span>
			<span class="cell">
				{{ time.driver }}
			</span>
			<span class="cell last-col" ng-hide="time.rank == 1 || time.retired">
				<p>{{ time.best }}</p>
				<p class="small-text">+{{ time.previous }}</p>
			</span>	
		</li>
	</ol>	
</div>	<!--#content-->