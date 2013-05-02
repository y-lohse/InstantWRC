<header>
	<div class="wrapper">
		<a href="#/ranking" class="icon-trophy" title="Classement général"></a>
		<h1>{{ rally_name }}</h1>
		<div id="check_refresh">
			<input id="refresh" type="checkbox" checked="true" /> <label
				for="refresh"><span aria-hidden="true"
				class="icon-loop-alt2"></span></label>
		</div>
	</div>
</header>

<nav>
	<div class="wrapper">
		<ul>
			<li><a href="#/rally">Results</a></li>
			<li><a href="#/stages" class="menu_actif">Stages</a></li>
			<li><a href="#" class="menu_disable">Prevision</a></li>
		</ul>
	</div>
</nav>

<div id="content" class="page_stages">
	<ol class="wrapper">
		<li ng-repeat="stage in stages">
			<div ng-switch="stage.status">
				<?php //not started ?>
				<div ng-switch-when="0" class="table">
					<span class="cell stage-status">
						<span class="icon-clock"></span>
						<p>08:25 <span>am</span></p>
					</span>
					<p class="cell">
						SS6 Santana da Serra 1
						<span class="small-text">31.12km</span>  
					</p>
				</div>
				
				<?php //running ?>
				<a ng-switch-when="1" href="#/stage/1" class="table">
					<span class="cell stage-status">
						<span class="icon-play"></span>
						<p>Running</p>
					</span>
					<p class="cell">
						{{ stage.name }}
						<span class="small-text">
							{{ stage.distance }}km
						</span>
					</p>
					<span class="cell last-col icon-play"></span>
				</a>
				
				<?php //completed ?>
				<a ng-switch-when="2" href="#/stage/1" class="table">
					<span class="cell stage-status">
						<span class="icon-trophy"></span>
						<p>Finished</p>
					</span>
					<p class="cell">
						{{ stage.name }}
						<span class="small-text">
							{{ stage.distance }}km
						</span>
					</p>
					<span class="cell last-col icon-play"></span>
				</a>
				
				<?php //cancelled ?>
				<div ng-switch-when="4" class="table">
					<span class="cell stage-status">
						<span class="icon-x"></span>
						<p>Canceled</p>
					</span>
					<p class="cell">
						{{ stage.name }}
						<span class="small-text">
							{{ stage.distance }}km
						</span>
					</p>
				</div>
			</div>
		</li>
	</ol>	
</div>	<!--#content-->