<ol>
	<li ng-repeat="stage in stages">
		<a href="#/stage">
			{{stage.name}}
			<em>
				{{stage.distance}}
			</em>
		</a>
	</li>
</ol>
<button ng-click="addStage()">add</button>