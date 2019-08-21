<?php
	include_once ("dbconnect.php");
	
	class FornecedoresModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($nome, $razao, $cpfcnpj, $contato1, $contato2, $cep, $logadouro, $numero, $bairro, $cidade, $estado, $complemento, $idRef ){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `fornecedores`(`nome`, `razao`, `cpfcnpj`, `logadouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `contato1`, `contato2`, `dataCadastro`, `ativo`, `idRef`) VALUES ('$nome', '$razao','$cpfcnpj', '$logadouro','$numero', '$complemento', '$bairro','$cidade', '$estado','$cep','$contato1','$contato2',NOW(),1,'$idRef')");

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM fornecedores  WHERE ativo = 1");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM fornecedores WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $nome, $razao, $cpfcnpj, $contato1, $contato2, $cep, $logadouro, $numero, $bairro, $cidade, $estado, $complemento){

			$this->retorno = mysqli_query($this->con, "UPDATE `fornecedores` SET `nome`= '$nome',`razao`='$razao',`cpfcnpj`='$cpfcnpj',`logadouro`='$logadouro',`numero`='$numero',`complemento`='$complemento',`bairro`='$bairro',`cidade`='$cidade',`estado`='$estado',`cep`='$cep',`contato1`='$contato1',`contato2`='$contato2' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `fornecedores` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `fornecedores` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		public function listarCidades(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `cidades`");

			return $this->retorno;

		}

		public function listarEstados(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `cidades` group by uf");

			return $this->retorno;

		}

		public function buscarContasBancarias($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `contasbancarias` WHERE idFornecedor = $id");

			return $this->retorno;

		}

		
	}

?>