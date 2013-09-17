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
<title>Bem vindo ao chat</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
</head>

<body>
<div id="contatos">
<span class="online" id="<?php echo $_SESSION['id_user'];?>"></span>
	<ul>
	<?php
		$selecionar_usuarios = BD::conn()->prepare("SELECT * FROM `usuarios` WHERE id != ?");
		$selecionar_usuarios->execute(array($_SESSION['id_user']));
		if($selecionar_usuarios->rowCount() == 0){
			echo '<p>Desculpla, não há contatos ainda!</p>';
		}else{
		while($usuario = $selecionar_usuarios->fetchObject()){
	?>
		<li><span class="type" id="<?php echo $usuario->id;?>"></span>
		<a href="javascript:void(0);" nome="<?php echo $usuario->nome;?>" id="<?php echo $usuario->id;?>" class="comecar"><?php echo $usuario->nome;?></a></li>
	<?php }}?>
	</ul>
</div>
<div style="position:absolute; top:0; right:0;" id="retorno"><div>
<div id="janelas"></div>
</body>
</html>