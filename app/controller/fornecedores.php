<?php
	include_once(MODEL.'fornecedores.php');
	
	class Fornecedores{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function gerenciar(){
			
			$this->view = "fornecedores/gerenciar";
			$this->nivel = 1;

			$model = new FornecedoresModel;

			$model->listarCidades();
			$this->resultado[] = $model->retorno;

			$model->listarEstados();
			$this->resultado[] = $model->retorno;

			$model->listarCidades();
			$this->resultado[] = $model->retorno;

			$model->listarEstados();
			$this->resultado[] = $model->retorno;
		}
	}
?>