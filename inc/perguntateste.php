<?php 

	require_once("pergunta.php");
	
   if(isset($_POST['btnSubmit']))
   {
        
      	$pergunta=new Pergunta();
      //Trazer resposta via id que o formulário emitiu da pergunta
		$resposta=$pergunta->obterRespostasID($_POST['id']);
		$opcao=$_POST['opcao'];
    //Comparar se a resposta e igual a escolha de resposta
		
		//teste se a respostas fosse certa
		$pergunta->inserirFigurinha(8);
		if($resposta==$opcao){
 			print("RESPOSTA CERTA");
 			
	  	}     
		else{
			print("RESPOSTA ERRADA");
		}
   
   }

   if(!isset($_POST['btnSubmit'])){
	
		$pergunta = new Pergunta();
		// Esse ID deverá ser obtido pela sessão
		if($pergunta->possoPergunta(8)){
			
			$vetorPergunta=$pergunta->obterPergunta();
						
	} 
		
?>
		
	<form action="perguntateste.php" method="POST" > 		
	<?php echo($vetorPergunta[1]) ?><br/>
	
		<input type="hidden" name="id" value="<?php echo($vetorPergunta[0]); ?>"/>
		<input type ="radio" name="opcao" value="1"/> <?php echo($vetorPergunta[2][0]); ?><br/>
  		<input type ="radio" name="opcao" value="2"/> <?php echo($vetorPergunta[2][1]); ?><br/>
  		<input type ="radio" name="opcao" value="3"/> <?php echo($vetorPergunta[2][2]); ?> <br/>
  		<input type="submit" name="btnSubmit" value="Submiter" />
		

	</form> 
<?php 
}
?>
<!-- FIM IF que testas se o form foi submetido --> 	

