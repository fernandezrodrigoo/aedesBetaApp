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

	
	
		
	
	
	///proyección
		var proj = new ol.proj.Projection({
			code: 'EPSG:3857',
			units: 'm'
		});
	
	
		

	//crea el mapa y agrega controles e interacciones
		var map = new ol.Map({
			target: document.getElementById('map'),
			controls: ol.control.defaults({
					  zoom: true,
					  attribution: false,
					  rotate: false
					}),
      
						
			layers: [
			//Layers base
			new ol.layer.Group({
                'title': 'Mapas base',
                layers: [
                    new ol.layer.Tile({
                        title: 'Mapa base',
                        type: 'base',
                        visible: true,
                        source: new ol.source.Stamen({
          				layer: 'toner'
                        })
                    })                  
                ]
            }),			
		
        ],										
			view : new ol.View({
			center: [-6246290, -4102856],			
			zoom: 9,
			projection:proj,
			})
		});	
	
