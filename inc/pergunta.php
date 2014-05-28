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

			//testar se o usuario existe na tabela resposta, senão cadastrar  
			if($num_row==1){
				//checar a data da pergunta da ultima pergunta do usuario 
			 	$query = "SELECT data FROM resposta";
			 	$result=mysql_query($query) or die("Problema para trazer a data da tabela pergunta".mysql_error());
			 	$row = mysql_fetch_assoc($result);	 
				mysql_free_result($result);

				var_dump($row['data']);

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
				$dtime = new DateTime($result->my_datetime);
			 	$agora = $dtime->format("Y-m-d H:i:s");

				$insert = "INSERT INTO resposta (`id_usuario`,`id_pergunta`,`data`) VALUES ($id_usuario, 0, NOW() )";
			 	$result = mysql_query($insert) or die ("(inserir usuario na tabela pergunta) erro na inserção de dados -> ".mysql_error());
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

				$row_respostas = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $row['respostas']);

				$rows[]= array($row['id'],$row['pergunta'],unserialize($row_respostas),$row['resposta_certa']);
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
			$result=mysql_query("select pe.resposta_certa from perguntas_respostas as pe where pe.id=$id_pergunta;") or die (mysql_error());
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
			$result = mysql_query("SELECT * FROM album  WHERE id_usuario=$id_usuario ");

			while ($row = mysql_fetch_assoc($result)){

				$rows[]= $row;
			}

			mysql_free_result($result);


			//Trazer as figurinhas existentes
			$sql="SELECT id FROM figurinha";

			if(!empty($rows)){

				$length = sizeof($rows);

				$sql=$sql." where";

				for($i=0;$i<$length;$i++){
					//inserir os ids das figurinhas que o usuário já possui
					$row=$rows[$i];
					$sql=$sql." id<>".$row["id_figurinha"];

					//Verificar se uma posição depois para acrescentar
					if(!empty($rows[$i+1])){
						$sql=$sql." AND";	
					}


				}//FIM FOR
			} else {
				$sql=$sql . ";";
			}//FIM IF

			/*var_dump($rows);*/



			//pegar agora o resultado da query das figurinhas que faltam
			$result_fig_falta = mysql_query($sql);


			// se for falso não tem nenhuma figurinha
			if ( mysql_num_rows($result_fig_falta) ) {
				//Preencher o vetor com as figurinhas que o usuário não tem 
				while ($row_f = mysql_fetch_assoc($result_fig_falta)){

					$rows_f[]=$row_f;
				}
				mysql_free_result($result_fig_falta);				

				//random com o tamanho do vetor rows para pegar o id sorteado
				$tamanho = sizeof($rows_f);

				$random = rand(0,$tamanho-1);
				$id_figurinha = $rows_f[$random]['id'];

				$insert="INSERT INTO album (id_usuario,id_figurinha) VALUE ($id_usuario,$id_figurinha) ";
				$result_insert = mysql_query($insert) or die ("erro na inserção de dados ->".mysql_error());

				return $id_figurinha;
			} else {

				//se 				
				//$sql_total_figurinhas = "SELECT COUNT(*) FROM figurinhas;";
				//$tamanho = mysql_result($sql_total_figurinhas, 0);

				return false;
			}

			
			


			

			$this->conn->disconnect();	
		}//FIM inserirFigurinha

	}// FIM DA CLASSE Pergunta


	//TESTE : COM OBJETIVO DE CRIAR UM FORMULÁRIO , NO FUTURO ESSA PARTE ESTARÁ NO ALBUM.PHP
	// If que PULA o formulário em caso de acontecer o post
?>	