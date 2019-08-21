<?php
	include_once ("dbconnect.php");
	
	class CalendarioModel extends dbconnect{
		
		public $retorno;
		
		public function buscar($start, $end){

			$this->retorno = mysqli_query($this->con, "SELECT id, status, (SELECT nome FROM clientes WHERE id = o.cliente) as title, dataAgendamento, dataPrazo, (1) as tipo, motivo as description, horarioAgendamento, horarioPrazo FROM ordemservicos as o WHERE dataAgendamento BETWEEN '$start' and '$end' and ativo = 1 UNION SELECT id, status, tarefa as title,  dataAgendamento, dataPrazo, (2) as tipo, descricao as description, horarioAgendamento, horarioPrazo FROM tarefas WHERE dataAgendamento BETWEEN '$start' and '$end' and ativo = 1");

			return $this->retorno;

		}


	}

?>