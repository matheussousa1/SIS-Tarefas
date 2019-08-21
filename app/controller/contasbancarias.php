<?php
	include_once(MODEL.'contasBancarias.php');
	
	class ContasBancarias{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function listar(){
			
			$this->view = "contasbancarias/listar";
			$this->nivel = 1;

			$model = new ContasBancariasModel;

			$model->listarUsuarios();
			$this->resultado[] = $model->retorno;

			$model->listarFornecedores();
			$this->resultado[] = $model->retorno;

			$model->listarUsuarios();
			$this->resultado[] = $model->retorno;

			$model->listarFornecedores();
			$this->resultado[] = $model->retorno;

		}
	}
?>