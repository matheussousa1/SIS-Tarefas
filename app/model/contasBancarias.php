<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class ContasBancariasModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($tipo, $usuario, $fornecedor, $banco, $agencia, $conta, $tipoConta){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `contasbancarias`(`tipo`, `idFornecedor`, `idUsuario`, `banco`, `agencia`, `conta`, `tipoConta`, `ativo`) VALUES ('$tipo', '$fornecedor', '$usuario', '$banco', '$agencia', '$conta','$tipoConta', 1)");

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM contasbancarias WHERE ativo = 1 ");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM contasbancarias WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $tipo, $usuario, $fornecedor, $banco, $agencia, $conta, $tipoConta){

			$this->retorno = mysqli_query($this->con, "UPDATE `contasbancarias` SET `tipo`='$tipo',`idFornecedor`='$fornecedor',`idUsuario`='$usuario',`banco`='$banco',`agencia`='$agencia',`conta`='$conta',`tipoConta`='$tipoConta' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `contasbancarias` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `contasbancarias` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		public function listarUsuarios(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM usuarios WHERE ativo = 1 ");

			return $this->retorno;

		}

		public function listarFornecedores(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM fornecedores WHERE ativo = 1 ");

			return $this->retorno;

		}

		
	}

?>