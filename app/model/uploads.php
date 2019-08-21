<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class UploadsModel extends dbconnect{
		
		public $retorno;
		
		public function adicionarArquivoCliente($nome, $arquivo, $idUsuarioArquivos){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `uploadclientes`(`idCliente`, `nome`, `arquivo`, `dataCadastro`, `ativo`) VALUES ('$idUsuarioArquivos', '$nome', '$arquivo', NOW(), 1)") or die(mysqli_error($this->con));


			return $this->retorno;
		}

		public function adicionarArquivoOs($nome, $arquivo, $idUsuarioArquivos){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `uploados`(`idOs`, `nome`, `arquivo`, `dataCadastro`, `ativo`) VALUES ('$idUsuarioArquivos', '$nome', '$arquivo', NOW(), 1)") or die(mysqli_error($this->con));


			return $this->retorno;
		}

		public function adicionarArquivoFinGerenciar($nome, $arquivo, $idUsuarioArquivos){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `uploadfingerenciar`(`idGerenciar`, `nome`, `arquivo`, `dataCadastro`, `ativo`) VALUES ('$idUsuarioArquivos', '$nome', '$arquivo', NOW(), 1)") or die(mysqli_error($this->con));


			return $this->retorno;
		}

		public function adicionarArquivoConta($nome, $arquivo, $idUsuarioArquivos){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `uploadconta`(`idConta`, `nome`, `arquivo`, `dataCadastro`, `ativo`) VALUES ('$idUsuarioArquivos', '$nome', '$arquivo', NOW(), 1)") or die(mysqli_error($this->con));


			return $this->retorno;
		}
		
	}

?>