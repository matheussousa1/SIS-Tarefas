<?php
	include_once(MODEL.'despesas.php');
	
	class Despesas{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function gerenciar(){
			
			$this->view = "despesas/gerenciar";
			$this->nivel = 1;

		}
	}
?>