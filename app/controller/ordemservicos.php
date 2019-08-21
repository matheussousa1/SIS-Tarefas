<?php
	include_once(MODEL.'ordemservicos.php');
	
	class OrdemServicos{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function gerenciar(){
			
			$this->view = "ordemservicos/gerenciar";
			$this->nivel = 3;

			$model = new OrdemServicosModel;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;

			$model->listarUsuaios();
			$this->resultado[] = $model->retorno;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;
			
			$model->listarUsuaios();
			$this->resultado[] = $model->retorno;

			// adicionar membros
			$model->listarUsuaios();
			$this->resultado[] = $model->retorno;

			$model->listarUsuaios();
			$this->resultado[] = $model->retorno;

			//despesas
			$model->listarDespesas();
			$this->resultado[] = $model->retorno;
		}

		public function imprimirpdf(){

			$this->view = "";
			$this->nivel = 4;

			if( isset($GLOBALS['url'][2]) && !empty($GLOBALS['url'][2]) ){
				$id = $GLOBALS['url'][2];
				
				$model = new OrdemServicosModel;

				$model->imprimirPDF($id);
				$model->buscarAndamentoOsPrint($id);

				$this->resultado[] = $model->retorno;
				include_once (MODEL.'funcoes/converteData.php');
				include_once(VIEW.'ordemservicos/imprimirPDF.php');

				/* ================ */
				include(CONT.'MPDF57/mpdf.php');
				$mpdf=new mPDF();
				$stylesheet = file_get_contents('http://sistema.sgoes.com.br/bootstrapPDF/bootstrap.css');
				$mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML($html);
				$mpdf->Output();
				//$mpdf->Output('Carne-'.$idTitular.'.pdf', 'D');
				/* ================ */
				
			}


		}

		public function os(){

			$this->view = "ordemservicos/os";
			$this->nivel = 4;

			if( isset($GLOBALS['url'][2]) && !empty($GLOBALS['url'][2]) ){
				$id = $GLOBALS['url'][2];
				
				$model = new OrdemServicosModel;

				$model->buscarDados($id);
				$this->resultado[] = $model->retorno;
				
			}


		}
	}
?>