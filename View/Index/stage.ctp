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
<a href="#/rally">
	back to overview
</a>