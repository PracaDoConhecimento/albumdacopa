<?php 
	require_once('connection.php');
	require_once('pergunta.php');

	$conn = new Conexao();
?>

<!DOCTYPE html>
<html>
	<head>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	    
		<title>Formulário para atualizar perguntada</title>

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

		while($row = mysql_fetch_array($result)):

			$pergunta = html_entity_decode(base64_decode($row[1]));
			
			//$row_respostas = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'",$row[2]);

			$respostas = unserialize($row[2]);	

			$resposta1 = utf8_decode($respostas[0]);
			$resposta2 = utf8_decode($respostas[1]);
			$resposta3 = utf8_decode($respostas[2]);
			$resposta4 = utf8_decode($respostas[3]);

			$resposta_certa = $row[3];
		?>
		<div class="container">
	        <div class="row">
	            <div class="col-xs-12">
	                    Pergunta (<?php print($row[0]); ?>):<br>
	                    <b><?php echo $pergunta; ?></b>
	                    <ul>
		                    <li><?php echo $resposta1; ?></li>
		                    <li><?php echo $resposta2; ?></li>
		                    <li><?php echo $resposta3; ?></li>
	                	</ul>
	                    <label>Reposta Certa</label> <?php echo $resposta_certa; ?>
	                    <br/>
	            </div>
	        </div>
	    </div>

	    <p>&nbsp;</p>
	    <p>&nbsp;</p>

	    <hr />
<?php 
		endwhile;
		$conn->disconnect();
?>
	</body>
</html>	
	