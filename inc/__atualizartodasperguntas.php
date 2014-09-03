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
		<?php 

		//Entrar quando o submite da atualização da pergunta acontecer

			$conn->Connect();
						
			$sql = "SELECT * FROM perguntas_respostas";
			$result=mysql_query($sql) or die(mysql_error());

			while($row = mysql_fetch_assoc($result)):
				$rows[] = $row;

				$row = mysql_fetch_array($result);
				$row_respostas = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'",$row[2]);

				$respostas = unserialize($row_respostas);			


				var_dump($row);

?>

		<div class="container">
	        <div class="row">
	            <div class="col-xs-12">

	 				<form action="./atualizartodasperguntas.php" method="POST" role="form" class="form" name="form_id_<?php print($row[0])?>"> 
	 					<?php 
							$resposta1 = utf8_decode($respostas[0]);
							$resposta2 = utf8_decode($respostas[1]);
							$resposta3 = utf8_decode($respostas[2]);
							$resposta4 = utf8_decode($respostas[3]);
	 					?>
	 					<input type="hidden" name="pergunta" value="<?php print($row[0])?>" >
	                    <input type="hidden" name="id" value="<?php print($row[0])?>" >
	                    <h1>Atualize a pergunta (<?php print($row[0])?>):</h1>
	                    <textarea name="pergunta_texto" class="form-control" ><?php echo htmlspecialchars($row[1]); ?></textarea>
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

	    <hr />



<?php 
			endwhile;
			$conn->disconnect();
		
			 
		//Entrar caso o formulário pergunta esteja preenchido
		if (!empty($_POST['pergunta'])){

			$perguntaClass = new Pergunta();
			
			$id = $_POST['id'];
			$pergunta_nova = $_POST['pergunta_texto'] ;
			$respostas_novas = array(utf8_encode($_POST['resposta1']),utf8_encode($_POST['resposta2']),utf8_encode($_POST['resposta3']),utf8_encode($_POST['resposta4']));
			$respostacorreta_nova = $_POST['correta']; 

			var_dump($pergunta_nova);
			var_dump($respostas_novas); die();

			$perguntaClass->atualizarPergunta($id, $pergunta_nova, $respostas_novas, $respostacorreta_nova);
							
		}

	?>
	<script type="text/javascript">
	tinymce.init({
	    selector: "textarea"
	 });
	</script>
	</body>
</html>	
	