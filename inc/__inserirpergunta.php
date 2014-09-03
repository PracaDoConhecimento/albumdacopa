<?php
	$db_host = 'localhost'; // servidor
    $db_user = 'root'; // usuario do banco
    $db_pass = 'root'; // senha do usuario do banco
    $dbname  = "webpraca_albumdacopa";
    $con     = NULL;    

     

    function disconnect() { // fecha conexao        
        if(mysql_close()) {
            $con = false;
            return true;
        }
        else {
            return false;
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
	<title>Formulário de entrada de perguntada</title>
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
                <form action="./inserirpergunta.php" method="POST" role="form" class="form"> 

                    <h1>Insira uma nova pergunta:</h1>
                    <textarea name="pergunta"></textarea><br/>
                    <label>1º Resposta</label> <input type="text"  name="resposta1" class="form-control"/><br/>
                    <label>2º Resposta</label> <input type="text" name="resposta2" class="form-control"/><br/>
                    <label>3º Resposta</label> <input type="text"  name="resposta3" class="form-control"/><br/>
                    <label>4º Resposta</label> <input type="text"  name="resposta4" class="form-control"/><br/>
                    <label>Reposta Certa </label>
                    <select name="correta"  class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>            
                    </select>
                    <br/>
                    <input type="submit" value="Enviar" class="btn btn-success pull-right" />
                </form>
            </div>
        </div>
    </div>

    <p>&nbsp;</p><p>&nbsp;</p>

<?php 

	if (!empty($_POST['pergunta'])){

		/*$conn = new Conexao();
		$conn->Connect();*/

        $myconn = mysql_connect($db_host, $db_user, $db_pass);
        $seldb = mysql_select_db($dbname, $myconn);   

        mysql_query("SET NAMES 'utf8'");
        mysql_query('SET character_set_connection=utf8');
        mysql_query('SET character_set_client=utf8');
        mysql_query('SET character_set_results=utf8');

		$pergunta = base64_encode(htmlspecialchars($_POST['pergunta']));
        $respostas = array(utf8_encode($_POST['resposta1']),utf8_encode($_POST['resposta2']),utf8_encode($_POST['resposta3']),utf8_encode($_POST['resposta4']));
        $respostas = serialize($respostas);
		$correta = $_POST['correta']; 

        $sql = "INSERT INTO perguntas_respostas (pergunta, respostas,resposta_certa) VALUES ('$pergunta','$respostas','$correta');";

		$result=mysql_query($sql, $myconn);

        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
		
        //mysql_free_result($result);
		disconnect();

        echo 'OK';
	}

?>

<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: ["autolink"]
 });
</script>
</body>
</html>