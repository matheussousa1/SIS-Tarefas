<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class LoginModel extends dbconnect{

		public $retorno;

		public function verificaLogado($user, $senha){

			$sql = "SELECT senha FROM usuarios WHERE email = '$user' and ativo = 1";
			$this->retorno = mysqli_query($this->con, $sql);
	        
			if(mysqli_num_rows($this->retorno) != 0){
				$row = mysqli_fetch_object($this->retorno);
				if($row->senha == $senha){
					return TRUE;
				}else{
					session_destroy();
					session_unset();
					header("Location: ".SITE."login/erro");
				}
			}else{
				session_destroy();
				session_unset();
				header("Location: ".SITE."login/erro");
			}
			
		}
		
		
		public function logar($idUser, $senha) {

	        $sql = "SELECT id,nome,email,senha,nivel FROM usuarios WHERE email = '$idUser'";
	        $this->retorno = mysqli_query($this->con, $sql);
           
	        $senha = criptaSenha($senha);
	        
			if(mysqli_num_rows($this->retorno) != 0){
				$row = mysqli_fetch_object($this->retorno);
				if($row->senha == $senha){

					$_SESSION['idSession'] = $row->id;
			        $_SESSION['nomeSession'] = $row->nome;
			        $_SESSION['userSession'] = $row->email;
			        $_SESSION['senhaSession'] = $row->senha;
			        $_SESSION['nivelSession'] = $row->nivel;
					
				}else
					header("Location: ".SITE."login/erro");
			 }else
			 	header("Location: ".SITE."login/erro");

			header("Location: ".SITE."inicio/inicio");
			
		}
		
	}

?>