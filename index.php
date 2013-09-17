<?php
	session_start();
	include_once "config.php";
	require_once('classes/BD.class.php');
	BD::conn();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entre no chat</title>
<style type="text/css">
	*{margin:0; padding:0;}
	body{background:#f4f4f4;}
	div#formulario{width:500px; padding:5px; height:100px; background:#fff; border:1px solid #333;
	position:absolute; left:50%; top:50%; margin-left:-250px; margin-top:-50px;}
	div#formulario span{font:18px "Trebuchet MS", tahoma, arial; color:#036; float:left; width:100%; margin-bottom:10px;}
	div#formulario input[type=text]{padding:5px; width:485px; border:1px solid #ccc; outline:none; font:16px tahoma, arial;
	color:#666;}
	div#formulario input[type=text]:focus{border-color:#036;}
	div#formulario input[type=submit]{padding:4px 6px; background:#069; font:15px tahoma, arial; color:#fff; border:1px solid #036;
	float:left; margin-top:5px; text-align:center; width:95px; text-shadow:#000 0 1px 0;}
	div#formulario input[type=submit]:hover{cursor:pointer; background:#09f;}
</style>
</head>

<body>
<?php
	if(isset($_POST['acao']) && $_POST['acao'] == 'logar'):
		$email = strip_tags(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
		
		if($email == ''){}else{
			$pegar_user = BD::conn()->prepare("SELECT id FROM `usuarios` WHERE email = ?");
			$pegar_user->execute(array($email));
			if($pegar_user->rowCount() == 0){
				echo '<script>alert("Usuário não encontrado")</script>';
			}else{
				$fetch = $pegar_user->fetchObject();

				$atual = date('Y-m-d H:i:s');
				$expira = date('Y-m-d H:i:s', strtotime('+1 min'));
				$update = BD::conn()->prepare("UPDATE `usuarios`SET horario = ?, limite = ? WHERE email = ?");
				$update->execute(array($atual, $expira, $email));
				
				$_SESSION['id_user'] = $fetch->id;
				echo '<script>alert("Login efetuado");location.href="chat.php"</script>';
			}
		}
	endif;
?>
	<div id="formulario">
	<span>Digite seu e-mail</span>
		<form action="" method="post" enctype="multipart/form-data">
			<label>
				<input type="text" name="email" />
			</label>
			<input type="hidden" name="acao" value="logar" />
			<input type="submit" value="Logar" />
		</form>
	</div>
</body>
</html>