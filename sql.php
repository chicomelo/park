<?php
//cria��o da classe
	class Sql extends PDO{ //a CLASSE EXTENDE DA CLASSE PDO. Tudo que o PDO j� faz, essa classe j� sabe fazer. Tem acesso as info
		private $conn;  //definindo a vari�vel de conex�o como private.

		//conex�o autom�tica com o banco de dados ap�s a instacia��o (new)
		public function __construct(){
			//conexao local
			$this->conn = new PDO("mysql:host=localhost;dbname=estacionamento", "root", "vertrigo");
		}

		private function setParams($statement, $parameters = array()){
			foreach ($parameters as $key => $value){
				$this->setParam($statement, $key, $value);
			}
		}

		private function setParam($statement, $key, $value){
			$statement->bindParam($key, $value);
		}

		//execu��o de comandos
		public function query($rawQuery, $params = array()){
			$stmt = $this->conn->prepare($rawQuery);
			$this->setParams($stmt, $params);
			$stmt->execute();
			return $stmt;
		}

		public function select($rawQuery, $params = array()){   //:array
			$stmt = $this->query($rawQuery, $params);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}
?>
