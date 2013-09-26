<? include('libs/php/constantes.php'); ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title><?=TITULO_SISTEMA?> - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Proyecto ASI 2">
    <meta name="author" content="@G3rcar">

    <link href="res/css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

      .encabezado{
        text-align: center;
        z-index: 100;
        color:#EEEEEE;
      }

      .back_black{
        height: 80px;
        width: 100%;
        background: #000;
        position: fixed;
        top:0;
        z-index: -1;
      }

      
    </style>
    <link href="res/css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="res/img/favicon.png">
  </head>

  <body>

    <div class="container">

      <div class="page-header encabezado">
          <h2>Consultorio M&eacute;dico Cerna y Alvarado <small>Intranet</small></h2>
      </div>

      <br />
                
      <form class="form-signin" action="javascript:login();void(0);">
        <h3 class="form-signin-heading">Inicio</h3>
        <input id="user" type="text" class="input-block-level" placeholder="Usuario">
        <input id="password" type="password" class="input-block-level" placeholder="Password">

        <button id="loginButton" class="btn btn-large btn-primary" type="submit">Entrar</button>

          
          <div id="error_msg"></div>
      </form>
                
    </div>
    <div class="back_black"> &nbsp; </div>

    <!-- javascript
    ================================================== -->
    <!-- al final para que la pagina cargue rapido -->
    <script type="text/javascript" src="libs/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="libs/js/bootstrap/bootstrap-alert.js"></script>
    <script type="text/javascript" src="libs/js/md5.js"></script>

    <script>

  		function notify(t,m,type){
  			var tipo = (typeof(type)=='undefined')?'error':type;
        var obj = document.getElementById('error_msg');
        var actual = obj.innerHTML;
  			var body = '<div class="alert alert-'+tipo+'" style="margin-top:30px; margin-bottom:0;">'+
				        	'<button type="button" class="close" data-dismiss="alert">×</button>'+
				        	'<strong>'+t+'</strong><br /> '+m+
				        '</div>';
			 obj.innerHTML = body+actual;
  		} 
      var loading=false;
    	function login(){
        if(loading) return;
        toggle(false);

  			var usr = $('#user').val();
  			var pss = $('#password').val();
  			if(usr=='' || pss==''){ notify("Error","Ingrese los datos completos","warning"); toggle(true); return; }
        if(pss!='') pss = md5(pss);

        $.ajax({
  				url:'stores/login.php',
  				data:'user='+usr+'&pass='+pss, dataType:'json', type:'POST',
  				complete:function(datos){
  				  var T = jQuery.parseJSON(datos.responseText);
  					
  					if(T.t=="true"){ window.location = "index.php"; }
  					else{ notify("Error",T.msg,"error"); }
            toggle(true);
  				}
  			});

  		}
      function toggle(v){
        if(v){ $('#loginButton').removeClass('disabled').html('Entrar'); }
        else{ $('#loginButton').addClass('disabled').html('Cargando...'); }
      }
    </script>

  </body>
</html>
