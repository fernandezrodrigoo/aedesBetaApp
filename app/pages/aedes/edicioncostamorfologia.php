<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ModUrb</title>
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
	
	
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="https://www.imcanelones.gub.uy" class="logo">
      <!-- mini logo para la barra lateral 50x50 pixels -->
      <span class="logo-mini">M.U</span>
      <!-- logo regular -->
      <span class="logo-lg"><b>Modelación</b>Urbana</span>
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
          <img src="../../dist/img/logos/modurb.png" class="user-image" alt="">
        </div>
        <div class="pull-left info">
          <p>CostaPlan Sur</p>
          <!-- Estado -->
          <a href="#">Online</a>
        </div>
      </div>

      <!-- Lista de contenidos -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
        <!-- Proyecto -->
		<li><a href="../../modurb.html"><i class="fa fa-hand-o-left" aria-hidden="true"></i><span>Volver</span></a></li>
        <!-- Etapas -->
		<li class="header">E0 | Estadísticas</li>
		<li class="treeview menu">
          <a href="#"><i class="fa fa-map-o" aria-hidden="true"></i> <span>Síntesis estadística</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <ul class="treeview-menu">
			<li ><a href="estadisticascosta.html" ><span>Estadísticas generales
				</span></a>
			</li>
          </ul>
        </li>
		  
        <li class="header">E1 | Digitalización normativa</li>
        <!--  -->
        <li class="treeview menu">
          <a href="#"><i class="fa fa-map-o" aria-hidden="true"></i> <span>Normativa</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <ul class="treeview-menu">
			<li ><a href="etapa1costa.html" class="header" ><span>CostaPlan Sur
				<div class="TriSea-technologies-Switch pull-right">
				</div>
				</span></a>
			</li>
			<li><a href="etapa1costacentro.html" class="header" ><span>CostaPlan Centro
				<div class="TriSea-technologies-Switch pull-right">
				</div>
				</span></a>
			</li>
	
          </ul>
        </li>
		<li class="header">E2 | Morfologías</li>
        <!--  -->
        <li class="treeview menu">
          <a href="#"><i class="fa fa-map-o" aria-hidden="true"></i> <span>Morfologías</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <ul class="treeview-menu">
			<li ><a href="MorfologiaE1.html" class="header" ><span>CostaPlan Sur
				<div class="TriSea-technologies-Switch pull-right">
				</div>
				</span></a>
			</li>
			<li><a href="MorfologiaE1centro.html" class="header" ><span>CostaPlan Centro
				<div class="TriSea-technologies-Switch pull-right">
				</div>
				</span></a>
			</li>
	
          </ul>
        </li>
		<li class="header">E3 | Edición</li>
        <!--  -->
        <li class="treeview active menu-open">
          <a href="#"><i class="fa fa-map-o" aria-hidden="true"></i> <span>Edición de parámetros</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <ul class="treeview-menu">
			<li ><a href="#" class="bg-light-blue color-palette">
				<span>Editar Normativa
				<div class="TriSea-technologies-Switch pull-right">
				</div>
				</span></a>
			</li>
          </ul>
        </li>
		<li class="header">Convenio MVOTMA-FADU
			<div class="">
			  <img src="../../dist/img/logos/mvotma.png" alt="" height="40px">
			</div>
			<div class="">
			  <img src="../../dist/img/logos/farq-uy.png" alt="" height="75px">	
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
        CostaPlan
        <small>Resumen del cambio de norma</small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
	  
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
						  <h3 class="box-title">Tipologías base, % de prevalencias</h3>
					  <div class="form-group col-md-3">
						<label>Frente</label>						  
						  <input value="56" class="form-control name_list" onblur="findTotal()" type="text" name="qty" id="qty1"/> 
					  </div>
					  <div class="form-group col-md-3">
						<label>Bilateral</label>						  
						  <input class="form-control name_list" onblur="findTotal()" type="text" name="qty" id="qty2"/> 
					  </div>
					  <div class="form-group col-md-3">
						<label>Fondo</label>						  
						  <input class="form-control name_list" onblur="findTotal()" type="text" name="qty" id="qty3"/> 
					  </div>
					  <div class="form-group col-md-3">
						<label>Vacío</label>						  
						  <input class="form-control name_list" onblur="findTotal()" type="text" name="qty" id="qty4"/> 
					  </div>
					  </div>
					<div class="form-group">
					  <div class="form-group col-md-3">
						<label>Total</label>	
						  <input class="form-control name_list" value="0" type="number" name="total" id="total" min="0" max="100" step="100" required/>
					  </div>
					</div>
					<div class="form-group">					
					  <div class="form-group col-md-12">
						  <button type="submit" name="submit2" class="btn btn-default">Actualizar los valores</button>
					  </div>
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
      Versión 1.1 - Setiembre 2018
    </div>
    <!-- Texto izquierda -->
    <strong>SITU.</strong> Sistema de Información Territorial del ITU.
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
    var arr = document.getElementsByName('qty');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    document.getElementById('total').value = tot;
}

    </script>
</body>
</html>
