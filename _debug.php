<?php
require_once('inc/connection.php');
require_once('inc/album.php');
require_once('inc/pergunta.php');

$pergunta = new Pergunta();
$conn = new Conexao();
$id_usuario = 15;

$conn->Connect();


//checar a data_ultimo da pergunta da ultima pergunta do usuario 
$query = "SELECT data_ultimo FROM resposta";
$result=mysql_query($query) or die("Problema para trazer a data_ultimo da tabela pergunta".mysql_error()." ".var_dump($result));
$row = mysql_fetch_assoc($result);	 
mysql_free_result($result);

$dataBusca = new DateTime($row['data_ultimo']);
$dataAgora = new DateTime('NOW');
			
/* php novo */
//$interval = $dataAgora->diff($dataBusca);
//$interval = $dataBusca->diff($dataAgora)->format('%a');
//$dataResultado = (inte$interval->format('%d');
//$dataResultado = $interval->format('%d');

//var_dump($dataAgora == $dataAgora);


/* ***** */
/* php antigo funciona dessa forma */
$dataAgora = date('Y-m-d H:i:s'); //new DateTime('NOW');	
$dataBuscaFormato = date_format($dataBusca,'Y-m-d H:i:s');

$dtSearch = strtotime($dataBuscaFormato);
$dtNow = strtotime($dataAgora);

$diferenca = $dtNow - $dtSearch;
$days = (int)($diferenca / 86400);

$dataResultado = $days;

var_dump($dtSearch);
var_dump($dtNow);
var_dump($dataResultado);
var_dump($dtNow > $dtSearch);
var_dump($dtSearch > $dtNow);
var_dump($dtSearch == $dtNow);





$conn->disconnect();
		
//$difference = $dataAgora->diff($dataBusca);
//$dataResultado = (integer)$difference->days;

if (($dataAgora > $dataBuscaFormato) && ($pergunta->obterParticipacao($id_usuario) < $pergunta->qde_perguntas_dia)) {
	$pergunta->atualizaParticipacao($id_usuario, false, true);
	//return true;//retorno do possoPerguntar
	echo 'true';
}
//Quando a participação for igual ao limite
elseif (($dataAgora > $dataBuscaFormato)&&($pergunta->obterParticipacao($id_usuario) == $pergunta->qde_perguntas_dia)){
	$pergunta->atualizaParticipacao($id_usuario, true, false);
	$result = mysql_query($insert) ; //vai dar merda
	//return true;//retorno do possoPerguntar
	echo 'true';
} 
elseif($dtSearch == $dtNow){
	//return false;
	echo 'false';
}

?>