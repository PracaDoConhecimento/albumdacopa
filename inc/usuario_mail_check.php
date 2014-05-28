<?php 
//require_once('global.php');
require_once('usuario.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	$email = $_POST['user_email'];

	//se houver usuario, retorna falso
	//retorno para o ajax
	echo ( !$usuario->emailUsuarioCheck($email) ) ? 'false' : 'true';

} else {
	echo 'Metodo requisitado proibido.';
}

?>