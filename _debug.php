<?php
require_once('inc/connection.php');
require_once('inc/album.php');
require_once('inc/pergunta.php');

$conn = new Conexao();
$id_usuario = 15;

$conn->Connect();

//obter todas figurinhas que o usuário não tenha
$result = mysql_query("SELECT * FROM album  WHERE id_usuario=$id_usuario ");

while ($row = mysql_fetch_assoc($result)){

	$rows[]= $row;
}

mysql_free_result($result);


//Trazer as figurinhas existentes
$sql="SELECT id FROM figurinha";

if(!empty($rows)){

	$length = sizeof($rows);

	$sql=$sql." where";

	for($i=0;$i<$length;$i++){
		//inserir os ids das figurinhas que o usuário já possui
		$row=$rows[$i];
		$sql=$sql." id<>".$row["id_figurinha"];

		//Verificar se uma posição depois para acrescentar
		if(!empty($rows[$i+1])){
			$sql=$sql." AND";	
		}


	}//FIM FOR
} else {
	$sql=$sql . ";";
}//FIM IF

/*var_dump($rows);*/



//pegar agora o resultado da query das figurinhas que faltam
$result_fig_falta = mysql_query($sql);


// se for falso não tem nenhuma figurinha
if ( mysql_num_rows($result_fig_falta) > 0 ) {
	//Preencher o vetor com as figurinhas que o usuário não tem 
	while ($row_f = mysql_fetch_assoc($result_fig_falta)){

		$rows_f[]=$row_f;
	}
	mysql_free_result($result_fig_falta);

	//random com o tamanho do vetor rows para pegar o id sorteado
	$tamanho = sizeof($rows_f);

	$random = rand(0,$tamanho-1);
	$id_figurinha = $rows_f[$random]['id'];		

	$insert="INSERT INTO album (id_usuario,id_figurinha) VALUES ($id_usuario,$id_figurinha);";
	$result_insert = mysql_query($insert) or die ("erro na inserção de dados ->".mysql_error());
	
	var_dump( $id_figurinha ); die();
	
	$conn->disconnect();	
	return $id_figurinha;
} 
else {

	return 10; //codigo de album completo
}

?>