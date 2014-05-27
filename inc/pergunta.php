<?php
	require_once('global.php');
	require_once('connection.php');

		

	Class Pergunta{
		
		private $conn;
		
		public function Pergunta(){
			$this->conn=new Conexao();
		}
		
		/**
		* 
		* @param ID do usuario logado $id_usuario
		* 
		* @return Retornará verdadeiro caso o tempo do último jogo do usuário seja maior que um dia
		*/
		public function possoPergunta($id_usuario){
			 
			$this->conn->Connect();	
			$result = mysql_query(" SELECT * FROM resposta WHERE id_usuario=$id_usuario") or die ('a busca deu o seguinte erro'.mysql_error());		
			$num_row = mysql_num_rows($result);
			
			//testar se o usuario existe na tabela pergunta, senão cadastrar  
			if($num_row==1){
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
					
					$this->conn->disconnect();
					
					return true;
										
				}
					
			 }
			 //inserir o usuario na tabela pergunta, pois até então ele não existia lá , futuro REFATORAR para outro método
			
			//colocar para inserir a data também
			else{
			 	///FALTA INSERIR A DATA
				$insert = "INSERT INTO resposta (`id_usuario`) VALUES ($id_usuario)";
			 	$result = mysql_query($insert) or die ("erro na inserção de dados".msql_erro());
			 	$this->conn->disconnect();	 	
			}
			
			
		}//FIM fazerPergunta
		
		/**
		* 
		* 
		* @return retornará uma pergunta aleatória da tabela perguntas_respostas
		*/
		//
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
		
		
		/**
		* 
		* @param Identificador da pergunta na tabela $id_pergunta
		* 
		* @return Resposta certa da pergunta que foi requerida pelo seu id
		*/
		public function obterRespostasID($id_pergunta){
			
			$this->conn->Connect();	
			$result=mysql_query("select pe.resposta_certa from albumdacopa.perguntas_respostas as pe where pe.id=$id_pergunta;") or die (mysql_error());
			$meta = mysql_fetch_assoc($result, 0); 
	
			mysql_free_result($result);
			$this->conn->disconnect();			
			
			return $meta['resposta_certa'];
		}//FIM obterRespostaID
		
		
		/**
		* 
		* @param Identificador do usuário $id_usuario
		* 
		* @return void
		*/
		public function inserirFigurinha($id_usuario){
			
			$this->conn->Connect();	
			
			//obter todas figurinhas que o usuário não tenha
			$result = mysql_query("SELECT * FROM albumdacopa.album  as a WHERE a.id_usuario=$id_usuario ");
						
			while ($row = mysql_fetch_assoc($result)){
						
				$rows[]= $row;
			}
									
			mysql_free_result($result);
			
			
			//Trazer as figurinhas existentes
			$sql="SELECT id  FROM albumdacopa.figurinha";
			if(!empty($rows)){
				
				$sql=$sql." where";
										
				foreach($rows as $row){
					//inserir os ids das figurinhas que o usuário já possui
					$sql=$sql." id<>".$row["id_figurinha"];
				}
			
			}
						
			//pegar agora o resultado da query das figurinhas que faltam
			$result_fig_falta = mysql_query($sql);
			
		
			//Preencher o vetor com as figurinhas que o usuário não tem 
			while ($row_f = mysql_fetch_assoc($result_fig_falta)){
						
				$rows_f[]=$row_f;
			}
			mysql_free_result($result_fig_falta);
					
			//random com o tamanho do vetor rows para pegar o id sorteado
			$tamanho = sizeof($rows_f);
			$random = rand(0,$tamanho-1);
			
			$id_figurinha = $rows_f[$random]['id'];
			var_dump($id_figurinha);
			
			$insert="INSERT INTO albumdacopa.album  (id_usuario,id_figurinha) VALUE ($id_usuario,$id_figurinha) ";
			$result_insert = mysql_query($insert) or die ("erro na inserção de dados".msql_erro());
			mysql_free_result($result_insert);
			$this->conn->disconnect();	
		}//FIM inserirFigurinha
		
	}// FIM DA CLASSE Pergunta
	
	
	//TESTE : COM OBJETIVO DE CRIAR UM FORMULÁRIO , NO FUTURO ESSA PARTE ESTARÁ NO ALBUM.PHP
	// If que PULA o formulário em caso de acontecer o post
?>	