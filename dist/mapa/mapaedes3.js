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

	
	//formatos para las transacciones del WFS	
		var formatWFS = new ol.format.WFS();
		var formatGML = new ol.format.GML({
			featureNS: 'SITU-APPS',
			featureType: 'aedes_trabajodecampo',
			
		});	
		
	//fuente usada para las transacciones		
		var sourceWFS = new ol.source.Vector({
			loader: function (extent) {
				$.ajax({
					url: 'http://geoserver.fadu.edu.uy:8080/geoserver/apps/ows',
					type: 'GET',
					crossOrigin: true,
					data: {
						service: 'WFS',
						version: '1.1.0',
						request: 'GetFeature',
						typename: 'aedes_trabajodecampo',
						srsname: 'EPSG:3857',
						datatype: 'jsonp',
					}
				}).done(function (response) {
					sourceWFS.addFeatures(formatWFS.readFeatures(response));
				});
			},
			strategy: ol.loadingstrategy.fixed,
			projection: 'EPSG:3857'
		});
		
	//simbología con íconos para wfs
	//normal
      	var normal = new ol.style.Style({
			image: new ol.style.Icon({                   
			  src: '../../dist/img/iconos/aedes.png',
			  scale: 1.00,
			})
		  });	
	//selección	
		var selecc = new ol.style.Style({
			image: new ol.style.Icon({                   
			  src: '../../dist/img/iconos/aedes.png',
			  scale: 1.00,
			})
		  });
		
	//Capa WFS con la fuente definida
		var layerWFS = new ol.layer.Vector({
			source: sourceWFS,
			crossOrigin: 'anonymous'
		});
		
	//Seleccionar entidades para las interacciones
		var interaction;		
		var interactionSelectPointerMove = new ol.interaction.Select({
			condition: ol.events.condition.pointerMove
		});		
		var interactionSelect = new ol.interaction.Select({
			style: new ol.style.Style({
				image: new ol.style.Icon({                   
			  src: '../../dist/img/iconos/aedes.png'
			})
		})
		});			
		
		var interactionSnap = new ol.interaction.Snap({
			source: layerWFS.getSource()
		});
			
	//crea el mapa y agrega controles e interacciones
		var map = new ol.Map({
			target: ('map'),
			controls: ol.control.defaults({
					  zoom: false,
					  attribution: false,
					  rotate: false
					}),
      
			interactions: [
				interactionSelectPointerMove,
				new ol.interaction.MouseWheelZoom(),
				new ol.interaction.DragPan()
			],
			layers: [
                    new ol.layer.Tile({
                        title: 'Mapa base',
                        type: 'base',
                        visible: true,
                        source: new ol.source.Stamen({
          				layer: 'toner'
                        })
                    }),
					new ol.layer.Vector({
						title: 'Relevamiento',
						visible: true,
						source: sourceWFS,
						crossOrigin: 'anonymous',
					})						
                ],
			view : new ol.View({
			center: [-6246290, -4102856],
			zoom: 9
			})
		});
	
					
		//define las transacciones wfs-t
			var dirty = {};
			var transactWFS = function (mode, f) {
				var node;
				switch (mode) {
					case 'insert':
						node = formatWFS.writeTransaction([f], null, null, formatGML);	
						break;
					case 'update':
						node = formatWFS.writeTransaction(null, [f], null, formatGML);
						break;
					case 'delete':
						node = formatWFS.writeTransaction(null, null, [f], formatGML);
						break;
				}
				var xs = new XMLSerializer();
				var payload = xs.serializeToString(node);
				$.ajax('http://geoserver.fadu.edu.uy:8080/geoserver/apps/wfs', {
					type: 'POST',
					crossDomain: true,
					dataType: 'xml',
					processData: false,
					contentType: 'text/xml',
					data: payload
				}).done(function() {
					sourceWFS.clear();
				});
			};

		function getQueryVariable(variable) {
			var query = window.location.search.substring(1);
			var vars = query.split('&');
			for (var i = 0; i < vars.length; i++) {
				var pair = vars[i].split('=');
				if (decodeURIComponent(pair[0]) == variable) {
					return decodeURIComponent(pair[1]);
				}
			}
		}
			console.log(getQueryVariable('ciudad'));
			console.log(getQueryVariable('cluster'));		
			console.log(getQueryVariable('vivienda'));
			console.log(getQueryVariable('direccion'));
			console.log(getQueryVariable('encuestado'));
			console.log(getQueryVariable('personas'));
			console.log(getQueryVariable('date'));

;

		//botones y sus acciones
		
		var form = $('<form><input name="usernameInput"/></form>');
		
			map.addControl(new ol.control.Zoom({
				className: 'custom-zoom'
			}));		
			$('button').click(function () {
				$(this).siblings().removeClass('btn-active');
				$(this).addClass('btn-active');
				map.removeInteraction(interaction);
				interactionSelect.getFeatures().clear();
				map.removeInteraction(interactionSelect);
			
				switch ($(this).attr('id')) {
						
					case 'btnPoint':
						interaction = new ol.interaction.Draw({
							type: 'Point',
							source: layerWFS.getSource(),
							geometryName: 'geom',
							srsName: 'EPSG:3857',
							
						});
						map.addInteraction(interaction);
						interaction.on('drawend', function (e) {
							
							var categoria = Swal.fire({
								  title: 'Listo!',
								  text: 'Se ha localizado la vivienda Nº ' + (getQueryVariable('vivienda')),
								  confirmButtonText: '<a href="aedes.html">Seguir</a>'
							});
							
							e.feature.set('cluster', (getQueryVariable('cluster')));
							e.feature.set('n_vivienda', (getQueryVariable('vivienda')));
							e.feature.set('direccion', (getQueryVariable('direccion')));
							e.feature.set('residente', (getQueryVariable('encuestado')));
							e.feature.set('equipo', (getQueryVariable('equipo')));
							e.feature.set('n_personas', (getQueryVariable('personas')));
							e.feature.set('ciudad', (getQueryVariable('ciudad')));
							e.feature.set('fecha', (getQueryVariable('date')));
							
							transactWFS('insert', e.feature);
						}
										
										);
						break;
						
					default:
						break;
				}
			});				
