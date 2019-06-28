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



var style = new ol.style.Style({
        fill: new ol.style.Fill({
          color: 'rgba(255, 255, 255, 0.6)'
        }),
        stroke: new ol.style.Stroke({
          color: '#319FD3',
          width: 1
        }),
        text: new ol.style.Text({
          font: '12px Calibri,sans-serif',
          fill: new ol.style.Fill({
            color: '#000'
          }),
          stroke: new ol.style.Stroke({
            color: '#fff',
            width: 3
          })
        })
      });



// Proyección
	var projection = new ol.proj.Projection({
        code: 'EPSG:32721',
      });
	  
	var costa_terreno_sur = new ol.layer.Vector({
        source: new ol.source.Vector({
        url: function(extent) {
          return 'http://geoserver.fadu.edu.uy:8080/geoserver/apps/wfs?service=WFS&' +
              'version=1.0.0&request=GetFeature&typeName=apps:costaplan_terreno_util_norte&' +
              'outputFormat=application/json' ;
        },
        format: new ol.format.GeoJSON({
			defaultDataProjection: projection
		}),
		strategy: ol.loadingstrategy.bbox
	}),
		crossOrigin: 'anonymous',
	});


      var map = new ol.Map({
        layers: [new ol.layer.Tile({
      source: new ol.source.OSM()
    }), costa_terreno_sur],
        target: 'map',
        view: new ol.View({
			projection: projection,
          	center: [595000,6145450],
			zoom: 17,
			extent: [96894,6104017,1140533,6694405],
        })
      });

var ol3d = new olcs.OLCesium({map: map}); // map is the ol.Map instance
ol3d.setEnabled(false);

var scene = ol3d.getCesiumScene();


scene.globe.enableLighting = true;

var featureConverter = new olcs.FeatureConverter(scene);
featureConverter.olVectorLayerToCesium(costa_terreno_sur, altitudeMode="clampToGround", map.getView(), scene.primitives);







