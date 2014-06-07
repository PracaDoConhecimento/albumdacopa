<?php 
	require_once('connection.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Formulário para atualizar perguntada</title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
	    <link rel="stylesheet" href="../css/bootstrap.min.css">        
	    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
	    
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	    <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
	    <script src="../js/tinymce/jquery.tinymce.min.js" lang="text/javascript"></script>
	    <script src="../js/tinymce/tinymce.min.js" lang="text/javascript"></script>
	</head>

	<body>
		 <div class="container">
	        <div class="row">
	            <div class="col-xs-12">
	                
		 			<form action="./atualizarpergunta.php" method="POST" role="form" class="form"> 

	                    <h1>Digite parte do texto da pergunta que será atualizada</h1>
	                    <input type="text" name="perguntabusca" class="form-control" ><br/>
	                    
	                    <br/>
	                    <input type="submit" value="Buscar" class="btn btn-success pull-right" />
	                </form>
		                
			 	</div>
	        </div>
	    </div>
		
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
		
	    <div class="container">
	        <div class="row">
	            <div class="col-xs-12">

	 				<form action="./atualizarpergunta.php" method="POST" role="form" class="form"> 

	                    <input type="hidden" name="id" value="<?php print($row[0])?>" >
	                    <h1>Atualize a pergunta:</h1>
	                    <input type="text" name="perguntabusca" value="<?php print($row[1])?>" class="form-control" ><br/>
	                    <label>1º Resposta</label> <input type="text"  name="resposta1" class="form-control" value="<?php print($respostas[0]) ?>" > <br/>
	                    <label>2º Resposta</label> <input type="text" name="resposta2" class="form-control" value="<?php print($respostas[1]) ?>" ><br/>
	                    <label>3º Resposta</label> <input type="text"  name="resposta3" class="form-control" value="<?php print($respostas[2]) ?>" ><br/>
	                    <label>4º Resposta</label> <input type="text"  name="resposta4" class="form-control" value="<?php print($respostas[3]) ?>" ><br/>
	                    <label>Reposta Certa </label>
	                   	<input type="text"  name="correta" class="form-control" value=<?php print($row['resposta_certa'])?>><br/>
	                    <br/>
	                    <input type="submit" value="Atualizar" class="btn btn-success pull-right" />
	                </form>

	            </div>
	        </div>
	    </div>

	    <p>&nbsp;</p><p>&nbsp;</p>

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
	</body>
</html>	
	