      // Popup showing the position the user clicked
	  var element = document.getElementById('popup');
	  	  
      var popup = new ol.Overlay({
        	element: element,
		    positioning: "auto",
			stopEvent: true,
			autoPan: true,
      });
      map.addOverlay(popup);

      map.on('click', function(evt) {		  
        var element = popup.getElement();
        var coordinate = evt.coordinate;

		var feature = map.forEachFeatureAtPixel(evt.pixel,
            function(feature) {
              return feature;
            });
        if (feature) {
		  $(element).popover('destroy');
          popup.setPosition(coordinate);
          $(element).popover({
            'placement': 'top',
            'html': true,
			'animation': true,
            'content': '<p>' + feature.get('txt1') + '</p>' + '<p>' + feature.get('txt2') + '</p>'});
          $(element).popover('show');
        } else {
          $(element).popover('destroy');
        }
      });
	  
			 // change mouse cursor when over marker
      map.on('pointermove', function(e) {
        if (e.dragging) {
          $(element).popover('destroy');
          return;
        }
        var pixel = map.getEventPixel(e.originalEvent);
        var hit = map.hasFeatureAtPixel(pixel);
        map.getTarget().style.cursor = hit ? 'pointer' : '';
      });
		
					

						
