<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class InicioModel extends dbconnect{
		
		public $retorno;
		
		public function resumoos(){

			// os criadas
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as osCriadas FROM `ordemservicos`");

			// os abertas / andamento
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as osAbertasAndamento FROM `ordemservicos` WHERE status IN (1,2,3,4) and ativo = 1");

			// os concluids
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as osConcluidas FROM `ordemservicos` WHERE status = 5 and ativo = 1");

			// os Canceladas
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as osCanceladas FROM `ordemservicos` WHERE status = 6 and ativo = 1");

			// os criadas
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as tarefasCriadas FROM `tarefas`");

			// tarefas abertas / andamento
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as tarefasAbertasAndamento FROM `tarefas` WHERE status IN (1,2,3,4) and ativo = 1");

			// tarefas concluids
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as tarefasConcluidas FROM `tarefas` WHERE status = 5 and ativo = 1");

			// tarefas Canceladas
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as tarefasCanceladas FROM `tarefas` WHERE status = 6 and ativo = 1");

			return $this->retorno;

		}

		public function ordemservicos(){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = o.responsavel) as responsavel, (SELECT nome FROM clientes WHERE id = o.cliente) as cliente FROM `ordemservicos` as o WHERE ativo = 1");

			return $this->retorno;

		}

		public function tarefas(){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = o.responsavel) as responsavel FROM `tarefas` as o WHERE ativo = 1");

			return $this->retorno;

		}

		// suporte

		public function resumoossuporte($idRef){

			// os criadas
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as osCriadas FROM `ordemservicos` WHERE responsavel = $idRef");

			// os abertas / andamento
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as osAbertasAndamento FROM `ordemservicos` WHERE status IN (1,2,3,4) and ativo = 1 and responsavel = $idRef");

			// os concluids
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as osConcluidas FROM `ordemservicos` WHERE status = 5 and ativo = 1 and responsavel = $idRef");

			// os Canceladas
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as osCanceladas FROM `ordemservicos` WHERE status = 6 and ativo = 1  and responsavel = $idRef");

			// os criadas
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as tarefasCriadas FROM `tarefas` WHERE responsavel = $idRef");

			// tarefas abertas / andamento
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as tarefasAbertasAndamento FROM `tarefas` WHERE status IN (1,2,3,4) and ativo = 1 and responsavel = $idRef");

			// tarefas concluids
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as tarefasConcluidas FROM `tarefas` WHERE status = 5 and ativo = 1 and responsavel = $idRef");

			// tarefas Canceladas
			$this->retorno[] = mysqli_query($this->con, "SELECT COUNT(*) as tarefasCanceladas FROM `tarefas` WHERE status = 6 and ativo = 1 and responsavel = $idRef");

			return $this->retorno;

		}

		public function ordemservicossuporte($idRef){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = o.responsavel) as responsavel, (SELECT nome FROM clientes WHERE id = o.cliente) as cliente FROM `ordemservicos` as o WHERE ativo = 1");

			return $this->retorno;

		}

		public function tarefassuporte($idRef){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = o.responsavel) as responsavel FROM `tarefas` as o WHERE ativo = 1 and responsavel = $idRef");

			return $this->retorno;

		}

	}

?>