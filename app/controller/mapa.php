<?php
	include_once(MODEL.'mapa.php');
	
	class Mapa{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function inicio(){
			
			$this->view = "mapa/inicio";
			$this->nivel = 1;

		}
	}
?>