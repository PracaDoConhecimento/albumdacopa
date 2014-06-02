<?php 
require_once('inc/header.inc.php');
require_once('inc/global.php');
require_once('inc/connection.php');


$user_id = $usuario->getID();

$conn = new Conexao(); 
$conn->Connect();	
$result = mysql_query("SELECT * FROM resposta WHERE id_usuario=$id_usuario") or die ('a busca deu o seguinte erro'.mysql_error());		
$num_row = mysql_num_rows($result);
mysql_free_result($result);

$query = "SELECT data_ultimo FROM resposta";
$result=mysql_query($query) or die("Problema para trazer a data_ultimo da tabela pergunta".mysql_error()." ".var_dump($result));
$row = mysql_fetch_assoc($result);

$dataBusca = $row['data_ultimo'];
$dataAgora = new DateTime('NOW');

var_dump($dataBusca);
var_dump($dataAgora);


require_once('inc/footer.inc.php'); 
?>