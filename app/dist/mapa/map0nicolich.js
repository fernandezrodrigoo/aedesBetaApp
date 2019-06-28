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

// Proyección
var projection = new ol.proj.Projection({
        code: 'EPSG:32721',
      });


// Fuentes de mapas base
	var BaseNeutra = new ol.layer.Tile({source: new ol.source.XYZ({
						url: 'http://s.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
						attributions: 
							[new ol.Attribution({ html: ['&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>']})
							]
						}),
						});
						
	var Relieve = new ol.layer.Tile({
            source: new ol.source.XYZ({
              attributions: 'Tiles © <a href="https://services.arcgisonline.com/ArcGIS/' +
                  'rest/services/World_Topo_Map/MapServer">ArcGIS</a>',
              url: 'https://server.arcgisonline.com/ArcGIS/rest/services/' +
                  'World_Topo_Map/MapServer/tile/{z}/{y}/{x}'
            }),
	});
		  
	var satelital = new ol.layer.Tile({
        source: new ol.source.BingMaps({
          imagerySet: 'Aerial',
          key: 'Av_EgK4MPwcAtZhNZl1FHGOLC0kdzGLT4YzYzIbbDxYA70GwWL3z5_MAxgiEL5X_'
        }),
      });
	  
// Capas	  
	var nicolich_normativa = new ol.layer.Vector({
		style: styleFunction,
        source: new ol.source.Vector({
        url: function(extent) {
          return 'http://geoserver.fadu.edu.uy:8080/geoserver/apps/wfs?service=WFS&' +
              'version=1.0.0&request=GetFeature&typeName=apps:nicolich_padrones&' +
              'outputFormat=application/json' ;
        },
        format: new ol.format.GeoJSON({
			defaultDataProjection: projection
		}),
	}),
		crossOrigin: 'anonymous',
	});
	
		var nicolich_terreno = new ol.layer.Vector({
		style: styleFunction,
        source: new ol.source.Vector({
        url: function(extent) {
          return 'http://geoserver.fadu.edu.uy:8080/geoserver/apps/wfs?service=WFS&' +
              'version=1.0.0&request=GetFeature&typeName=apps:nicolich_terreno_util&' +
              'outputFormat=application/json' ;
        },
        format: new ol.format.GeoJSON({
			defaultDataProjection: projection
		}),
		strategy: ol.loadingstrategy.bbox
	}),
		crossOrigin: 'anonymous',
	});
	
//funciones de estilos
// define los colores y el nombre de los rangos
      var a = [60, 141, 188,0.8];
      var b = [79, 109, 122,0.8];
      var c = [192, 214, 223, 0.8];
      var d = [159, 175, 144, 0.8];
      var e = [22, 96, 136,1];
      var f = [7, 31, 44, 0.8];
      var g = [145, 205, 238, 0.8];
	  var h = [60, 141, 188,0.8];
      var i = [79, 109, 122,0.8];
      var j = [192, 214, 223, 0.8];
      var k = [159, 175, 144, 0.8];
      var l = [22, 96, 136,1];
      var m = [7, 31, 44, 0.8];
      var n = [145, 205, 238, 0.8];
	  var o = [60, 141, 188,0.8];
      var p = [79, 109, 122,0.8];
      var q = [192, 214, 223, 0.8];
      var r = [159, 175, 144, 0.8];

// asigna los colores a los atributos
      var incomeLevels = {
        '1': a,
		'2': b,
		'3': c,
		'4': d,
		'5': e,
		'6': f,
		'7': g,
		'8': h,
		'9': i,
		'10': l,
		'11': m,
		'12': n,
		'13': o,
		'14': p,  
		'16': q,
		'17': r,
 
      };

	var defaultStyle = new ol.style.Style({
        fill: new ol.style.Fill({
          color: [250,250,250,0.3]
        }),
        stroke: new ol.style.Stroke({
          color: [220,220,220,0.3],
          width: 0.1
        })
	});
	  
	var styleCache = {};
	
	// the style function returns an array of styles
      // for the given feature and resolution.
      // Return null to hide the feature.
      function styleFunction(feature, resolution) {
        // obtiene el valor del campo para los estilos
        var level = feature.get('secundaria');
        // si no coincide ningún estilo asigna el de defecto
        if (!level || !incomeLevels[level]) {
          return [defaultStyle];
        }
        // asigna los estilos según las categorías
        if (!styleCache[level]) {
          styleCache[level] = new ol.style.Style({
            fill: new ol.style.Fill({
              color: incomeLevels[level]
            }),
            stroke: defaultStyle.stroke
          });
        }
        // at this point, the style for the current level is in the cache
        // so return it (as an array!)
        return [styleCache[level]];
      }	

//Mapa
	var map = new ol.Map({
		target: 'map',  
		renderer: 'canvas', 
		layers: [BaseNeutra, nicolich_normativa, nicolich_terreno],     
		view: new ol.View({
			projection: projection,
			center: [592000,6153500],
			zoom: 15,
			maxZoom: 18,
			minZoom: 14,
			extent: [96894,6104017,1140533,6694405],
		}),
		
		 controls: ol.control.defaults({zoom: false, attribution: false, rotate: false}),
	});

//Cambiar mapas base
	$(document).ready(function() {
		$('#Neutro').on('click', function() {
			map.removeLayer(Relieve);
			map.removeLayer(satelital);
			map.addLayer(BaseNeutra);
			BaseNeutra.setZIndex (-1);
		});
		$('#Relieve').on('click', function() {
			map.removeLayer(BaseNeutra);
			map.removeLayer(satelital);
			map.addLayer(Relieve);
			Relieve.setZIndex (-1);
		});
		$('#satelital').on('click', function() {
			map.removeLayer(BaseNeutra);
			map.removeLayer(Relieve);
			map.addLayer(satelital);
			satelital.setZIndex (-1);
		});
	}); 
		
		  	  
//Control de capas 
//Características del Switch por defecto
	$.fn.bootstrapSwitch.defaults.size = 'mini';
	$.fn.bootstrapSwitch.defaults.onText = 'Sí';
	$.fn.bootstrapSwitch.defaults.offText = 'No';

//Activa los switch 
	$('#normativa').bootstrapSwitch();
	$('#terreno').bootstrapSwitch();


//Funciones de los switch
	var normativa = document.getElementById("normativa");
	    function cambianormativa() {
        if (normativa.checked == true) {
           	nicolich_normativa.setVisible(true);
			nicolich_normativa.setZIndex (2);
		   
        } else {
            nicolich_normativa.setVisible(false);
        }
    }

	var terreno = document.getElementById("terreno");
	    function cambiaterreno() {
        if (terreno.checked == true) {
           nicolich_terreno.setVisible(true);
		   
        } else {
            nicolich_terreno.setVisible(false);
        }
    }



