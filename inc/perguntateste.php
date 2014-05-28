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
		//@param 
		$pergunta->inserirFigurinha(17);


		var_dump($resposta);

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
		if($pergunta->possoPergunta(17)){
			$vetorPergunta=$pergunta->obterPergunta();
		} 

?>
		
	<form action="perguntateste.php" method="POST" > 		
	<?php echo($vetorPergunta[1]) ?><br/>
	
		<input type="hidden" name="id" value="<?php echo($vetorPergunta[0]); ?>"/>
		<input type ="radio" name="opcao" value="0"/> <?php echo($vetorPergunta[2]['a']); ?><br/>
  		<input type ="radio" name="opcao" value="1"/> <?php echo($vetorPergunta[2]['b']); ?><br/>
  		<input type ="radio" name="opcao" value="2"/> <?php echo($vetorPergunta[2]['c']); ?> <br/>
  		<input type ="radio" name="opcao" value="3"/> <?php echo($vetorPergunta[2]['d']); ?> <br/>
  		<input type="submit" name="btnSubmit" value="Submiter" />

	</form> 
<?php 
}
?>
<!-- FIM IF que testas se o form foi submetido --> 