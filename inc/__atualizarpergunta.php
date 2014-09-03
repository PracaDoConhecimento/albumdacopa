<?php 
	require_once('connection.php');
	require_once('pergunta.php');

	$conn = new Conexao();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Formulário para atualizar perguntada</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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

			$conn->Connect();
			
			$pergunta=$_POST['perguntabusca'];
			$sql = "SELECT * FROM perguntas_respostas WHERE pergunta like '%$pergunta%' ";
			$result=mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$row_respostas = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'",$row[2]);
			
			
			$respostas = unserialize($row_respostas);
			//var_dump($respostas);
			//$respostas = array_map('utf8_encode', $respostas ); // encode the array again

			$conn->disconnect();
		

	?>
		
	    <div class="container">
	        <div class="row">
	            <div class="col-xs-12">

	 				<form action="./atualizarpergunta.php" method="POST" role="form" class="form"> 
	 					<?php 
							$resposta1 = utf8_decode($respostas[0]);
							$resposta2 = utf8_decode($respostas[1]);
							$resposta3 = utf8_decode($respostas[2]);
							$resposta4 = utf8_decode($respostas[3]);
	 					?>
	 					<input type="hidden" name="pergunta" value="<?php print($row[0])?>" >
	                    <input type="hidden" name="id" value="<?php print($row[0])?>" >
	                    <h1>Atualize a pergunta:</h1>
	                    <input type="text" name="perguntabusca" value="<?php echo htmlspecialchars($row[1]); ?>" class="form-control" ><br/>
	                    <label>1º Resposta</label> <input type="text"  name="resposta1" class="form-control" value="<?php echo $resposta1; ?>" > <br/>
	                    <label>2º Resposta</label> <input type="text"  name="resposta2" class="form-control" value="<?php echo $resposta2; ?>" ><br/>
	                    <label>3º Resposta</label> <input type="text"  name="resposta3" class="form-control" value="<?php echo $resposta3; ?>" ><br/>
	                    <label>4º Resposta</label> <input type="text"  name="resposta4" class="form-control" value="<?php echo $resposta4; ?>" ><br/>
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

			$perguntaClass = new Pergunta();
			
			$id = $_POST['id'];
			$pergunta_nova = $_POST['pergunta'] ;
			$respostas_novas = array(utf8_encode($_POST['resposta1']),utf8_encode($_POST['resposta2']),utf8_encode($_POST['resposta3']),utf8_encode($_POST['resposta4']));
			$respostacorreta_nova = $_POST['correta']; 

			$perguntaClass->atualizarPergunta($id, $pergunta_nova, $respostas_novas, $respostacorreta_nova);
							
		}

	?>
	</body>
</html>	
	