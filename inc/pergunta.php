<?php
	require_once('global.php');
	require_once('connection.php');



	Class Pergunta{

		private $conn;
		private $qde_perguntas_dia = 3;

		public function Pergunta(){
			$this->conn=new Conexao();
		}

		/**
		* 
		* @param ID do usuario logado $id_usuario
		* 
		* @return Retornará verdadeiro caso o tempo do último jogo do usuário seja maior que um dia ou se nunca tiver jogado senão returná falso
		*/
		public function possoPergunta($id_usuario){

			$this->conn->Connect();	
			$result = mysql_query("SELECT * FROM resposta WHERE id_usuario=$id_usuario") or die ('a busca deu o seguinte erro'.mysql_error());		
			$num_row = mysql_num_rows($result);

			//testar se o usuario existe na tabela resposta, senão cadastrar  
			if($num_row>=1) {

				// checar a data_ultimo da pergunta da ultima pergunta do usuario 
				// seleciona a data se o usuário respondeu hoje
			 	$query = "SELECT * FROM resposta WHERE ((DATEDIFF(NOW(),data_ultimo)*24*60*60) AND (id_usuario = {$id_usuario}));";
			 	$result=mysql_query($query) or die("Problema para trazer a data_ultimo da tabela pergunta".mysql_error()." ".var_dump($result));
			 	$row = mysql_fetch_assoc($result);	 
				mysql_free_result($result);
				
				// se a ultima participação do usuário foi de ontem ou para trás...
				if ($row) {
					//zera contagem de partcipacao
					$this->zerarParticipacao($id_usuario);
					
					// permite participacao
					return true;
				} 
				else {
					// se a participacao do usário foi hoje...

					// se o numero de participicoes for igual ou maior que o limite... 
					if ($this->obterParticipacao($id_usuario) >= $this->qde_perguntas_dia) {
						
						// não permite participacao						
						return false;	
					} 
					else {
						
						// permite participacao
						return true;
					}
				}

			 }//FIM DO if($num_row==1) 
			else {				
				$insert = "INSERT INTO resposta (`id_usuario`,data_ultimo, participacao) VALUES ( $id_usuario,0, 0  )";
			 	$result = mysql_query($insert);
			 	
			 	$this->conn->disconnect();	
			 	return true; 	
			}


		}//FIM fazerPergunta

		/**
		* 
		* 
		* @return retornará uma pergunta aleatória da tabela perguntas_respostas
		*/
		//
		public function obterPergunta ($id_usuario){

			$this->conn->Connect();	
			$sql_pergunta = "SELECT * FROM perguntas_respostas";
			$resultAsk=mysql_query($sql_pergunta);

			while ($row = mysql_fetch_assoc($resultAsk)){
				$row_respostas = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $row['respostas']);
				$rows[]= array($row['id'],$row['pergunta'],unserialize($row_respostas),$row['resposta_certa']);
			}

			mysql_free_result($resultAsk);
			$this->conn->disconnect();	

			//Pegar o tamanho do array obtido
			$tamanho= sizeof($rows) ;
			
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
			$result=mysql_query("SELECT pe.resposta_certa FROM perguntas_respostas AS pe WHERE pe.id=$id_pergunta;") or die (mysql_error());
			$meta = mysql_fetch_assoc($result, 0); 

			mysql_free_result($result);

			$this->conn->disconnect();			

			return $meta['resposta_certa'];
		}//FIM obterRespostaID


		/**
		* 
		* @param $id_usuario
		* 
		* @return Resposta certa da pergunta que foi requerida pelo seu id
		*/
		public function zerarParticipacao($id_usuario) {

			$this->conn->Connect();

			//limite de perguntas por dia
			$participacao_limite = $this->qde_perguntas_dia;
			$participacao_query = mysql_query("UPDATE resposta SET participacao = 0, data_ultimo=now() WHERE id_usuario = {$id_usuario}") or die ('erro no reset da particpacao '.mysql_error());

		}

		/**
		* 
		* @param $id_usuario, boolean para zerar o valor, boolean para permitir atualizar o valor
		* 
		* @return Resposta certa da pergunta que foi requerida pelo seu id
		*/
		public function atualizaParticipacao($id_usuario) {			

			//limite de perguntas por dia
			$participacao_limite = $this->qde_perguntas_dia;

			// pega o numero atual da participacao do usuário		
			$participacao_atual = $this->obterParticipacao($id_usuario);			
	
			// participacao acrescida de 1, e atualiza respectiva tabela
			$participacao_atual++;

			$this->conn->Connect();
			$participacao_query = mysql_query("UPDATE resposta SET participacao = {$participacao_atual} WHERE id_usuario = $id_usuario") or die ('erro na atualizacao da particpacao '.mysql_error());								
			$this->conn->disconnect();		

		}//FIM do atualizarParticipação


		public function obterParticipacao($id_usuario){
			
			$this->conn->Connect();	
			$participacao_sql = "SELECT participacao FROM resposta WHERE id_usuario=$id_usuario;";
			
			//var_dump($participacao_sql);
				
			$participacao_usuario = mysql_query($participacao_sql) or die('a busca deu o seguinte erro'.mysql_error());			
			$participacao_result = mysql_fetch_assoc($participacao_usuario);

			$participacao = (integer)$participacao_result['participacao'];	
			
			$this->conn->disconnect();
			return $participacao;
			
		}


		/**
		* 
		* Inserir nova figurinha no banco de dados com referencia do usuário
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
			}//FIM if(!empty($rows))

			/*var_dump($rows);*/

			//pegar agora o resultado da query das figurinhas que faltam
			$result_fig_falta = mysql_query($sql);

			//var_dump($result_fig_falta); die();


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

				$insert="INSERT INTO album (id_usuario,id_figurinha) VALUES ($id_usuario,$id_figurinha) ";
				$result_insert = mysql_query($insert) or die ("erro na inserção de dados ->".mysql_error());
				$this->conn->disconnect();	
				return $id_figurinha;
			} 
			else {

				return 10; //codigo de album completo
			}

				
		}//FIM inserirFigurinha
		
		
		public function atualizarResposta($id_usuario,$id_pergunta){
			$this->conn->Connect();
			
			$sql = "UPDATE resposta SET id_pergunta=$id_pergunta, data_ultimo=now() WHERE id_usuario=$id_usuario ";						
			mysql_query($sql);
			//var_dump($sql);

			// atualiza participacao de usuario
			$this->atualizaParticipacao($id_usuario);
			
			$this->conn->disconnect();		
		}

	}// FIM DA CLASSE Pergunta


	//TESTE : COM OBJETIVO DE CRIAR UM FORMULÁRIO , NO FUTURO ESSA PARTE ESTARÁ NO ALBUM.PHP
	// If que PULA o formulário em caso de acontecer o post
?>	