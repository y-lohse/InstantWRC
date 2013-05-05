InstantWRC.controller('RankingController', function(){
});

InstantWRC.controller('RallyController', function($scope, $http, Rally){
	$scope.showStage = false;
	$scope.firstStage = '';
	
	$scope.fetchData = function(){
		$scope.stagename = Rally.getStageName();
		/*$scope.stagename = function(){
			var deferred = $q.defer();
			
			Rally.getStageName(function(stageName){
				deferred.resolve(stageName);
			});
			
			return deferred.promise;
		};*/
		/*
		Rally.getTimes(function(times){
			$scope.times = times;
			
			$scope.firstStage = $scope.times[0].last_stage;
			for (var i = 1, l = $scope.times.length; i < l; i++){
				if (!$scope.times[i].retired && $scope.times[i].last_stage != $scope.firstStage){
					$scope.showStage = true;
					break;
				}
			}
			
			if ($scope.showStage){
				Rally.getStageName(function(stageName){
					$scope.stagename = stageName;
				});
			}
		});*/
	};
	
	$scope.fetchData();
});

InstantWRC.controller('StagesController', function($scope, $http, Rally){
	$scope.fetchData = function(){
		Rally.getStages(function(stages){
			$scope.stages = stages;
		});
	};
	
	$scope.fetchData();
});

InstantWRC.controller('StageController', function($scope, $http, $routeParams, Stage){
	Stage.id = $routeParams.stageId;
	Stage.getStageName(function(stageName){
		$scope.stagename = stageName;
	});
	
	$scope.fetchData = function(){
		Stage.getTimes(function(times){
			$scope.times = times;
		});
	};
	
	$scope.fetchData();
});