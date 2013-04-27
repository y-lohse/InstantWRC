<header>
	<div class="wrapper">
		<a href="#/ranking" class="icon-trophy" title="Classement général"></a>
		<h1>Vodafone Rally de Portugal</h1>
		<div id="check_refresh">
			<input id="refresh" type="checkbox" checked="true" />
			<label for="refresh"><span aria-hidden="true" class="icon-loop-alt2"></span></label>
		</div>
	</div>
</header>

<nav>
	<div class="wrapper">
		<ul >
			<li><a href="#/rally" class="menu_actif">Results</a></li>
			<li><a href="#/stages">Stages</a></li>
			<li><a href="#" class="menu_disable">Prevision</a></li>
		</ul>	
	</div>
</nav>

<div id="content" class="page_rally">
	<ol class="wrapper">
		<li ng-repeat="time in times">
			<span>2</span>
			<span>{{time.driver}}</span>
			<span>
				<p>{{time.time}}</p>
				<p>+0</p>
			</span>	
		</li>
	</ol>	
</div>	<!--#content-->