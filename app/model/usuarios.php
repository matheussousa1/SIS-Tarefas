<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class UsuariosModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($nome, $email, $contato1, $contato2, $senha, $cargo, $nivel){

			$senha = criptaSenha($senha);

			$this->retorno = mysqli_query($this->con, "INSERT INTO `usuarios`(`nome`, `senha`, `nivel`, `email`, `contato1`, `contato2`, `cargo`, `ativo`) VALUES ('$nome', '$senha', '$nivel', '$email', '$contato1', '$contato2','$cargo',1)") or die(mysqli_error($this->con));

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM usuarios ");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM usuarios WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $nome, $email, $contato1, $contato2, $cargo, $nivel){

			$this->retorno = mysqli_query($this->con, "UPDATE `usuarios` SET `nome`='$nome',`nivel`='$nivel',`email`='$email',`contato1`='$contato1',`contato2`='$contato2',`cargo`='$cargo' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `usuarios` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `usuarios` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		public function buscarContasBancarias($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `contasbancarias` WHERE idUsuario = $id");

			return $this->retorno;

		}

		
	}

?>