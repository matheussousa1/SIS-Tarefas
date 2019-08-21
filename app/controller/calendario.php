<?php
	include_once(MODEL.'calendario.php');
	
	class Calendario{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function gerenciar(){
			
			$this->view = "calendario/gerenciar";
			$this->nivel = 3;

		}
	}
?>