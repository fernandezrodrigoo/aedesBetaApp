<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>app-aedes</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <!-- Gráficas -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script> 
	
	
	<!-- Tablas -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.0/semantic.min.css" rel="stylesheet" type="text/css" />
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css" rel="stylesheet" type="text/css" />

	
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.0/semantic.min.js"></script>
	
	<!-- Skin. Slider -->
  <link rel="stylesheet" href="../../plugins/bootstrap-slider/slider.css">
  <!-- Estilos Openlayers -->
  <link rel="stylesheet" href="https://openlayers.org/en/v4.6.4/css/ol.css" type="text/css"> 
  
  <!-- Librerías de OpenLayers -->
  <script src="https://openlayers.org/en/v4.6.4/build/ol.js" type="text/javascript"></script>

  <!-- Librerías de mapas base -->
  <script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script> 
  <!-- Librería proyecciones -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.4.4/proj4.js"></script>
  <!-- UTM 21 S -->
  <script src="http://epsg.io/32721.js"></script>

  <!-- Librería para exportar .png -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
	
  <!-- Consulta de geojson para textos dinámicos -->
  <script src="../../dist/numeral/numeral.min.js"></script>
  <script>
	  
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

    $(function() {
		
	  var settings = {
           "async": true,
           "crossDomain": true,
           "url": "http://geoserver.fadu.edu.uy:8080/geoserver/apps/wfs?service=WFS&version=1.0.0&request=GetFeature&typeName=apps:costaplan_areas_totales_sur&outputFormat=application/json",
		   "type": "integer",
           "method": "GET"
         }

         $.ajax(settings).done(function (response) {
           console.log(response);
			 
           var vivactuales = "<tr>" + "<td>" + numeral(response.features[5].properties.area_tot).format('0,0') + "</td>"
           $(vivactuales).appendTo("#viv_max");
		   var vivpropuesta = "<tr>" + "<td>" + numeral(response.features[5].properties.propuesta).format('0,0') + "</td>"
           $(vivpropuesta).appendTo("#viv_prop");
			 
			 
		   var poblacionactual = numeral(response.features[5].properties.area_tot * 2.8).format('0,0');
		   var poblacionpropuesta = numeral(response.features[5].properties.propuesta * 2.8).format('0,0');
			 
		   var pobactual = "<tr>" + "<td>" + poblacionactual + "</td>"
           $(pobactual).appendTo("#pob_max");
		   var pobpropuesta = "<tr>" + "<td>" + poblacionpropuesta + "</td>"
           $(pobpropuesta).appendTo("#pob_prop");
			 
           var asactual = "<tr>" + "<td>" + numeral(response.features[0].properties.area_tot).format('0,0') + "</td>"
           $(asactual).appendTo("#as_max");
		   var aspropuesta = "<tr>" + "<td>" + numeral(response.features[0].properties.propuesta).format('0,0') + "</td>"
           $(aspropuesta).appendTo("#as_prop");

           var atactual = "<tr>" + "<td>" + numeral(response.features[3].properties.area_tot).format('0,0') + "</td>"
           $(atactual).appendTo("#at_max");
		   var atpropuesta = "<tr>" + "<td>" + numeral(response.features[3].properties.propuesta).format('0,0') + "</td>"
           $(atpropuesta).appendTo("#at_prop");
			 
		   var vehactual = numeral(response.features[5].properties.area_tot * 029).format('0,0'); 
		   var vehpropuesta = numeral(response.features[5].properties.propuesta * 029).format('0,0');
			 
		   var vehiculosactual = "<span> | " + vehactual + "</span>"
           $(vehiculosactual).appendTo("#veh_max");
		   var vehiculosprop = "<span> | " + vehpropuesta + "</span>"
           $(vehiculosprop).appendTo("#veh_prop");
			 
		   var resactual = numeral(response.features[5].properties.area_tot * 2.8 * 0.81).format('0,0'); 
		   var respropuesta = numeral(response.features[5].properties.propuesta * 2.8 * 0.81).format('0,0');
			 
		   var ractual = "<span> | " + resactual + "</span>"
           $(ractual).appendTo("#res_max");
		   var rprop = "<span> | " + respropuesta + "</span>"
           $(rprop).appendTo("#res_prop");
			 
		   var kwactual = numeral(response.features[5].properties.area_tot * 2.8 * 3.193).format('0,0'); 
		   var kwpropuesta = numeral(response.features[5].properties.propuesta * 2.8 * 3.193).format('0,0');
			 
		   var eneractual = "<span> | " + kwactual + "</span>"
           $(eneractual).appendTo("#kw_max");
		   var enerpropuesta = "<span> | " + kwpropuesta + "</span>"
           $(enerpropuesta).appendTo("#kw_prop");
		 
		   var lactual = numeral(response.features[5].properties.area_tot * 2.8 * 130).format('0,0'); 
		   var lpropuesta = numeral(response.features[5].properties.propuesta * 2.8 * 130).format('0,0');
			 
		   var ltsactual = "<span> | " + poblacionactual + "</span>"
           $(ltsactual).appendTo("#lts_max");
		   var ltspropuesta = "<span> | " + poblacionpropuesta + "</span>"
           $(ltspropuesta).appendTo("#lts_prop");		 
		 });
		});
	  
	</script>
	
	
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="https://www.imcanelones.gub.uy" class="logo">
      <!-- mini logo para la barra lateral 50x50 pixels -->
      <span class="logo-mini">R|A</span>
      <!-- logo regular -->
      <span class="logo-lg"><b>Relevamiento|</b>Aedes</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Ocultar barra lateral -->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Cambiar navegación</span>
      </a>
      <!-- Botones del menú -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        </ul>
      </div>
    </nav>
	  
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <section class="sidebar">
      <!-- Usuario -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../../dist/img/aedes.png" class="user-image" alt="">
        </div>
        <div class="pull-left info">
          <p>Ficha de relevamiento</p>
          <!-- Estado -->
          <a href="#">Online</a>
        </div>
      </div>

      <!-- Lista de contenidos -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
        <!-- Proyecto -->
		<li><a href="../../aedes.html"><i class="fa fa-hand-o-left" aria-hidden="true"></i><span>Inicio</span></a></li>
        <!-- Etapas -->
		<li class="treeview menu">
          <a href="#"><i class="fa fa-map-o" aria-hidden="true"></i> <span>Mapas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <ul class="treeview-menu">
			<li ><a href="basico.html" ><span>Completo
				</span></a>
			</li>
			<li ><a href="basico.html" ><span>Mapas de calor
				</span></a>
			</li>
          </ul>
        </li>
        <!--  -->
        <li class="treeview menu">
          <a href="#"><i class="fa fa-map-o" aria-hidden="true"></i> <span>Datos</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <ul class="treeview-menu">
			<li ><a href="etapa1costa.html" class="header" ><span>Completos
				<div class="TriSea-technologies-Switch pull-right">
				</div>
				</span></a>
			</li>
			<li><a href="etapa1costacentro.html" class="header" ><span>Por categoría
				<div class="TriSea-technologies-Switch pull-right">
				</div>
				</span></a>
			</li>
	
          </ul>
        </li>

		<li class="header">Proyecto AEDES
			<div class="">
			  <img src="../../dist/img/logos/.png" alt="" height="40px">
			</div>
			<div class="">
			  <img src="../../dist/img/logos/.png" alt="" height="75px">	
			</div>
		</li>
		</ul>

    </section>
    <!-- -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proyecto|Aedes
        <small>Planilla de relevamiento</small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
		<div class="modal fade" id="tipos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updatetipos.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">% de Prevalencia tipológicas CostaPlan Sur</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-4">
						<h4 class="modal-title w-100 font-weight-bold">Padrones comunes</h4>
						<label>Frente</label>						  
						  <input value="68" class="form-control name_list" onblur="findTotal()" type="text" name="qty11" id="qty1"/> 
						<label>Lateral</label>						  
						  <input value="5" class="form-control name_list" onblur="findTotal()" type="text" name="qty12" id="qty2"/>
						<label>Frente|Fondo</label>						  
						  <input value="3" class="form-control name_list" onblur="findTotal()" type="text" name="qty13" id="qty3"/>
						<label>Fondo</label>						  
						  <input value="24" class="form-control name_list" onblur="findTotal()" type="text" name="qty14" id="qty4"/> 
						<label>Vacío</label>						  
						  <input value="0" class="form-control name_list" onblur="findTotal()" type="text" name="qty15" id="qty5"/> 
						<label>Total</label>	
						  <input class="form-control name_list" value="0" type="number" name="total" id="total" min="0" max="100" step="100" required/>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
		<div class="modal fade" id="tipos2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updatetiposcentro.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">% de Prevalencia tipológicas CostaPlan Centro</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-4">
						<h4 class="modal-title w-100 font-weight-bold">Padrones comunes</h4>
						<label>Frente</label>						  
						  <input value="54" class="form-control name_list" onblur="findTotal2()" type="text" name="qty21" id="qty1"/> 
						<label>Bilateral</label>						  
						  <input value="8" class="form-control name_list" onblur="findTotal2()" type="text" name="qty22" id="qty2"/> 
						<label>Frente|Fondo</label>						  
						  <input value="8" class="form-control name_list" onblur="findTotal2()" type="text" name="qty23" id="qty3"/> 
						<label>Fondo</label>						  
						  <input value="27" class="form-control name_list" onblur="findTotal2()" type="text" name="qty24" id="qty4"/> 
						<label>Vacío</label>						  
						  <input value="3" class="form-control name_list" onblur="findTotal2()" type="text" name="qty25" id="qty5"/> 
						<label>Total</label>	
						  <input class="form-control name_list" value="0" type="number" name="total" id="total2" min="0" max="100" step="100" required/>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
		
		
		<div class="modal fade" id="fos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updatefos.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Ocupación de suelo en planta baja</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Ocupación de suelo (FOS):</label>
						<input type="number" min="0.1" max="1" step="0.05" class="form-control" name="fos" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="fot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updatefot.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Ocupación total</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Ocupación total (FOT):</label>
						<input type="number" min="0.1" step="0.05" class="form-control" name="fot" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="fov" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updatefov.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Porcentaje de suelo permeable</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Suelo permeable (FOV):</label>
						<input type="number" min="0.0" max="1" step="0.05" class="form-control" name="fov" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="foss" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updatefoss.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Subsuelos</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Ocupación subsuelos (FOSS):</label>
						<input type="number" min="0.0" step="0.05" class="form-control" name="foss" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="m2xviv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updatem2xviv.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Metros cuadrados por vivienda</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Metros cuadrados/vivienda:</label>
						<input type="number" min="45" class="form-control" name="m2xviv" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ret_front" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updateret_front.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Retiro frontal</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Retiro frontal:</label>
						<input type="number" min="0.5" max="20" step="0.5" class="form-control" name="ret_front" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ret_later" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updateret_later.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Retiros bilaterales</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Retiros bilaterales:</label>
						<input type="number" min="0.5" max="10" step="0.5" class="form-control" name="ret_later" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ret_fond" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updateret_fondo.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Retiro de fondo</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Retiro de fondo:</label>
						<input type="number" min="0.5" step="0.5" class="form-control" name="ret_fond" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="hmax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updateh_max.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Altura máxima edificable</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Altura máxima:</label>
						<input type="number" min="3.5" step="0.5" class="form-control" name="hmax" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="niveles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<form name="display" action="updateniveles.php" method="POST">
					<h4 class="modal-title w-100 font-weight-bold">Cantidad de niveles permitidos</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form mb-5">
						  <label>Seleccionar zona:</label>
						  <select class="form-control" name="zona">
							  <option>Z01</option>
							  <option>Z01 b</option>
							  <option>Z02</option>
							  <option>Z03</option>
							  <option>Z03 b</option>
							  <option>ZG</option>
							  <option>ZEA</option>
							  <option>ZEB</option>
							  <option>ZEC</option>
							  <option>ZC</option>
						  </select>
					</div>
					<div class="md-form mb-4">
						<label>Niveles:</label>
						<input type="number" min="1.0"  step="1" class="form-control" name="niveles" required>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" name="submit" class="btn btn-default">Actualizar valor</button>
				</div>
				</form>
			</div>
		</div>
	</div>

      <div class="row" >
        <div class="col-md-12">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Datos de la vivienda</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" >
              <div class="form-row" >
					<form id="normativa" name="display" action="update.php" method="POST" >
					  <div class="form-group">
						  <h3 class="box-title">Nº Cluster</h3>
					  <div class="form-group col-md-3">
						<label>Especificar nº de cluster:</label>
						<input type="number" min="1" max="50" step="1" class="form-control" name="cluster" required>
					  </div>
					  <div class="form-group col-md-3">
						<label>Número de vivienda:</label>
						<input type="number"  min="1" step="1" class="form-control" name="vivienda" required>
					  </div>
					  <div class="form-group col-md-3">
						<label>Dirección:</label>
						<input type="text" class="form-control" name="direccion" required>
					  </div>
					  <div class="form-group col-md-3">
						<label>Nombre del residente:</label>
						<input type="text"  class="form-control" name="residente" required>
					  </div>
					  </div>
					  <div class="form-group">
						  <h3 class="box-title">Propiedad horizontal</h3>
					  <div class="form-group col-md-12">
						<label>Metros cuadrados por vivienda:</label>
						<input type="number"  min="45" class="form-control" name="m2xviv" required>
					  </div>
					  </div>
					  <div class="form-group">
						  <h3 class="box-title">Retiros</h3>
					  <div class="form-group col-md-4">
						<label>Retiro frontal:</label>
						<input type="number"  min="0.5" max="20" step="0.5" class="form-control" name="ret_front" required>
					  </div>
					  <div class="form-group col-md-4">
						<label>Retiros bilaterales:</label>
						<input type="number"  min="0.5" max="10" step="0.5" class="form-control" name="ret_later" required>
					  </div>
					  <div class="form-group col-md-4">
						<label>Retiro de fondo:</label>
						<input type="number" class="form-control" name="ret_fond" required>
					  </div>
					  </div>
					  <div class="form-group">
						  <h3 class="box-title">Alturas permitidas</h3>
					  <div class="form-group col-md-6">
						<label>Altura máxima:</label>
						<input type="number"  min="3.5" step="0.5" class="form-control" name="h_max" required>
					  </div>
					  <div class="form-group col-md-6">
						<label>Cant. niveles:</label>
						<input type="number"  min="1" step="1" class="form-control" name="niveles" required>
					  </div>
					  </div>
					  <div class="form-group">
						  <button type="submit" name="submit" class="btn btn-default">Actualizar los valores</button>
					  </div>
            </div>
            
          </div>
          </div>
		  </div>
		  </div>
			
		<div class="row" >
        <div class="col-md-12">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar parámetros individuales</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
			<div class="box-body" >
              <div>
				<div class="form-group">
					<h3 class="box-title">Factores de ocupación</h3>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#fos">Ocupación de suelo</a>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#fot">Ocupación total</a>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#fov">Suelo permeable</a>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#foss">Subsuelos</a>
				</div>
				<div class="form-group">
					<h3 class="box-title">Propiedad horizontal</h3>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#m2xviv">Metros cuadrados por vivienda</a>
				</div>
				<div class="form-group">
					<h3 class="box-title">Retiros</h3>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#ret_front">Retiro frontal</a>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#ret_later">Retiros bilaterales</a>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#ret_fond">Retiro de fondo</a>
				</div>
				<div class="form-group">
					<h3 class="box-title">Alturas permitidas</h3>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#hmax">Altura máxima</a>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#niveles">Cantidad de niveles</a>
				</div>
            </div>
          </div>
          </div>
		  </div>
		  </div>
		  
	  
		<div class="row" >
        <div class="col-md-12">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar prevalencias tipológicas</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" >
              <div class="form-row" >
					<form id="tipologias" name="display2" action="updatetipos.php" method="POST" >
					  
					
					<div class="form-group">
					<h3 class="box-title">Prevalencias tipológicas</h3>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#tipos">Actualizar tipologías CostaPlan Sur</a>
						<a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#tipos2">Actualizar tipologías CostaPlan Centro</a>
					</div>
            
          </div>
          </div>
		  </div>
		  </div>
		  </div>
          <!-- /.box -->
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  

  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <!-- Texto derecha -->
    <div class="pull-right hidden-xs">
      Versión beta - mayo 2019
    </div>
    <!-- Texto izquierda -->
    <strong>APP|AEDES</strong> Aplicación de relevamiento de proyecto aedes.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Lenguetas configuración derecha -->
    <div class="tab-content">
            <div class="box-body">
              
            </div>
            <!-- /.box-body -->
          <!-- /.box -->
        </div>
	<!-- Configuración -->
      <div class="tab-pane" id="datos">
      </div>
      <!--  -->
      
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- JS SCRIPTS -->
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>

<!-- Gráficas -->
<script src="../../dist/graficas/datoscosta.js"></script>

<!-- Tablas -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	
	<!-- Mapas disponibles -->
<script type="text/javascript">
function findTotal(){

	var arr = $('[name*=qty1]');;


	
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    document.getElementById('total').value = tot;
}
function findTotal2(){

	var arr = $('[name*=qty2]');;


	
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    document.getElementById('total2').value = tot;
}

</script>
	  
</body>
</html>
