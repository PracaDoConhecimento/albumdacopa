<meta charset="UTF-8"/>
<?php 
require_once("pergunta.php");

  
//Testar se foi passado pelo POST o submit isso acontecerá quando o formulário ainda não for submetido
if(!isset($_POST['btnSubmit'])){

	$pergunta = new Pergunta();
	
	//verificar se a pergunta pode ser feita o número passado é o id do usuário
	if($pergunta->possoPergunta(17)){
	//if(true){
			
		//Trazer as perguntas que vão ser colocadas no formulário
		$vetorPergunta=$pergunta->obterPergunta();
		
		
?>
		
<form action="perguntateste.php" method="POST" > 		
	<?php echo($vetorPergunta[1]) ?><br/>
	<input type="hidden" name="id" value="<?php echo($vetorPergunta[0]); ?>"/>
	<input type ="radio" name="opcao" value="1"/> <?php echo($vetorPergunta[2][0]); ?><br/>
  	<input type ="radio" name="opcao" value="2"/> <?php echo($vetorPergunta[2][1]); ?><br/>
  	<input type ="radio" name="opcao" value="3"/> <?php echo($vetorPergunta[2][2]); ?> <br/>
  	<input type ="radio" name="opcao" value="4"/> <?php echo($vetorPergunta[2][3]); ?> <br/>
  	<input type="submit" name="btnSubmit" value="Submiter" />
</form> 

<?php 
	}	
	else{
		echo("Você não pode fazer mais perguntas , aguarde até seu prazo passar :)");			
	}//FIM DO IF POSSO PERGUNTAR
}//FIM IF submiter


//Testar se o formulário já foi submetido por POST para verificar as respostas
 if(isset($_POST['btnSubmit'])){	
   	//terá que ser obtido via sessão
    $id_usuario = 17;
    $pergunta=new Pergunta();
    //Trazer resposta via id que o formulário emitiu da pergunta
	$resposta=$pergunta->obterRespostasID($_POST['id']);
	$opcao=$_POST['opcao'];
    //Comparar se a resposta e igual a escolha de resposta

	//teste se a respostas fosse certa
	//@param 
	$pergunta->inserirFigurinha($id_usuario);

		

	if($resposta==$opcao){
 		print("RESPOSTA CERTA");
 				
	  	}     
	else{
		print("RESPOSTA ERRADA");
	}
   		
   	//Atualizar no banco de dados resposta a data da última pergunta respondida pelo usuário
   	$pergunta->atualizarResposta($id_usuario,$_POST['id']);
  }

?>
<!-- FIM IF que testas se o form foi submetido --> 