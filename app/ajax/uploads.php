<?php 
include_once('../model/uploads.php');
$con = condb();

if(isset($_POST['acao']) && $_POST['acao'] != ''){
    switch ($_POST['acao']) {
        case 'arquivoCliente':
        	
        	$model = new UploadsModel;

            $nome = $_POST['nome'];
			$idUsuarioArquivo = $_POST['idUsuarioArquivo'];
			$arquivo = $_FILES['arquivo'];
			$ext = strtolower(strrchr($arquivo['name'],"."));
			$fotoComp  = "";
			if( $arquivo['error'] == 0 ){
				
				$fotoComp = md5(uniqid(time())).$ext;
							
				move_uploaded_file($arquivo['tmp_name'], "../../uploads/clientes/".$fotoComp);
				
			}

			$model->adicionarArquivoCliente($nome, $fotoComp, $idUsuarioArquivo);

			$res = array();
			if($model->retorno){
				$res['status'] = 200;
		    }else{
		        $res['status'] = 511;
		    }

		    echo json_encode($res);

        break;
        case 'arquivoOs':
        	
        	$model = new UploadsModel;

            $nome = $_POST['nome'];
			$idUsuarioArquivo = $_POST['idUsuarioArquivo'];
			$arquivo = $_FILES['arquivo'];
			$ext = strtolower(strrchr($arquivo['name'],"."));
			$fotoComp  = "";
			if( $arquivo['error'] == 0 ){
				
				$fotoComp = md5(uniqid(time())).$ext;
							
				move_uploaded_file($arquivo['tmp_name'], "../../uploads/os/".$fotoComp);
				
			}

			$model->adicionarArquivoOs($nome, $fotoComp, $idUsuarioArquivo);

			$res = array();
			if($model->retorno){
				$res['status'] = 200;
		    }else{
		        $res['status'] = 511;
		    }

		    echo json_encode($res);
		    
        break;
        case 'arquivoFinGerenciar':
        	
        	$model = new UploadsModel;

            $nome = $_POST['nome'];
			$idUsuarioArquivo = $_POST['idUsuarioArquivo'];
			$arquivo = $_FILES['arquivo'];
			$ext = strtolower(strrchr($arquivo['name'],"."));
			$fotoComp  = "";
			if( $arquivo['error'] == 0 ){
				
				$fotoComp = md5(uniqid(time())).$ext;
							
				move_uploaded_file($arquivo['tmp_name'], "../../uploads/fingerenciar/".$fotoComp);
				
			}

			$model->adicionarArquivoFinGerenciar($nome, $fotoComp, $idUsuarioArquivo);

			$res = array();
			if($model->retorno){
				$res['status'] = 200;
		    }else{
		        $res['status'] = 511;
		    }

		    echo json_encode($res);
		    
        break;
        case 'arquivoConta':
        	
        	$model = new UploadsModel;

            $nome = $_POST['nome'];
			$idUsuarioArquivo = $_POST['idUsuarioArquivo'];
			$arquivo = $_FILES['arquivo'];
			$ext = strtolower(strrchr($arquivo['name'],"."));
			$fotoComp  = "";
			if( $arquivo['error'] == 0 ){
				
				$fotoComp = md5(uniqid(time())).$ext;
							
				move_uploaded_file($arquivo['tmp_name'], "../../uploads/contas/".$fotoComp);
				
			}

			$model->adicionarArquivoConta($nome, $fotoComp, $idUsuarioArquivo);

			$res = array();
			if($model->retorno){
				$res['status'] = 200;
		    }else{
		        $res['status'] = 511;
		    }

		    echo json_encode($res);
		    
        break;
  	}
}

   