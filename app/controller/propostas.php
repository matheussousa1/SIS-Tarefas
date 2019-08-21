<?php
	include_once(MODEL.'propostas.php');
	
	class Propostas{
		
		public $view;
		public $nivel;
		public $resultado;
		
		public function gerenciar(){
			
			$this->view = "propostas/gerenciar";
			$this->nivel = 3;

			$model = new PropostasModel;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;

			$model->listarClientes();
			$this->resultado[] = $model->retorno;

			$model->listarContatos();
			$this->resultado[] = $model->retorno;

			$model->listarContatos();
			$this->resultado[] = $model->retorno;

			$model->listarProdutos();
			$this->resultado[] = $model->retorno;
		
		}

		public function imprimirpdf(){

			$this->view = "";
			$this->nivel = 4;

			if( isset($GLOBALS['url'][2]) && !empty($GLOBALS['url'][2]) ){
				$id = $GLOBALS['url'][2];
				
				$model = new PropostasModel;
				$model->imprimirPDF($id);

				$this->resultado = $model->retorno;
				include_once (MODEL.'funcoes/converteData.php');
				include_once(VIEW.'propostas/imprimirPDF.php');

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
	}
?>