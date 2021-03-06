Webos.bind('updateElements', function(data){
	var i;
	for(i in data) {
		var objectId = data[i].objectId;
		var content  = data[i].content;
		var $object  = $('#'+objectId);
		$object.replaceWith(content);
		$object  = $('#'+objectId); // re-select becuase original was lost by "replaceWith" call;
		
		(function(objectId) {
			var $object = $('#'+objectId);
			setTimeout(function() {
				Directives.applyAll($object);
				Directives.findNApplyAll($object);
			}, 100); // I dont know why.. $object no available in DOM yet, so await a bit ...
		})(objectId);
	}
	Webos.trigger('elementsUpdated');
});

Webos.bind('createElements', function(data) {
	var i;
	for (i in data) {
		(function(create) {
			var parentObjectId = create.parentObjectId;
			var objectId       = create.objectId;
			var content        = create.content;
			var $container     = $(document.body);

			if (parentObjectId) {
				var containerSelector = '#' + parentObjectId + ' > .container';
				if ($(containerSelector).length) {
					$container = $(containerSelector);
				} else {
					$container = $('#' + parentObjectId);
				}
			}			
			$container.append(content);
			Directives.applyAll($('#' + objectId));
			Directives.findNApplyAll($('#' + objectId));
		})(data[i]);
	}
	Webos.trigger('elementsUpdated');
});

Webos.bind('removeElements', function(data) {
	var i;
	for (i in data) {
		$('#' + data[i].objectId).remove();
	}
	Webos.trigger('elementsUpdated');
});

Webos.bind('authUser', function() {
	location.reload();
});
Webos.bind('sendFileContent', function() {
	location = Webos.endPoint + 'getOutputStream';
});
Webos.bind('navigateURL', function(data) {
	location = data.url;
});
Webos.bind('loggedIn', function() {
	location.reload();
});
Webos.bind('printContent', function(data) {
	var i = document.createElement('iframe');
	i.setAttribute('src', 'javascript:void(0);');
	i.setAttribute('width', '0');
	i.setAttribute('height', '0');
	i.setAttribute('frameborder', '0');
	document.body.appendChild(i);
	i.contentWindow.document.write(data.content);
	i.contentWindow.print();
	document.body.removeChild(i);
});

/**
 * Este observador se encarga de acomodar los MenuList disponibles.
 **/
Webos.bind('elementsUpdated', function() {
	$('.MenuList').each(function(){
		var $prev = $(this).prev();
		if (!$prev.length) return;

		var $selectedItem = $prev.find('.MenuItem.selected');
		if (!$selectedItem.length) return;

		var $this = $(this);
		var $menuItems = $prev.find('.MenuItem');

		var selPos = 0;
		for (var i=0; i<$menuItems.length; si++) {
			var $menuItem = $($menuItems[i]);
			if ($menuItem.hasClass('selected')) {
				selPos = i;
				break;
			}
		}

		var top = parseInt($prev.css('top')) + parseInt($menuItems.height()) * selPos + 'px';
		var left = parseInt($prev.css('left')) + $prev.outerWidth() - 1 + 'px';

		$this.css('top', top);
		$this.css('left', left);
	});
});

/**
 * Try to keep active windows on top of dom, dropping it at the end of parent container.
 **/
Webos.bind('elementsUpdated', function() {
	$('.form-wrapper.active').each(function(){
		//this.parentNode.appendChild(this);
	});

	/*var activeWindow = $activeWindow[0];
	activeWindow.parentNode.appendChild(activeWindow);*/
});

$(document).ready(function() {
	Webos.trigger('elementsUpdated');
});

$(document).ready(function() {
	Webos.syncViewportSize();
	
	var to = null;
	$(window).resize(function() {
		clearTimeout(to);
		to = setTimeout(function() {
			Webos.syncViewportSize();
		}, 500);
	});
	
	$(window).keyup(function(event) {
		if (event.originalEvent.keyCode === 27) {
			// Webos.keyEscape();
		}
	});
});