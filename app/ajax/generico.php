<?php 
include_once('../model/gerentes.php');
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

	$model = new GerenteModel;

	$nome = $data['nome'];
	$idRef = $data['idRef'];

	$model->cadastrar($nome, $idRef);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscar($con){

	$model = new GerenteModel;

	$model->buscar();

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
		$data[] = $res;
	}
	$i=0;
	foreach ($data as $key) {
			// add new button
		if($data[$i]['ativo'] == 1){
			$data[$i]['button'] = '<button type="submit" id_user="'.$data[$i]['id'].'" class="btn btn-primary btnedit" ><i class="fa fa-edit"></i></button>
								   <button type="submit" id_user="'.$data[$i]['id'].'" nome_user="'.$data[$i]['nome'].'" class="btn btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		}else{
			$data[$i]['button'] = '<button type="submit" id_user="'.$data[$i]['id'].'" class="btn btn-primary btnedit" ><i class="fa fa-edit"></i></button>
								   <button type="submit" id_user="'.$data[$i]['id'].'" nome_user="'.$data[$i]['nome'].'" class="btn btn-primary btnativar" ><i class="fa fa-check"></i></button>';
		}
		$i++;
	}
	$datax = array('data' => $data);
	echo json_encode($datax);
}

function buscarDados($con, $dados){

	$id = $dados['id'];

	$model = new GerenteModel;

	$model->buscarDados($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array['id']= $data['id'];
		$array['nome']= $data['nome'];

	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new GerenteModel;

	$nome = $data['nome'];
	$id = $data['id'];

	$model->editar($id, $nome);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new GerenteModel;

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

	$model = new GerenteModel;

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