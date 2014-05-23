<?php 
require_once('inc/global.php');
require_once('inc/connection.php');

/**
 * Classe Quiz
 *
 */
Class Quiz {

	private $db_table_quiz = "quiz";
	private $conn = NULL;

	/**
	*	Construtor
	*
	*	cria a instacia de conexao com o banco de dados
	*	
	*/
	public function Quiz() 
	{
		$this->conn = new Conexao();
	}

	/**
	 * Atualiza acesso do usuário na tabela Quiz
	 * 
	 * @param int $user_id
	 *
	 * @return none
	 */
	public function atualizaAcesso( $user_id ) 
	{
		
		$user_id = (integer)$user_id; //converte pra inteiro

		//verifica se usuário já usou o quiz alguma vez
		if ($this->usuarioCheck( $user_id )) 
		{	
			//usuário não respondeu, adiciona o usuário na tabela		
			$sql_acesso_update = "INSERT INTO `$this->db_table_quiz` (`id_usuario`,`id_ultima_pergunta`,`erro`,`acerto`,`ultimo_acesso` ) VALUES ( {$user_id}, 0, 0, 0, now() );";
		} 
		else 
		{
			//usuário já respondeu uma pergunta, atualiza o acesso
			$sql_acesso_update = "UPDATE `$this->db_table_quiz` SET ultimo_acesso = now() WHERE id_usuario={$user_id}";
		}

		$this->conn->Connect();	
		$query_acesso = mysql_query($sql_acesso_update) or die (mysql_error());
		$this->conn->disconnect();

		/*return $reply;*/
	}

	/**
	 * Verifica se a resposta está certa
	 * 
	 * @param int $id_pergunta 
	 * @param int $id_resposta
	 *
	 * @todo acessa base de dados de perguntas
	 * @todo verifica se a resposta está certa
	 * @todo retorna true ou false
	 */
	private function checaResposta( $id_pergunta, $id_resposta ) 
	{

	}

	/**
	 * Retorna um array com pergunta e respectivas respostas 
	 * 
	 * @param int $user_id
	 *
	 * @todo verifica se usuaário está apto para acessar a pergunta (D-1)
	 * @todo 
	 * @todo sort random question from database, excluindo a ultima pergunta acessada
	 * @todo atualiza acesso
	 * @todo retorna array pergunta + respostas
	 */
	public function getPergunta( $user_id ) 
	{
		//verifica se o usuário já respondeu hoje
		$this->conn->Connect();
		$sql = "SELECT acesso FROM $this->db_table_quiz WHERE id='{$userid}'";


	}


	/**
	*	Verifica se o usuáiro já foi cadastrado
	*	
	*	@return boolean
	*/
	function usuarioCheck($id_usuario) 
	{
		$this->conn->Connect();
		$sql = "SELECT * FROM $this->db_table_quiz WHERE id_usuario='{$id_usuario}'";
		$query = mysql_query($sql) or die (mysql_error());	
		$num_row = mysql_num_rows($query);
		$this->conn->disconnect();	
		return ( $num_row >=1 ) ? false : true;
	}	

	/**
	*	Verifica se o usuáiro já foi cadastrado
	*	
	*	@return boolean
	*/
	function getData($id_usuario) 
	{
		$this->conn->Connect();
		$sql = "SELECT * FROM $this->db_table_quiz WHERE id_usuario='{$id_usuario}'";
		$query = mysql_query($sql) or die (mysql_error());	
		$num_row = mysql_num_rows($query);
		$this->conn->disconnect();	
		return ( $num_row >=1 ) ? false : true;
	}	

}

?>