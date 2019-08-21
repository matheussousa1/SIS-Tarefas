<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class GerenteModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($nome, $idRef){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `gerentes`(`nome`, `dataCadastro`, `idRef`, `ativo`) VALUES ('$nome', NOW(),'$idRef',1)");

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM gerentes ");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM gerentes WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $nome){

			$this->retorno = mysqli_query($this->con, "UPDATE `gerentes` SET `nome`='$nome' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `gerentes` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `gerentes` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		
	}

?>