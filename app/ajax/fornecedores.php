<?php 
include_once('../model/fornecedores.php');
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
        case 'buscarContasBancarias':
        	buscarContasBancarias($con, $_GET);
        break;
    }
}

function cadastrar($con, $data){

	$model = new FornecedoresModel;

	$nome = $data['nome'];
	$razao = $data['razao'];
	$cpfcnpj = $data['cpfcnpj'];
	$contato1 = $data['contato1'];
	$contato2 = $data['contato2'];
	$cep = $data['cep'];
	$logadouro = $data['logadouro'];
	$numero = $data['numero'];
	$bairro = $data['bairro'];
	$cidade = $data['cidade'];
	$estado = $data['estado'];
	$complemento = $data['complemento'];
	$idRef = $data['idRef'];

	$model->cadastrar($nome, $razao, $cpfcnpj, $contato1, $contato2, $cep, $logadouro, $numero, $bairro, $cidade, $estado, $complemento, $idRef );

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscar($con){

	$model = new FornecedoresModel;

	$model->buscar();

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
	

		$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default  btnviewbank" ><i class="fa fa-money"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info  btnedit" ><i class="fa fa-edit"></i></button>
						<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['nome'].'" class="btn-acoes btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		

		$data['data'][] = array(
			'id' => $res['id'],
			'nome' => $res['nome'],
			'endereco' => $res['logadouro'].", ".$res['numero']." - ".$res['bairro'].", ".$res['cidade']." / ".$res['estado'],
			'button' => $button,
		);
	}
	
	echo json_encode($data);
}

function buscarDados($con, $dados){

	$id = $dados['id'];

	$model = new FornecedoresModel;

	$model->buscarDados($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array['id']= $data['id'];
		$array['nome'] = $data['nome'];
		$array['razao'] = $data['razao'];
		$array['cpfcnpj'] = $data['cpfcnpj'];
		$array['contato1'] = $data['contato1'];
		$array['contato2'] = $data['contato2'];
		$array['cep'] = $data['cep'];
		$array['logadouro'] = $data['logadouro'];
		$array['numero'] = $data['numero'];
		$array['bairro'] = $data['bairro'];
		$array['cidade'] = $data['cidade'];
		$array['estado'] = $data['estado'];
		$array['complemento'] = $data['complemento'];

	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new FornecedoresModel;

	$nome = $data['nome'];
	$razao = $data['razao'];
	$cpfcnpj = $data['cpfcnpj'];
	$contato1 = $data['contato1'];
	$contato2 = $data['contato2'];
	$cep = $data['cep'];
	$logadouro = $data['logadouro'];
	$numero = $data['numero'];
	$bairro = $data['bairro'];
	$cidade = $data['cidade'];
	$estado = $data['estado'];
	$complemento = $data['complemento'];
	$id = $data['id'];

	$model->editar($id, $nome, $razao, $cpfcnpj, $contato1, $contato2, $cep, $logadouro, $numero, $bairro, $cidade, $estado, $complemento);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new FornecedoresModel;

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

	$model = new FornecedoresModel;

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

function buscarContasBancarias($con, $dados){

	$id = $dados['id'];

	$model = new FornecedoresModel;

	$model->buscarContasBancarias($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		if ($data['tipoConta'] == 1) {
			$tipoConta = "Corrente";
		}else{
			$tipoConta = "Poupança";
		}
		$array[] = array(
			'banco' => $data['banco'],
			'agencia' => $data['agencia'],
			'conta' => $data['conta'],
			'tipoConta' => $tipoConta,
		); 
	}
	echo json_encode($array);
}

?>