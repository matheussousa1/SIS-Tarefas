<?php
	include_once(MODEL.'bandeiracartao.php');
	
	class BandeiraCartao{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function bandeiracartao(){
			
			$this->view = "bandeiracartao/bandeiracartao";
			$this->nivel = 1;

		}
	}
?>