<?php 
include_once('../model/clientes.php');
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
        case 'buscarCidades':
        	buscarCidades($con, $_GET);
        break;
        case 'buscarArquivos':
        	buscarArquivos($con, $_GET);
        break;
        case 'deletarArquivo':
        	deletarArquivo($con, $_GET);
       	break;
       	case 'buscarObs':
        	buscarObs($con, $_GET);
       	break;
       	case 'altObs':
       		altObs($con, $_GET);
       	break;
    }
}

function cadastrar($con, $data){

	$model = new ClientesModel;

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

	$model = new ClientesModel;

	$model->buscar();

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
		
		if($res['ativo'] == 1){
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnlistdados"><i class="fa fa-list"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnlistarquivos"><i class="fa fa-archive"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnobs" ><i class="fa fa-file-text"></i></button>
						<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['nome'].'" class="btn-acoes btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		}else{
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
						<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['nome'].'" class="btn-acoes btn btn-success btnativar" ><i class="fa fa-check"></i></button>';
		}

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

	$model = new ClientesModel;

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

	$model = new ClientesModel;

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

	$model = new ClientesModel;

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

	$model = new ClientesModel;

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

function buscarCidades($con, $data){

	$model = new ClientesModel;

	$estado = $_GET['estado'];
		
	$model->listarCidades($estado);
	
	$dados = array();
	while($row = mysqli_fetch_object($model->retorno)){
		
		$dados[] = array("uf" => $row->uf, "nome" => utf8_encode($row->nome));
	}
	echo json_encode($dados);
}

// arquivos
function buscarArquivos($con, $dados){

	$id = $dados['idCliente'];

	$model = new ClientesModel;

	$model->buscarArquivos($id);

	$data = array();
	while($res = mysqli_fetch_array($model->retorno)){
		$button = '<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['nome'].'" class="btn-acoes btn  btn-danger btndelarquivo" ><i class="fa fa-remove"></i></button>';
		$data['data'][] = array(
			'id' => $res['id'],
			'nome' => $res['nome'],
			'arquivo' => '<a href="../uploads/clientes/'.$res['arquivo'].'" download>'.$res['arquivo'].'</a>',
			'dataCadastro' => date("d/m/Y", strtotime($res['dataCadastro'])),
			'button' => $button,
		);
	}
	echo json_encode($data);
}

function deletarArquivo($con, $data){

	$model = new ClientesModel;

	$id = $data['id'];

	$model->deletarArquivo($id);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscarObs($con, $dados){

	$id = $dados['id'];

	$model = new ClientesModel;

	$model->buscarObs($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array['id']= $data['id'];
		$array['observacoes'] = $data['observacoes'];
	}
	echo json_encode($array);
}

function altObs($con, $data){

	$model = new ClientesModel;

	$id = $data['id'];
	$obs = $data['obs'];

	$model->altObs($id, $obs);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}
?>