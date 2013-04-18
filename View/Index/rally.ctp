<table>
	<thead>
		<tr>
			<td>
				Name
			</td>
			<td>
				Time
			</td>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="time in times">
			<td>
				{{time.driver}}
			</td>
			<td>
				{{time.time}}
			</td>
		</tr>
	</tbody>
</table>
<ol>
	<li ng-repeat="stage in stages">
		<a href="#/stage/{{stage.id}}">
			{{stage.name}}
			<em>
				{{stage.distance}}
			</em>
		</a>
	</li>
</ol>