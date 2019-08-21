<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class ProdutosModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($codigo, $marca, $descricao, $valorProduto, $idRef){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `produtos`(`codigo`, `marcamodelo`, `descricao`, `preco`, `dataCadastro`, `idRef`, `ativo`) VALUES ('$codigo','$marca','$descricao','$valorProduto',NOW(),'$idRef',1)");

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM produtos  WHERE ativo = 1");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM produtos WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $codigo, $marca, $descricao, $valorProduto){

			$this->retorno = mysqli_query($this->con, "UPDATE `produtos` SET `codigo`='$codigo',`marcamodelo`='$marca',`descricao`='$descricao',`preco`='$valorProduto' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `produtos` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `produtos` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		
	}

?>