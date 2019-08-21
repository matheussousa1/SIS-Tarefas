<?php 
include_once('../model/contatos.php');
$con = condb();

//for handle post action and perform operations 
if(isset($_GET['acao']) && $_GET['acao'] != ''){
    switch ($_GET['acao']) {
        case 'cadastrar'://for like any post
            cadastrar($con, $_GET);
        break;
        case 'buscar':
        	buscar($con, $_GET);
        break;
        case 'buscarDados':
        	buscarDados($con, $_GET);
        break;
        case 'editar':
        	editar($con, $_GET);
        break;
        case 'deletar':
        	deletar($con, $_GET);
        break;
        case 'ativar':
        	ativar($con, $_GET);
        break;
    }
}

function cadastrar($con, $data){

	$model = new ContatosModel;

	$nome = $data['nome'];
	$contato1 = $data['contato1'];
	$contato2 = $data['contato2'];
	$tipo = $data['tipo'];
	$cliente = $data['cliente'];
	$fornecedor = $data['fornecedor'];
	$email = $data['email'];

	$model->cadastrar($nome, $contato1, $contato2, $tipo, $cliente, $fornecedor, $email);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscar($con){

	$model = new ContatosModel;

	$model->buscar();

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
	
		// if($res['ativo'] == 1){
		// 	$button = '<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['contato1'].'" class="btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		// }else{
		// 	$button = '<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['contato1'].'" class="btn  btn-success btnativar" ><i class="fa fa-check"></i></button>';
		// }
		if($res['ativo'] == 1){
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn btn-info  btnedit" ><i class="fa fa-edit"></i></button>
								   <button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['contato1'].'" class="btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		}else{
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
								   <button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['contato1'].'" class="btn  btn-success btnativar" ><i class="fa fa-check"></i></button>';
		}
		switch ($res['tipo']) {
			case 1:
				$sql = mysqli_query($con, "SELECT nome FROM clientes WHERE id = '".$res['idCliente']."' ");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
			break;
			case 2:
				$sql = mysqli_query($con, "SELECT nome FROM fornecedores WHERE id = '".$res['idFornecedor']."'");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
			break;
			default:
				$vinculado = "";
			break;
		}
		$data['data'][] = array(
			'nome' => $res['nome'],
			'vinculado' => $vinculado,
			'contato1' => $res['contato1'],
			'contato2' => $res['contato2'],
			'email' => $res['email'],
			'button' => $button
		);
	}

	echo json_encode($data);
}

function buscarDados($con, $dados){

	$id = $dados['id'];

	$model = new ContatosModel;

	$model->buscarDados($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array['id']= $data['id'];
		$array['nome']= $data['nome'];
		$array['contato1']= $data['contato1'];
		$array['contato2']= $data['contato2'];
		$array['email']= $data['email'];
		$array['tipo']= $data['tipo'];
		$array['idCliente']= $data['idCliente'];
		$array['idFornecedor']= $data['idFornecedor'];
	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new ContatosModel;

	$nome = $data['nome'];
	$contato1 = $data['contato1'];
	$contato2 = $data['contato2'];
	$tipo = $data['tipo'];
	$cliente = $data['cliente'];
	$fornecedor = $data['fornecedor'];
	$email = $data['email'];
	$id = $data['id'];

	$model->editar($id, $nome, $contato1 , $contato2, $tipo, $cliente, $fornecedor, $email);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new ContatosModel;

	$id = $data['id'];

	$model->deletar($id);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function ativar($con, $data){

	$model = new ContatosModel;

	$id = $data['id'];

	$model->ativar($id);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}
?>