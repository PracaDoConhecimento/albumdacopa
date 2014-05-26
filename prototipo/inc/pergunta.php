<?php
	require_once('global.php');
	require_once('connection.php');

?>
<html>

<head>
	
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<!--TESTE QUE SIMULA OS VALORES PASSADOS PELO O FORMULÁRIO FUTURO ESTARÁ FORA -->
<?php
	
   if(isset($_POST['btnSubmit']))
   {
        
      	$pergunta=new Pergunta();
      //Trazer resposta via id que o formulário emitiu da pergunta
		$resposta=$pergunta->obterRespostasID($_POST['id']);
		$opcao=$_POST['opcao'];
    //Comparar se a resposta e igual a escolha de resposta
		
		//teste se a respostas fosse certa
		$pergunta->inserirFigurinha(1);
		if($resposta==$opcao){
 			print("RESPOSTA CERTA");
 			
	  	}     
		else{
			print("RESPOSTA ERRADA");
		}
   
   }

?>
	
</head>

<body>

<?php
		

	Class Pergunta{
		
		private $conn;
		
		public function Pergunta(){
			$this->conn=new Conexao();
		}
		
		/**
		* 
		* @param ID do usuario logado $id_usuario
		* 
		* @return
		*/
		public function possoPergunta($id_usuario){
			 
			$this->conn->Connect();	
			$result = mysql_query(" SELECT * FROM resposta WHERE id_usuario=$id_usuario") or die ('a busca deu o seguinte erro'.mysql_error());		
			
			$num_row = mysql_num_rows($result);
			
			
			//testar se o usuario existe na pergunta senão cadastrar  
			if($num_row!=NULL){
				//checar a data da pergunta da ultima pergunta do usuario 
			 	$query = "SELECT data FROM resposta";
			 	$result=mysql_query($query) or die("Problema para trazer a data da tabela pergunta".mysql_error());
			 	
				$row = mysql_fetch_assoc($result);	 
				mysql_free_result($result);
				
				
				$dataBusca = new DateTime($row['data']);
				$dataAgora = new DateTime('NOW');
				$dataResultado = $dataBusca->diff($dataAgora);
								
				//Se a diferença entre o dia da última pergunta for de 1 
				if($dataResultado->days>=1){
					
					return true;
					
					$this->conn->disconnect();
				}
					
			 }
			 //inserir o usuario na tabela pergunta, pois até então ele não existia lá , futuro REFATORAR para outro método
			else{
			 	//inserir 
				$insert = "INSERT INTO resposta (`id_usuario`) VALUES ($id_usuario)";
			 	//processar
				$result = mysql_query($insert) or die ("erro na inserção de dados".msql_erro());
			 	$this->conn->disconnect();	 	
			}
			
			
		}//FIM fazerPergunta
		
		//Função que vai trazer as perguntas
		public function obterPergunta (){
			
			$this->conn->Connect();	
			$resultAsk=mysql_query("select * from perguntas_respostas") or die (mysql_error());
				
				while ($row = mysql_fetch_assoc($resultAsk)){
						
					$rows[]= array($row['id'],$row['pergunta'],unserialize($row['respostas']),$row['resposta_certa']);
				}
				
				mysql_free_result($resultAsk);
			  $this->conn->disconnect();	
					
				//Pegar o tamanho do array obtido
				$tamanho= sizeof($rows);

				$random = rand(0,$tamanho-1);	
					
				return $rows[$random];
		}//FIM obterPergunta
		
		public function obterRespostasID($id_pergunta){
			
			$this->conn->Connect();	
			
			$result=mysql_query("select pe.resposta_certa from albumdacopa.perguntas_respostas as pe where pe.id=$id_pergunta;") or die (mysql_error());
			$meta = mysql_fetch_assoc($result, 0); 
			
			mysql_free_result($result);
			$this->conn->disconnect();			
			
			return $meta['resposta_certa'];
		
		
		}//FIM obterRespostaID
		
		public function inserirFigurinha($id_usuario){
			
			$this->conn->Connect();	
			$sql="SELECT id  FROM albumdacopa.figurinha";
			//obter todas figurinhas que o usuário não tenha
			$result = mysql_query("SELECT a.id_figurinha FROM albumdacopa.album  as a WHERE a.id_usuario=$id_usuario ");
			$rows = mysql_fetch_assoc($result);
			mysql_free_result($result);
			if(!empty($rows)){
				
				$sql=$sql." where";
			
				foreach($rows as $row){
					
					$sql=$sql." id<>".$row["id_figurinha"];
				}
			
			}
			//pegar agora o resultado da query das figurinhas que faltam
			$result_fig_falta = mysql_query($sql);
			$rows = mysql_fetch_assoc($result_fig_falta);
			
			//random com o tamanho do vetor rows para pegar o id sorteado
			$tamanho = sizeof($rows);
			$random = rand(0,$tamanho-1);
			var_dump($rows[0]);
			//$insert="INSERT INTO albumdacopa.album  (id_usuario,id_figurinha) VALUE ($id_usuario,$rows[$random]) ";
			//$result_insert = mysql_query($insert) or die ("erro na inserção de dados".msql_erro());
			
		
		}//FIM inserirFigurinha
		
	}// FIM DA CLASSE Pergunta
	
	
	//TESTE : COM OBJETIVO DE CRIAR UM FORMULÁRIO , NO FUTURO ESSA PARTE ESTARÁ NO ALBUM.PHP
	// If que PULA o formulário em caso de acontecer o post
	if(!isset($_POST['btnSubmit'])){
		
		

		$pergunta = new Pergunta();
		// Esse ID deverá ser obtido pela sessão
		if($pergunta->possoPergunta(1)){
			
			$vetorPergunta=$pergunta->obterPergunta();
			
						
		} 
		
			
		
		
		?>
	
	
	
	<form action="pergunta.php" method="POST" > 		
	<?php echo($vetorPergunta[1]) ?><br/>
	
		<input type="hidden" name="id" value="<?php echo($vetorPergunta[0]); ?>"/>
		<input type ="radio" name="opcao" value="1"/> <?php echo($vetorPergunta[2][0]); ?><br/>
  		<input type ="radio" name="opcao" value="2"/> <?php echo($vetorPergunta[2][1]); ?><br/>
  		<input type ="radio" name="opcao" value="3"/> <?php echo($vetorPergunta[2][2]); ?> <br/>
  		<input type="submit" name="btnSubmit" value="Submiter" />
		

	</form> 
<?php 
		
		
  }?> <!-- FIM IF que testas se o form foi submetido --> 	


</body>
</html>