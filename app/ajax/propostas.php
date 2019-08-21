<?php 
include_once('../model/propostas.php');
include_once('../model/funcoes/converteData.php');
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

	$model = new PropostasModel;

	$cliente = $data['cliente'];
	$servico = $data['servico'];
	$proposta = $data['proposta'];
	$observacoes = $data['observacoes'];
	$garantiaEquipamento = $data['garantiaEquipamento'];
	$garantiaMaoObra = $data['garantiaMaoObra'];
	$prazoEntrega = $data['prazoEntrega'];
	$valorMaterial = $data['valorMaterial'];
	$valorMaoObra = $data['valorMaoObra'];
	$valorAdicional = $data['valorAdicional'];
	$entrada = $data['entrada'];
	$valorEntrada = $data['valorEntrada'];
	$saldo = $data['saldo'];
	$status = $data['status'];
	$idRef = $data['idRef'];
	$tipo = $data['tipo'];
	$contato = $data['contato'];

	$model->cadastrar($cliente, $servico, $proposta, $observacoes, $garantiaEquipamento, $garantiaMaoObra, $prazoEntrega, $valorMaterial, $valorMaoObra, $valorAdicional, $entrada, $valorEntrada, $saldo, $status, $idRef, $tipo, $contato);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscar($con, $data){

	$model = new PropostasModel;
	
	$nivel = $data['nivel'];
	$idRef = $data['idRef'];

	$model->buscar($nivel, $idRef);

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
	
		if($res['ativo'] == 1){
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnprint"><i class="fa fa-print"></i></button>
			<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnaddproduto"><i class="fa fa-cart-plus"></i></button>
			<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
						<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['cliente'].'" class="btn-acoes btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		}else{
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
						<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['cliente'].'" class="btn-acoes btn btn-success btnativar" ><i class="fa fa-check"></i></button>';
		}
		switch ($res['status']) {
			case 1:
				$status = '<span class="label label-default">Em criação</span>';
			break;
			case 2:
				$status = '<span class="label label-danger">Enviada</span>';
			break;
			case 3:
				$status = '<span class="label label-success">Aprovada</span>';
			break;
			case 4:
				$status = '<span class="label label-warning">Reprovada</span>';
			break;
			default:
				$status = '';
			break;
		}
		switch ($res['tipo']) {
			case 1:
				$sql = mysqli_query($con, "SELECT nome FROM clientes WHERE id = '".$res['cliente']."' ");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
			break;
			case 2:
				$sql = mysqli_query($con, "SELECT nome FROM contatos WHERE id = '".$res['contato']."'");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
			break;
			default:
				$vinculado = "";
			break;
		}

		$data['data'][] = array(
			'id' => $res['id']+5000,
			'cliente' => $vinculado,
			'servico' => $res['servico'],
			'status' => $status,
			'ativo' => $res['ativo'],
			'button' => $button,
		);
	}
	
	echo json_encode($data);
}

function buscarDados($con, $dados){

	$id = $dados['id'];

	$model = new PropostasModel;

	$model->buscarDados($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		switch ($data['status']) {
			case 1:
				$status = '<span class="label label-default">Em criação</span>';
			break;
			case 2:
				$status = '<span class="label label-danger">Enviada</span>';
			break;
			case 3:
				$status = '<span class="label label-success">Aprovada</span>';
			break;
			case 4:
				$status = '<span class="label label-warning">Reprovada</span>';
			break;
			default:
				$status = '';
			break;
		}
		switch ($data['tipo']) {
			case 1:
				$sql = mysqli_query($con, "SELECT nome FROM clientes WHERE id = '".$data['cliente']."' ");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
			break;
			case 2:
				$sql = mysqli_query($con, "SELECT nome FROM contatos WHERE id = '".$data['contato']."'");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
			break;
			default:
				$vinculado = "";
			break;
		}

		$array['id'] = $data['id'];
		$array['cliente'] = $data['cliente'];
		$array['servico'] = $data['servico'];
		$array['proposta'] = $data['proposta'];
		$array['observacoes'] = $data['observacoes'];
		$array['garantiaEquipamento'] = $data['garantiaEquipamento'];
		$array['garantiaMaoObra'] = $data['garantiaMaoObra'];
		$array['prazoEntrega'] = $data['prazoEntrega'];
		$array['valorMaterial'] = $data['valorMaterial'];
		$array['valorMaoObra'] = $data['valorMaoObra'];
		$array['valorAdicional'] = $data['valorAdicional'];
		$array['entrada'] = $data['entrada'];
		$array['valorEntrada'] = $data['valorEntrada'];
		$array['saldo'] = $data['saldo'];
		$array['status'] = $data['status'];
		$array['statusView'] = $status;
		$array['clienteView'] = $vinculado;
		$array['tipo'] = $data['tipo'];
		$array['contato'] = $data['contato'];
	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new PropostasModel;

	$cliente = $data['cliente'];
	$servico = $data['servico'];
	$proposta = $data['proposta'];
	$observacoes = $data['observacoes'];
	$garantiaEquipamento = $data['garantiaEquipamento'];
	$garantiaMaoObra = $data['garantiaMaoObra'];
	$prazoEntrega = $data['prazoEntrega'];
	$valorMaterial = $data['valorMaterial'];
	$valorMaoObra = $data['valorMaoObra'];
	$valorAdicional = $data['valorAdicional'];
	$entrada = $data['entrada'];
	$valorEntrada = $data['valorEntrada'];
	$saldo = $data['saldo'];
	$status = $data['status'];
	$tipo = $data['tipo'];
	$contato = $data['contato'];
	$id = $data['id'];

	$model->editar($id, $cliente, $servico, $proposta, $observacoes, $garantiaEquipamento, $garantiaMaoObra, $prazoEntrega, $valorMaterial, $valorMaoObra, $valorAdicional, $entrada, $valorEntrada, $saldo, $status, $tipo, $contato);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new PropostasModel;

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

	$model = new PropostasModel;

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