<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class ContatosModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($nome, $contato1, $contato2, $tipo, $cliente, $fornecedor, $email){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `contatos`(`nome`, `idCliente`, `idFornecedor`, `contato1`, `contato2`, `email`, `tipo`, `ativo`) VALUES ('$nome','$cliente','$fornecedor','$contato1','$contato2','$email','$tipo', 1)");

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM contatos WHERE ativo = 1 ");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM contatos WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $nome, $contato1 , $contato2, $tipo, $cliente, $fornecedor, $email){

			$this->retorno = mysqli_query($this->con, "UPDATE `contatos` SET `nome`='$nome',`idCliente`='$cliente',`idFornecedor`='$fornecedor',`contato1`='$contato1',`contato2`='$contato2',`email`='$email',`tipo`='$tipo' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `contatos` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `contatos` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		public function listarClientes(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM clientes WHERE ativo = 1 ");

			return $this->retorno;

		}

		public function listarFornecedores(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM fornecedores WHERE ativo = 1 ");

			return $this->retorno;

		}

		
	}

?>