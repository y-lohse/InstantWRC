angular.module('directives', [])
.directive('pull', function(){
	return function(scope, iElement, iAttrs){
		iElement.bind('click', function(){
			alert('ok');
		});
	}
});