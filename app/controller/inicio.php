<?php
	include_once(MODEL.'inicio.php');
	
	class Inicio{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function inicio(){
			
			$this->view = "inicio/inicio";
			$this->nivel = 3;

			$model = new InicioModel;

			$nivelUser = $_SESSION['nivelSession'];

			if($nivelUser == 3 ){
				
				$this->view = "inicio/inicioSuporte";

				$idRef = $_SESSION['idSession'];

				$model->resumoossuporte($idRef);
				$this->resultado[] = $model->retorno;

				$model->ordemservicossuporte($idRef);
				$this->resultado[] = $model->retorno;

				$model->tarefassuporte($idRef);
				$this->resultado[] = $model->retorno;

			}else{

				$model->resumoos();
				$this->resultado[] = $model->retorno;

				$model->ordemservicos();
				$this->resultado[] = $model->retorno;

				$model->tarefas();
				$this->resultado[] = $model->retorno;
			}


		}
		
	}
?>