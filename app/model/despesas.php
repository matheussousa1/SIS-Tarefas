<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class DespesasModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($nome){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `despesas`(`nome`, `ativo`) VALUES ('$nome', 1)");

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM despesas ");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM despesas WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $nome){

			$this->retorno = mysqli_query($this->con, "UPDATE `despesas` SET `nome`='$nome' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `despesas` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `despesas` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		
	}

?>