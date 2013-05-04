angular.module('directives', [])
.directive('pullToRefresh', function($document, $window){
	return function(scope, iElement, iAttrs){
		iElement.css({'height': 0, 'overflow': 'hidden'});
		var initOffset = 15,
			refreshOffset = 100,
			refreshOnRelease = false,
			touchStart = 0,
			prevOffset = 0;
		
		$document.bind('touchstart', function(e){
			touchStart = e.touches[0].pageY;
		});
		$document.bind('touchend', function(e){
			if (refreshOnRelease) alert('reload');
			shutDown();
		});
		
		$document.bind('touchmove', function(e){
			var dif = e.touches[0].pageY - touchStart;
			var scrollTop = $window.pageYOffset;
			var offset = dif - initOffset;
			
			if (scrollTop == 0 && dif > 0) e.preventDefault();
			if (scrollTop == 0 && dif > initOffset && prevOffset != offset) refresh(offset);
		});
		
		var refresh = function(offset){
			prevOffset = offset;
			refreshOnRelease = (offset >= refreshOffset) ? true : false;
			
			offset = Math.min(offset, refreshOffset);
			iElement.css({'height': offset+'px'});
			iElement.html(offset);
		}
		
		var shutDown = function(){
			iElement.css({height: 0});
			touchStart = prevOffset = 0;
			refreshOnRelease = false;
		}
	}
});