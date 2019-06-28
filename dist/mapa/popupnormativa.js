       // Popup showing the position the user clicked

	  var normativa = document.getElementsByClassName("datos_normativa")[0];
	  var datos1 = document.getElementsByClassName("datos_1")[0];
	  var datos2 = document.getElementsByClassName("datos_2")[0];

      map.on('click', function(evt) {
		  
        var coordinate = evt.coordinate;
		  
		var feature = map.forEachFeatureAtPixel(evt.pixel,
            function(feature) {
              return feature;
            });
		  if (feature) {

		document.getElementById("datos_normativa").innerHTML = "";
		document.getElementById("datos_1").innerHTML = "";
		document.getElementById("datos_2").innerHTML = "";
		var perfil = document.getElementById("perfil").value;	

		  var json = {"items": [
		 {
		   "zona": "Zona: " + feature.get('normativa'),
		   "fos": "Ocupación suelo: " + feature.get('fos') ,
		   "fot": "Ocupación total: " + feature.get('fot') ,
		   "fov": "Ocupación verde: " + feature.get('fov') ,
		   "foss": "Ocupación subsuelo: " + feature.get('foss') ,
		   "ret_front": "Retiro frontal: " + feature.get('ret_front') + "mts",
		   "ret_later": "Retiro lateral: " + feature.get('ret_later') + "mts",
		   "ret_fond": "Retiro de fondo: " + feature.get('ret_fond') , 
		   "h_max": "Altura permitida: " + feature.get('h_max') + "mts",
			 
			 
		   "as": "Área suelo: " + numeral(feature.get('as')).format('0,0'),
		   "at": "Área total: " + numeral(feature.get('at')).format('0,0'),
		   "av": "Área verde: " + numeral(feature.get('av')).format('0,0'),
		   "ass": "Área subsuelo: " + numeral(feature.get('ass')).format('0,0'),			 
		   "viv": "Viviendas máx.: " + numeral(feature.get('viv_max')).format('0,0'),	
			 
			 
		   "pob": "Personas (max): " + numeral((feature.get('viv_max') * perfil)).format('0,0'),
		   "res": "Residuos (max): " + numeral((feature.get('viv_max') * perfil * 0.81)).format('0,0') + " kg/día",
		   "elec": "Electricidad (max): " + numeral((feature.get('viv_max') * perfil * 3193)).format('0,0') + " kw/hora",
		   "agua": "Agua (max): " + numeral((feature.get('viv_max') * perfil * 130)).format('0,0') + " lts/día",	 
			 
			 
		 }
		]};
		  
		var items = json.items;
		  
		for(var i = 0; i < items.length; i++) {
			var zona = document.createElement("p");
			normativa.appendChild(zona);
			zona.innerHTML = items[i].zona;			
			var fos = document.createElement("p");
			fos.innerHTML = items[i].fos;
			normativa.appendChild(fos);
			var fot = document.createElement("p");
			fot.innerHTML = items[i].fot;
			normativa.appendChild(fot);
			var fov = document.createElement("p");
			fov.innerHTML = items[i].fov;
			normativa.appendChild(fov);
			var foss = document.createElement("p");
			foss.innerHTML = items[i].foss;
			normativa.appendChild(foss);
			var ret_front = document.createElement("p");
			ret_front.innerHTML = items[i].ret_front;
			normativa.appendChild(ret_front);
			var ret_later = document.createElement("p");
			ret_later.innerHTML = items[i].ret_later;
			normativa.appendChild(ret_later);
			var ret_fond = document.createElement("p");
			ret_fond.innerHTML = items[i].ret_fond;
			normativa.appendChild(ret_fond);
			var h_max = document.createElement("p");
			h_max.innerHTML = items[i].h_max;
			normativa.appendChild(h_max);
			
			
			var as = document.createElement("p");
			as.innerHTML = items[i].as;
			datos1.appendChild(as);
			var at = document.createElement("p");
			at.innerHTML = items[i].at;
			datos1.appendChild(at);
			var av = document.createElement("p");
			av.innerHTML = items[i].av;
			datos1.appendChild(av);
			var ass = document.createElement("p");
			ass.innerHTML = items[i].ass;
			datos1.appendChild(ass);			
			var viv = document.createElement("p");
			viv.innerHTML = items[i].viv;
			datos1.appendChild(viv);
			
			var pob = document.createElement("p");
			pob.innerHTML = items[i].pob;
			datos2.appendChild(pob);
			var res = document.createElement("p");
			res.innerHTML = items[i].res;
			datos2.appendChild(res);
			var elec = document.createElement("p");
			elec.innerHTML = items[i].elec;
			datos2.appendChild(elec);
			var agua = document.createElement("p");
			agua.innerHTML = items[i].agua;
			datos2.appendChild(agua);
		} 
		  } else {
			  
			document.getElementById("datos_normativa").innerHTML = "Sin datos";
			document.getElementById("datos_1").innerHTML = "Sin datos";
			document.getElementById("datos_2").innerHTML = "Sin datos";
        }
      });
