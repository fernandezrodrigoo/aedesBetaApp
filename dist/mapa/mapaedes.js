// JavaScript Document

	//configurar protocolo crossdomain
		(function() {
			var cors_api_host = 'cors-anywhere.herokuapp.com';
			var cors_api_url = 'https://' + cors_api_host + '/';
			var slice = [].slice;
			var origin = window.location.protocol + '//' + window.location.host;
			var open = XMLHttpRequest.prototype.open;
			XMLHttpRequest.prototype.open = function() {
				var args = slice.call(arguments);
				var targetOrigin = /^https?:\/\/([^\/]+)/i.exec(args[1]);
				if (targetOrigin && targetOrigin[0].toLowerCase() !== origin &&
					targetOrigin[1] !== cors_api_host) {
					args[1] = cors_api_url + args[1];
				}
				return open.apply(this, args);
			};
		})();

	
	var blur = document.getElementById('blur');
    var radius = document.getElementById('radius');
	
	///proyección
	var proj = new ol.proj.Projection({
		code: 'EPSG:3857',
		units: 'm'
	});

	///capa

	var vector = new ol.layer.Vector({
			  	source: new ol.source.Vector({
				format: new ol.format.GeoJSON(),
				url: function(extent) {
				  return  'http://geoserver.fadu.edu.uy:8080/geoserver/apps/wfs?&' +
						  'service=WFS&' +
						  'version=1.0.0&request=GetFeature&typename=apps:aedes_trabajodecampo&'+
						  'outputFormat=application/json';
				}
			})
	});


	var heatmap = new ol.layer.Heatmap({
			source: new ol.source.Vector({
			url: 	'http://geoserver.fadu.edu.uy:8080/geoserver/apps/wfs?&' +
					'service=WFS&' +
					'version=1.0.0&request=GetFeature&typename=apps:aedes_trabajodecampo&'+
					'outputFormat=application/json',
		  	format: new ol.format.GeoJSON(),
			blur: parseInt(blur.value, 10),
        	radius: parseInt(radius.value, 10),
			})
	});



	heatmap.getSource().on('addfeature', function(event) {
        var score = event.feature.get('cluster');
		console.log(score)
        event.feature.set('weight', score);
      });

	var raster = new ol.layer.Tile({
		  source: new ol.source.OSM()
		});

	var Mont = ol.proj.transform([-56.0284783, -34.8561385], 'EPSG:4326', 'EPSG:3857');

	// create a Geolocation object setup to track the position of the device
	var geolocation = new ol.Geolocation({
        tracking: true
	});

	var zoomAmi =
          document.getElementById('zoomAmi');
      		zoomAmi.addEventListener('click', function() {
			var p = geolocation.getPosition();
			console.log(p)
			console.log(p[0] + ' : ' + p[1]);
			var miLugar = ol.proj.transform([parseFloat(p[0]), parseFloat(p[1])], 'EPSG:4326', 'EPSG:3857');
			view.setCenter(miLugar);
			view.setZoom (13);
      }, false);

    var view = new ol.View({
        center: Mont,
        zoom: 8
    });


//crea el mapa y agrega controles e interacciones

	var map = new ol.Map({
		 layers: [raster, heatmap],
		 target: 'map',
		 view: view
	});



      blur.addEventListener('input', function() {
        heatmap.setBlur(parseInt(blur.value, 10));
      });

      radius.addEventListener('input', function() {
        heatmap.setRadius(parseInt(radius.value, 10));
      });


	




	
