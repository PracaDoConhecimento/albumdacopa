<?php 
require_once('inc/header.inc.php');
require_once('inc/global.php');
require_once('inc/connection.php');
require_once('inc/usuario.php');


$id_usuario = 15; //$usuario->getID();




$conn = new Conexao(); 
$conn->Connect();	
$result = mysql_query("SELECT * FROM resposta WHERE id_usuario=$id_usuario") or die ('a busca deu o seguinte erro'.mysql_error());
$num_row = mysql_num_rows($result);
mysql_free_result($result);

// se não existir na tabela resposta, cadastra usuário
if ( $num_row != 1 ) {

	$insert = "INSERT INTO resposta (`id_usuario`,`data_ultimo`) VALUES ( $id_usuario, NOW() )";
	$result = mysql_query($insert) or die ("(inserir usuario na tabela pergunta) erro na inserção de dados -> ".mysql_error());
	
	$this->conn->disconnect();	
	return true; 

} 
// se existir checa a ultima vez que realizou iteração
else {

	$query = "SELECT data_ultimo FROM resposta";
	$result=mysql_query($query) or die("Problema para trazer a data_ultimo da tabela pergunta".mysql_error()." ".var_dump($result));
	$row = mysql_fetch_assoc($result);	

	$dataBusca = $row['data_ultimo'];
	$dataAgora = date('Y-m-d H:i:s'); //new DateTime('NOW');	

	$dtSearch = strtotime($dataBusca);
	$dtNow = strtotime($dataAgora);

	$diferenca = $dtNow - $dtSearch;
	$days = (int)($diferenca / 86400);

	echo $days;

}


require_once('inc/footer.inc.php'); 
?>