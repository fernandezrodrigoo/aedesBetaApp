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
	  
//funciones de estilos
// define los colores y el nombre de los rangos
      var a = [60, 141, 188,0.8];
      var b = [79, 109, 122,0.8];
      var c = [192, 214, 223, 0.8];
      var d = [159, 175, 144, 0.8];
      var e = [22, 96, 136,1];
      var f = [7, 31, 44, 0.8];
      var g = [145, 205, 238, 0.8];
	  var h = [22, 96, 136,1];
      var i = [7, 31, 44, 0.8];
      var j = [145, 205, 238, 0.8];

// asigna los colores a los atributos
      var incomeLevels = {
        'ZG': a,
		'ZEA': b,
		'ZEB': c,
		'ZEC': d,
		'ZED': e,
		'ZP':  f,
		'ZSU': g,
      };

	var incomeLevels2 = {
        'Z01': a,
		'Z01 b': b,
		'Z02': c,
		'Z03': d,
		'Z03 b': e,
		'ZG':  f,
		'ZEA': g,
		'ZEB': h,
		'ZEC': i,
		'ZC': j,
		
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
        var level = feature.get('normativa');
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

	var styleCache2 = {};
	
	// the style function returns an array of styles
      // for the given feature and resolution.
      // Return null to hide the feature.
      function styleFunction2(feature, resolution) {
        // obtiene el valor del campo para los estilos
        var level = feature.get('normativa');
        // si no coincide ningún estilo asigna el de defecto
        if (!level || !incomeLevels2[level]) {
          return [defaultStyle];
        }
        // asigna los estilos según las categorías
        if (!styleCache2[level]) {
          styleCache2[level] = new ol.style.Style({
            fill: new ol.style.Fill({
              color: incomeLevels2[level]
            }),
            stroke: defaultStyle.stroke
          });
        }
        // at this point, the style for the current level is in the cache
        // so return it (as an array!)
        return [styleCache2[level]];
      }	

//Mapa
	var map = new ol.Map({
		target: 'map',  
		renderer: 'canvas', 
		layers: [BaseNeutra],     
		view: new ol.View({
			projection: projection,
			center: [595000,6147050],
			zoom: 16,
			maxZoom: 18,
			minZoom: 14,
			extent: [96894,6104017,1140533,6694405],
		}),
		
		 controls: ol.control.defaults({zoom: false, attribution: false, rotate: false}),
	});

// Capas	  
	
		var costa_terreno_sur_propuesta = new ol.layer.Vector({
		style: styleFunction2,
        source: new ol.source.Vector({
        url: function(extent) {
          return 'http://geoserver.fadu.edu.uy:8080/geoserver/apps/wfs?service=WFS&' +      'version=1.0.0&request=GetFeature&typeName=apps:costaplan_terreno_util_propuesta_centro&' + 'outputFormat=application/json' ;
        },
        format: new ol.format.GeoJSON({
			defaultDataProjection: projection
		}),
		strategy: ol.loadingstrategy.bbox
	}),
		crossOrigin: 'anonymous',
		visible: false
	});	
	map.addLayer(costa_terreno_sur_propuesta);


		var costa_terreno_sur = new ol.layer.Vector({
		style: styleFunction,
        source: new ol.source.Vector({
        url: function(extent) {
          return 'http://geoserver.fadu.edu.uy:8080/geoserver/apps/wfs?service=WFS&' +
              'version=1.0.0&request=GetFeature&typeName=apps:costaplan_terreno_util_centro&' +
              'outputFormat=application/json' ;
        },
        format: new ol.format.GeoJSON({
			defaultDataProjection: projection
		}),
		strategy: ol.loadingstrategy.bbox
	}),
		crossOrigin: 'anonymous',
		visible: true
	});
	map.addLayer(costa_terreno_sur);

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
	$('#terreno').bootstrapSwitch();
	$('#terrenop').bootstrapSwitch();


//Funciones de los switch

	var terreno = document.getElementById("terreno");
	    function cambiaterreno() {
        if (terreno.checked == true) {
           	costa_terreno_sur.setVisible(true);
        } else {
            costa_terreno_sur.setVisible(false);
        }
    };

	var terrenop = document.getElementById("terrenop");
	    function cambiaterrenop() {
        if (terrenop.checked == true) {
           	costa_terreno_sur_propuesta.setVisible(true);
        } else {
            costa_terreno_sur_propuesta.setVisible(false);
        }
    };





