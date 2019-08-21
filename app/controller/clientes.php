<?php
	include_once(MODEL.'clientes.php');
	
	class Clientes{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function gerenciar(){
			
			$this->view = "clientes/gerenciar";
			$this->nivel = 3;

			$model = new ClientesModel;

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