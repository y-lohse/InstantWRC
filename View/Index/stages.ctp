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
		<li ng-repeat="stage in stages" ng-switch="stage.status">
			<?php //rallye a venir ?>
			<span ng-switch-when="0" class="stage_later">
				<span class="icon-clock"></span>
				<p>05.25</p>
			</span>
			<p ng-switch-when="0">
				{{ stage.name }}
				<span>{{ stage.distance }}km</span>
			</p> 
			<span ng-switch-when="0">
				<a href="#/stage/1">
					<span class="icon-play"></span>
				</a>
			</span>
			
			<?php //rallye en cours ?>
			<span ng-switch-when="1" class="stage_running">
				<span class="icon-play"></span>
				<p>Running</p>
			</span>
			<p ng-switch-when="1">
				{{ stage.name }}
				<span>{{ stage.distance }}km</span>
			</p> 
			<span ng-switch-when="1">
				<a href="#/stage/1">
					<span class="icon-play"></span>
				</a>
			</span>
		</li>
		
		<li>
			<span class="stage_running">
				<span class="icon-play"></span>
				<p>Running</p>
			</span>
			<p>
				SS6 Santana da Serra 1 
				<span>31.12km</span>
			</p> 
			<span>
				<a href="#/stage/1">
					<span class="icon-play"></span>
				</a>
			</span>
		</li>
		<li>
			<span class="stage_finished"> 
				<span class="icon-trophy"></span>
				<p>Finished</p>
			</span>
			<p>
				SS6 Santana da Serra 1
				<span>31.12km</span>
			</p> 
			<span>
				<a href="#/stage/1">
					<span class="icon-play"></span>
				</a>
			</span>
		</li>
		<li>
			<span class="stage_later">
				<span class="icon-clock"></span>
				<p>
					08:25 <span>am</span>
				</p>
			</span>
			<p>
				SS6 Santana da Serra 1 
				<span>31.12km</span>
			</p> 
			<span>
				<a href="#/stage/1">
					<span class="icon-play"></span>
				</a>
			</span>
		</li>
		<li>
			<span class="stage_canceled"> 
				<span class="icon-x"></span>
				<p>Canceled</p>
			</span>
			<p>
				SS6 Santana da Serra 1 
				<span>31.12km</span>
			</p> 
			<span>
				<a href="#/stage/1">
					<span class="icon-play"></span>
				</a>
			</span>
		</li>
	</ol>
</div>
<!--#content-->