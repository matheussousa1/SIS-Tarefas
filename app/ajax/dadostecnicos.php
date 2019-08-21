<?php 
include_once('../model/dadostecnicos.php');
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

	$model = new DadosTecnicosModel;

	$equipamento = $data['equipamento'];
	$nome = $data['nome'];
	$cliente = $data['cliente'];
	$serial = $data['serial'];
	$portainicio = $data['portainicio'];
	$portafim = $data['portafim'];
	$senharemoto = $data['senharemoto'];
	$usuario = $data['usuario'];
	$senha = $data['senha'];
	$responsavel = $data['responsavel'];
	$observacoes = $data['observacoes'];
	$idRef = $data['idRef'];

	$model->cadastrar($nome, $equipamento, $cliente, $serial, $portainicio, $portafim, $senharemoto, $usuario, $senha, $responsavel, $observacoes,$idRef );

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscar($con, $dados){

	$idCliente = $dados['idCliente'];

	$model = new DadosTecnicosModel;

	$model->buscar($idCliente);

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
		$data[] = $res;
	}
	$i=0;
	foreach ($data as $key) {
			// add new button
		if($data[$i]['ativo'] == 1){
			$data[$i]['button'] = '<button type="submit" id_user="'.$data[$i]['id'].'" class="btn-acoes btn btn-default btnviewdados"><i class="fa fa-eye"></i></button><button type="submit" id_user="'.$data[$i]['id'].'" class="btn-acoes btn  btn-info btneditdados" ><i class="fa fa-edit"></i></button><button type="submit" id_user="'.$data[$i]['id'].'" nome_user="'.$data[$i]['nome'].'" class="btn-acoes btn  btn-danger btndeldados" ><i class="fa fa-remove"></i></button>';
		}else{
			$data[$i]['button'] = '<button type="submit" id_user="'.$data[$i]['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button><button type="submit" id_user="'.$data[$i]['id'].'" class="btn-acoes btn  btn-info btnedit" ><i class="fa fa-edit"></i></button>
								   <button type="submit" id_user="'.$data[$i]['id'].'" nome_user="'.$data[$i]['nome'].'" class="btn-acoes btn  btn-success btnativar" ><i class="fa fa-check"></i></button>';
		}
		$i++;
	}
	$datax = array('data' => $data);
	echo json_encode($datax);
}

function buscarDados($con, $dados){

	$id = $dados['id'];

	$model = new DadosTecnicosModel;

	$model->buscarDados($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array['id']= $data['id'];
		$array['nome'] = $data['nome'];
		$array['equipamento'] = $data['idEquipamento'];
		$array['cliente'] = $data['idCliente'];
		$array['serial'] = $data['serial'];
		$array['portainicio'] = $data['portainicio'];
		$array['portafim'] = $data['portafim'];
		$array['senharemoto'] = $data['senharemoto'];
		$array['usuario'] = $data['usuario'];
		$array['senha'] = $data['senha'];
		$array['observacoes'] = $data['observacoes'];
		$array['responsavel'] = $data['idResponsavel'];
		$array['equipamentoView'] = $data['equipamentoView'];
		$array['clienteView'] = $data['clienteView'];
		$array['responsavelView'] = $data['responsavelView'];

	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new DadosTecnicosModel;

	$equipamento = $data['equipamento'];
	$nome = $data['nome'];
	$cliente = $data['cliente'];
	$serial = $data['serial'];
	$portainicio = $data['portainicio'];
	$portafim = $data['portafim'];
	$senharemoto = $data['senharemoto'];
	$usuario = $data['usuario'];
	$senha = $data['senha'];
	$responsavel = $data['responsavel'];
	$observacoes = $data['observacoes'];
	$id = $data['id'];

	$model->editar($id, $nome, $equipamento, $cliente, $serial, $portainicio, $portafim, $senharemoto, $usuario, $senha, $responsavel, $observacoes);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new DadosTecnicosModel;

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

	$model = new DadosTecnicosModel;

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