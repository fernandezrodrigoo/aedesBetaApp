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
				view.setZoom (19);
		  }, false);

		var view = new ol.View({
			center: [-6246290, -4102856],
			zoom: 8,
			maxZoom: 19
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
					source: new ol.source.BingMaps({
					key: 'Akn1QSVaE_kGwi3aJ9_EWZs2I1SsQEnhmGwAaVv-xUuMs2R_SdHwjdNMPZLquA4v',
					imagerySet:'AerialWithLabels'})
					}),
					new ol.layer.Vector({
						title: 'Relevamiento',
						visible: true,
						source: sourceWFS,
						crossOrigin: 'anonymous',
					})						
                ],
			view : view,
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

		//botones y sus acciones
		function acomodarTextos(texto) {
			var paso1 = (decodeURIComponent((texto).replace(/\%25/g, '%').replace(/25/g, '')));
			var paso2 = decodeURIComponent( (paso1).replace(/\+/g, '%20') );
			return paso2
		}

		var codecomp = acomodarTextos((getQueryVariable('ciudad')));
		codecomp += getQueryVariable('cluster');
		codecomp += getQueryVariable('vivienda');
		codecomp += getQueryVariable('equipo');

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
											  title: '<strong>¡Listo!</strong>',
											  type: 'info',
											  showCloseButton: false,
											  showCancelButton: false,
											  focusConfirm: false,
											  confirmButtonText:
												'<i onclick="location.href="aedes.html";" class="fa fa-thumbs-up"></i> Terminar y seguir!',
											}).then(function() {
											// Redirect the user
											window.location.href = "aedes.html";
											});

							map.removeInteraction(interaction);
							
							e.feature.set('cluster', (getQueryVariable('cluster')));
							e.feature.set('n_vivienda', (getQueryVariable('vivienda')));
							e.feature.set('direccion', (acomodarTextos(getQueryVariable('direccion'))));
							e.feature.set('residente', (acomodarTextos((getQueryVariable('encuestado')))));
							e.feature.set('equipo', (getQueryVariable('equipo')));
							e.feature.set('n_personas', (getQueryVariable('personas')));
							e.feature.set('ciudad', (acomodarTextos((getQueryVariable('ciudad')))));
							e.feature.set('fecha', (getQueryVariable('date')));
							
							e.feature.set('codigo', codecomp);
							
							e.feature.set('nadaTot', Number((getQueryVariable('vaciototal'))));
							e.feature.set('aguaTot', Number((getQueryVariable('aguatotal'))));
							e.feature.set('criaTot', Number((getQueryVariable('criaderostotal'))));
							
							e.feature.set('tipo11', Number(((getQueryVariable('tipo11')))));
							e.feature.set('tipo12', Number(((getQueryVariable('tipo12')))));
							e.feature.set('tipo13', Number(((getQueryVariable('tipo13')))));
							
							e.feature.set('tipo21', Number(((getQueryVariable('tipo21')))));
							e.feature.set('tipo22', Number(((getQueryVariable('tipo22')))));
							e.feature.set('tipo23', Number(((getQueryVariable('tipo23')))));
							
							e.feature.set('tipo31', Number(((getQueryVariable('tipo31')))));
							e.feature.set('tipo32', Number(((getQueryVariable('tipo32')))));
							e.feature.set('tipo33', Number(((getQueryVariable('tipo33')))));
							
							e.feature.set('tipo41', Number(((getQueryVariable('tipo41')))));
							e.feature.set('tipo42', Number(((getQueryVariable('tipo42')))));
							e.feature.set('tipo43', Number(((getQueryVariable('tipo43')))));
							
							e.feature.set('tipo51', Number(((getQueryVariable('tipo51')))));
							e.feature.set('tipo52', Number(((getQueryVariable('tipo52')))));
							e.feature.set('tipo53', Number(((getQueryVariable('tipo53')))));
							
							e.feature.set('tipo61', Number(((getQueryVariable('tipo61')))));
							e.feature.set('tipo62', Number(((getQueryVariable('tipo62')))));
							e.feature.set('tipo63', Number(((getQueryVariable('tipo63')))));
							
							e.feature.set('tipo71', Number(((getQueryVariable('tipo71')))));
							e.feature.set('tipo72', Number(((getQueryVariable('tipo72')))));
							e.feature.set('tipo73', Number(((getQueryVariable('tipo73')))));
							
							e.feature.set('tipo81', Number(((getQueryVariable('tipo81')))));
							e.feature.set('tipo82', Number(((getQueryVariable('tipo82')))));
							e.feature.set('tipo83', Number(((getQueryVariable('tipo83')))));
							
							e.feature.set('tipo91', Number(((getQueryVariable('tipo91')))));
							e.feature.set('tipo92', Number(((getQueryVariable('tipo92')))));
							e.feature.set('tipo93', Number(((getQueryVariable('tipo93')))));
							
							e.feature.set('tipo101', Number(((getQueryVariable('tipo101')))));
							e.feature.set('tipo102', Number(((getQueryVariable('tipo102')))));
							e.feature.set('tipo103', Number(((getQueryVariable('tipo103')))));
							
							e.feature.set('tipo111', Number(((getQueryVariable('tipo111')))));
							e.feature.set('tipo112', Number(((getQueryVariable('tipo112')))));
							e.feature.set('tipo113', Number(((getQueryVariable('tipo113')))));
							
							e.feature.set('tipo121', Number(((getQueryVariable('tipo121')))));
							e.feature.set('tipo122', Number(((getQueryVariable('tipo122')))));
							e.feature.set('tipo123', (Number((getQueryVariable('tipo123')))));
							
							e.feature.set('tipo131', Number(((getQueryVariable('tipo131')))));
							e.feature.set('tipo132', Number(((getQueryVariable('tipo132')))));
							e.feature.set('tipo133', Number(((getQueryVariable('tipo133')))));
							
							e.feature.set('tipo141', Number(((getQueryVariable('tipo141')))));
							e.feature.set('tipo142', Number(((getQueryVariable('tipo142')))));
							e.feature.set('tipo143', Number(((getQueryVariable('tipo143')))));
							
							e.feature.set('tipo151', Number(((getQueryVariable('tipo151')))));
							e.feature.set('tipo152', Number(((getQueryVariable('tipo152')))));
							e.feature.set('tipo153', Number(((getQueryVariable('tipo153')))));
							
							e.feature.set('tipo161', Number(((getQueryVariable('tipo161')))));
							e.feature.set('tipo162', Number(((getQueryVariable('tipo162')))));
							e.feature.set('tipo163', Number(((getQueryVariable('tipo163')))));
							
							e.feature.set('tipo171', Number(((getQueryVariable('tipo171')))));
							e.feature.set('tipo172', Number(((getQueryVariable('tipo172')))));
							e.feature.set('tipo173', Number(((getQueryVariable('tipo173')))));
							
							e.feature.set('tipo181', Number(((getQueryVariable('tipo181')))));
							e.feature.set('tipo182', Number(((getQueryVariable('tipo182')))));
							e.feature.set('tipo183', Number(((getQueryVariable('tipo183')))));
							
							e.feature.set('tipo191', Number(((getQueryVariable('tipo191')))));
							e.feature.set('tipo192', Number(((getQueryVariable('tipo192')))));
							e.feature.set('tipo193', Number(((getQueryVariable('tipo193')))));
							
							e.feature.set('tipo201', Number(((getQueryVariable('tipo201')))));
							e.feature.set('tipo202', Number(((getQueryVariable('tipo202')))));
							e.feature.set('tipo203', Number(((getQueryVariable('tipo203')))));
							
							e.feature.set('tipo211', Number(((getQueryVariable('tipo211')))));
							e.feature.set('tipo212', Number(((getQueryVariable('tipo212')))));
							e.feature.set('tipo213', Number(((getQueryVariable('tipo213')))));
							
							e.feature.set('tipo221', Number(((getQueryVariable('tipo221')))));
							e.feature.set('tipo222', Number(((getQueryVariable('tipo222')))));
							e.feature.set('tipo223', Number(((getQueryVariable('tipo223')))));
							
							transactWFS('insert', e.feature);
						}
										
										);
						break;
						
						default:
						break;
				}
			});				
