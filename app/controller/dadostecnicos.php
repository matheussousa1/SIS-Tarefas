<?php
	include_once(MODEL.'dadostecnicos.php');
	
	class DadosTecnicos{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function gerenciar(){
			
			$this->view = "dadostecnicos/gerenciar";
			$this->nivel = 1;

			$model = new DadosTecnicosModel;

			$model->listarProdutos();
			$this->resultado[] = $model->retorno;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;

			$model->listarUsuaios();
			$this->resultado[] = $model->retorno;

			$model->listarProdutos();
			$this->resultado[] = $model->retorno;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;

			$model->listarUsuaios();
			$this->resultado[] = $model->retorno;

		}
	}
?>