angular.module('directives', [])
.directive('pullToRefresh', function($document, $window){
	return function(scope, iElement, iAttrs){
		var initOffset = 15,
			refreshOffset = parseInt($window.getComputedStyle(iElement[0]).height),
			refreshFn = iAttrs.pullToRefresh,
			refreshOnRelease,
			touchStart;
		iElement.css({overflow: 'hidden'});
		
		var init = function(){
			iElement.css({height: 0});
			touchStart = 0;
			refreshOnRelease = false;
		}
		
		init();
		
		$document.bind('touchstart', function(e){
			touchStart = e.touches[0].pageY;
		});
		$document.bind('touchend', function(e){
			if (refreshOnRelease) scope[refreshFn]();
			init();
		});
		
		$document.bind('touchmove', function(e){
			if ($window.pageYOffset > 0) return;
			var dif = e.touches[0].pageY - touchStart;
			
			if (dif > 0) e.preventDefault();
			if (dif > initOffset) refresh(dif - initOffset);
		});
		
		var refresh = function(offset){
			refreshOnRelease = (offset >= refreshOffset) ? true : false;
			
			iElement.css({'height': Math.min(offset, refreshOffset)+'px'});
			(refreshOnRelease) ? iElement.addClass('ready') : iElement.removeClass('ready');
		}
	}
});