<?php
	include_once(MODEL.'contatos.php');
	
	class Contatos{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function listar(){
			
			$this->view = "contatos/listar";
			$this->nivel = 3;

			$model = new ContatosModel;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;

			$model->listarFornecedores();
			$this->resultado[] = $model->retorno;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;

			$model->listarFornecedores();
			$this->resultado[] = $model->retorno;

		}
	}
?>