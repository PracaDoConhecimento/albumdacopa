<?php 
require_once('pergunta.php');
require_once('album.php');

// recebe post com a pergunta que foi feita e a resposta

$id_usuario = $_POST['id_usuario'];
$id_pergunta = $_POST['id_pergunta'];
$resposta_usuario = $_POST['resposta'];

$pergunta = new Pergunta();

//Trazer resposta via id que o formulário emitiu da pergunta
$resposta = $pergunta->obterRespostasID( $id_pergunta );
$opcao = $resposta_usuario;

//Comparar se a resposta e igual a escolha de resposta
if ( $resposta==$opcao ) { 
	$resposta = $pergunta->inserirFigurinha($id_usuario); //atualiza o banco de dados com um nova figurinha

	//resposta false se album completo
	if ($resposta == 10) {
		print("completo");
	} else {
		print("certa");
	}
}     
else {
	echo("errada");
}		

//Atualizar no banco de dados resposta a data da última pergunta respondida pelo usuário
$pergunta->atualizarResposta( $id_usuario, $id_pergunta );
?>