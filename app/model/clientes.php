<?php
	include_once ("dbconnect.php");
	
	class ClientesModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($nome, $razao, $cpfcnpj, $contato1, $contato2, $cep, $logadouro, $numero, $bairro, $cidade, $estado, $complemento, $idRef ){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `clientes`(`nome`, `razao`, `cpfcnpj`, `logadouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `contato1`, `contato2`, `dataCadastro`, `ativo`, `idRef`) VALUES ('$nome', '$razao','$cpfcnpj', '$logadouro','$numero', '$complemento', '$bairro','$cidade', '$estado','$cep','$contato1','$contato2',NOW(),1,'$idRef')");

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM clientes  WHERE ativo = 1");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM clientes WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $nome, $razao, $cpfcnpj, $contato1, $contato2, $cep, $logadouro, $numero, $bairro, $cidade, $estado, $complemento){

			$this->retorno = mysqli_query($this->con, "UPDATE `clientes` SET `nome`= '$nome',`razao`='$razao',`cpfcnpj`='$cpfcnpj',`logadouro`='$logadouro',`numero`='$numero',`complemento`='$complemento',`bairro`='$bairro',`cidade`='$cidade',`estado`='$estado',`cep`='$cep',`contato1`='$contato1',`contato2`='$contato2' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `clientes` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `clientes` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		public function listarEstados(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `cidades` group by uf");

			return $this->retorno;

		}

		public function listarCidades($estado){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `cidades` WHERE uf = '$estado' ");

			return $this->retorno;

		}
		
		public function listarClientes(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `clientes` WHERE ativo = 1");

			return $this->retorno;

		}

		public function listarProdutos(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `produtos` WHERE ativo = 1");

			return $this->retorno;

		}

		public function listarUsuaios(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `usuarios` WHERE ativo = 1");

			return $this->retorno;

		}

		// arquivos
		public function buscarArquivos($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `uploadclientes` WHERE idCliente = $id and ativo = 1");

			return $this->retorno;

		}

		public function deletarArquivo($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `uploadclientes` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function buscarObs($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `clientes` WHERE id = $id");

			return $this->retorno;

		}

		public function altObs($id, $obs){

			$this->retorno = mysqli_query($this->con, "UPDATE `clientes` SET `observacoes`= '$obs' WHERE id = $id");

			return $this->retorno;

		}

	}

?>