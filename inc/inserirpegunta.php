<?php
	require_once('connection.php');
?>


<!DOCTYPE html>
<html>
<head>
	<title>Formulário de entrada de perguntada</title>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
    <script src="../js/vendor/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="../js/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>
    <script src="../js/tinymce/tinymce.min.js" type="text/javascript"></script>
</head>
<body>

    <h1>Inserir pergunta:</h1>
    
	<form action="./inserirpegunta.php" method="POST"> 

		<textarea name="pergunta" id="pergunta"/></textarea><br/>
		1º Resposta <input type="text"  name="resposta1"/><br/>
		2º Resposta <input type="text" name="resposta2"/><br/>
		3º Resposta <input type="text"  name="resposta3"/><br/>
		4º Resposta <input type="text"  name="resposta4"/><br/>
		Reposta Certa 
        <select name="correta"/>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select><br/>
		<input type="submit" value="OK" />
	</form>


<?php 

	if (!empty($_POST['pergunta'])){
		
		$conn = new Conexao();
		
		$conn->Connect();
								
		$pergunta_html = htmlentities($_POST['pergunta']);
        $pergunta = mysql_real_escape_string ($pergunta_html);
		$resposta = serialize(array($_POST['resposta1'],$_POST['resposta2'],$_POST['resposta3'],$_POST['resposta4']));
		$correta = $_POST['correta']; 
	
        //echo "INSERT INTO perguntas_respostas (pergunta, respostas,resposta_certa) VALUES ('$pergunta','$resposta','$correta');";
        
		$result=mysql_query("INSERT INTO perguntas_respostas (pergunta, respostas,resposta_certa) VALUES ('$pergunta','$resposta','$correta');");
        
		
		$conn->disconnect();
        
        //pra retornar o valor da pergunta
        //usar o metodo html_entity_decode 
	}

?>

    <script lang="javascript">
        $(document).ready(function(){
            tinymce.init({
                selector: 'textarea',
                theme: "modern",
                toolbar_items_size: 'small'
            }) 
        });
    </script>
</body>
</html>



