<?php
	include_once(MODEL.'financeiro.php');
	
	class Financeiro{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function gerenciar(){
			
			$this->view = "financeiro/gerenciar";
			$this->nivel = 1;

		}

		public function contaspagar(){
			
			$this->view = "financeiro/contasPagar";
			$this->nivel = 1;

			$model = new FinanceiroModel;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;

			$model->listarFornecedores();
			$this->resultado[] = $model->retorno;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;

			$model->listarFornecedores();
			$this->resultado[] = $model->retorno;

		}

		public function contasreceber(){
			
			$this->view = "financeiro/contasReceber";
			$this->nivel = 1;

			$model = new FinanceiroModel;
			
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