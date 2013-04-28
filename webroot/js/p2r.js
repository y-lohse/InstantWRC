var p2r = angular.module('p2r', []);
p2r.directive('pull', function(){
	return function(scope, iElement, iAttrs){
		iElement.bind('click', function(){
			alert('ok');
		});
	}
});