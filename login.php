<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Consultorio M&eacute;dico Cerna y Alvarado - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Proyecto ASI 2">
    <meta name="author" content="@G3rcar">

    <link href="res/css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
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

    </style>
    <link href="res/css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="res/img/favicon.png">
  </head>

  <body>

    <div class="container">
    	<form class="form-signin" action="javascript:login();void(0);">
    		<h2 class="form-signin-heading">Inicie Sesi&oacute;n</h2>
    		<input id="user" type="text" class="input-block-level" placeholder="Usuario">
    		<input id="password" type="password" class="input-block-level" placeholder="Password">

    		<button class="btn btn-large btn-primary" type="submit">Entrar</button>

	        
	        <div id="error_msg"></div>
	    </form>

    </div>

    <!-- javascript
    ================================================== -->
    <!-- al final para que la pagina cargue rapido -->
    <script type="text/javascript" src="libs/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="libs/js/bootstrap/bootstrap-alert.js"></script>

    <script>

  		function notify(t,m){
  			var obj = document.getElementById('error_msg');
        	var actual = obj.innerHTML;
  			var body = '<div class="alert alert-error" style="margin-top:30px; margin-bottom:0;">'+
				        	'<button type="button" class="close" data-dismiss="alert">×</button>'+
				        	'<strong>'+t+'</strong><br /> '+m+
				        '</div>';
			 obj.innerHTML = body+actual;
  		} 

    	function login(){
			var usr = $('#user').val();
			var pss = $('#password').val();
			$.ajax({
				url:'login_store.php',
				data:'user='+usr+'&pass='+pss, dataType:'json', type:'POST',
				complete:function(datos){
					console.log(datos.responseText);
					var T = jQuery.parseJSON(datos.responseText);
					console.log(T.msg);
					
					if(T.t=="true"){ window.location = "index.php"; }
					else{ notify("Error",T.msg); }
				}
			});

		}
    </script>

  </body>
</html>
