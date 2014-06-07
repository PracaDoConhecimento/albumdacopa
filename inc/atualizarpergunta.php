<?php 
	require_once('connection.php');
?>
<html>
	<head>
			
	</head>

	 <form action="./atualizarpergunta.php" method="POST" role="form" class="form"> 

                    <h1>Digite a pergunta que será atualizada</h1>
                    <textarea name="perguntabusca"></textarea><br/>
                    
                    <br/>
                    <input type="submit" value="Buscar" class="btn btn-success pull-right" />
                </form>
                
	
	
	<?php 

	//Entrar quando o submite da atualização da pergunta acontecer
	if (!empty($_POST['perguntabusca'])){

		$conn = new Conexao();
		$conn->Connect();
		
		$pergunta=$_POST['perguntabusca'];
		
		$result=mysql_query("SELECT * FROM perguntas_respostas WHERE pergunta like '%$pergunta%' ");
		$row = mysql_fetch_array($result);
		$row_respostas = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'",$row[2]);
		
		
		$respostas = unserialize($row_respostas);
		$conn->disconnect();
	

?>
	
	
 <form action="./atualizarpergunta.php" method="POST" role="form" class="form"> 

                    <input type="hidden" name="id" value=<?php print($row[0])?> />
                    <h1>Atualize a pergunta:</h1>
                    <textarea name="pergunta" ><?php print($row[1])?></textarea><br/>
                    <label>1º Resposta</label> <input type="text"  name="resposta1" class="form-control" value="<?php print($respostas[0]) ?>" > <br/>
                    <label>2º Resposta</label> <input type="text" name="resposta2" class="form-control" value="<?php print($respostas[1]) ?>" ><br/>
                    <label>3º Resposta</label> <input type="text"  name="resposta3" class="form-control" value="<?php print($respostas[2]) ?>" ><br/>
                    <label>4º Resposta</label> <input type="text"  name="resposta4" class="form-control" value="<?php print($respostas[3]) ?>" ><br/>
                    <label>Reposta Certa </label>
                   	<input type="text"  name="correta" class="form-control" value=<?php print($row['resposta_certa'])?>><br/>
                    <br/>
                    <input type="submit" value="Atualizar" class="btn btn-success pull-right" />
                </form>
	<?php
	}//FIM if (!empty($_POST['perguntabusca'])){ 
		 
	//Entrar caso o formulário pergunta esteja preenchido
	if (!empty($_POST['pergunta'])){

		$conn = new Conexao();

		$conn->Connect();
		$id=$_POST['id'];
		$pergunta = $_POST['pergunta'] ;
		$resposta = serialize(array($_POST['resposta1'],$_POST['resposta2'],$_POST['resposta3'],$_POST['resposta4']));
		$correta = $_POST['correta']; 

		$result=mysql_query("UPDATE perguntas_respostas SET pergunta='$pergunta',respostas='$resposta', resposta_certa='$correta' WHERE id='$id';");
			
		$conn->disconnect();
	}

?>
</html>	
	