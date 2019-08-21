<?php 
include_once('../model/tarefas.php');
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
        case 'buscarDespesas':
        	buscarDespesas($con, $_GET);
        break;
        case 'deletarDespesa':
        	deletarDespesa($con, $_GET);
       	break;
    }
}

if(isset($_POST['acao']) && $_POST['acao'] != ''){
	switch ($_POST['acao']) {
		case 'addDespesa':
        	addDespesa($con, $_POST);
       	break;	
	}
}

function cadastrar($con, $data){

	$model = new TarefasModel;

	$tarefa = $data['tarefa'];
	$dataAgendamento = converteData($data['dataAgendamento']);
	$horarioAgendamento = $data['horarioAgendamento'];
	$dataPrazo = converteData($data['dataPrazo']);
	$horarioPrazo = $data['horarioPrazo'];
	$responsavel = $data['responsavel'];
	$contato1 = $data['contato1'];
	$status = $data['status'];
	$situacao = $data['situacao'];
	$descricao = $data['descricao'];

	$model->cadastrar($tarefa, $dataAgendamento, $horarioAgendamento, $dataPrazo, $horarioPrazo, $responsavel, $contato1, $status, $situacao, $descricao);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscar($con, $data){

	$model = new TarefasModel;

	$tipoUser = $data['tipoUser'];
	$idRef = $data['idRef'];

	if($tipoUser == 1){
		$model->buscar();
	}else{
		$model->buscarTarefaUnitaria($idRef);
	}

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
	
		if($res['ativo'] == 1){
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnprint"><i class="fa fa-print"></i></button>
			<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnlistdespesas" ><i class="fa fa-cart-plus"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info  btnedit" ><i class="fa fa-edit"></i></button>
						<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['tarefa'].'" class="btn-acoes btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		}else{
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
								   <button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['tarefa'].'" class="btn-acoes btn  btn-success btnativar" ><i class="fa fa-check"></i></button>';
		}

		switch ($res['status']) {
			case 1:
				$status = '<span class="label label-warning">Aberto</span>';
			break;
			case 2:
				$status = '<span class="label label-danger">Iniciado</span>';
			break;
			case 3:
				$status = '<span class="label label-info">Em andamento</span>';
			break;
			case 4:
				$status = '<span class="label label-info">Em conclusão</span>';
			break;
			case 5:
				$status = '<span class="label label-default">Finalizado</span>';
			break;
			case 6:
				$status = '<span class="label label-primary">Cancelado</span>';
			break;
			case 7:
				$status = '<span class="label label-warning">Pendente</span>';
			break;
		}

		$data['data'][] = array(
			'id' => $res['id']+100,
			'tarefa' => $res['tarefa'],
			'agendamento' => date("d/m/Y", strtotime($res['dataAgendamento']))." - ".$res['horarioAgendamento'],
			'prazo' => date("d/m/Y", strtotime($res['dataPrazo']))." - ".$res['horarioPrazo'],
			'responsavel' => $res['responsavel'],
			'status' => $status,
			'ativo' => $res['ativo'],
			'button' => $button,
		);
	}
	
	echo json_encode($data);
}

function buscarDados($con, $dados){

	$id = $dados['id'];

	$model = new TarefasModel;

	$model->buscarDados($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		switch ($data['status']) {
			case 1:
				$status = '<span class="label label-default">Aberto</span>';
			break;
			case 2:
				$status = '<span class="label label-danger">Iniciado</span>';
			break;
			case 3:
				$status = '<span class="label label-warning">Em andamento</span>';
			break;
			case 4:
				$status = '<span class="label label-warning">Em conclusão</span>';
			break;
			case 5:
				$status = '<span class="label label-success">Finalizado</span>';
			break;
			case 6:
				$status = '<span class="label label-primary">Cancelado</span>';
			break;
			case 7:
				$status = '<span class="label label-warning">Pendente</span>';
			break;
		}

		$array['id'] = $data['id'];
		$array['tarefa'] = $data['tarefa'];
		$array['dataAgendamento'] = date("d/m/Y", strtotime($data['dataAgendamento']));
		$array['horarioAgendamento'] = $data['horarioAgendamento'];
		$array['dataPrazo'] = date("d/m/Y", strtotime($data['dataPrazo']));
		$array['horarioPrazo']= $data['horarioPrazo'];
		$array['responsavel']= $data['responsavel'];
		$array['responsavelView']= $data['responsavelView'];
		$array['contato1']= $data['contato1'];
		$array['status']= $data['status'];
		$array['statusView']= $status;
		$array['descricao']= $data['descricao'];
		$array['situacao']= $data['situacao'];
		$array['dataInicioView'] = ($data['inicio'] == "0000-00-00 00:00:00")? 'Não definido' : date("d/m/Y", strtotime($data['inicio']));
		$array['horarioInicioView'] = date("H:i:s", strtotime($data['inicio']));
		$array['dataTerminioView'] = ($data['terminio'] == "0000-00-00 00:00:00")? 'Não definido' : date("d/m/Y", strtotime($data['terminio']));
		$array['horarioTerminioView'] = date("H:i:s", strtotime($data['terminio']));
		$array['contatoView'] = $data['contatoView'];
		$array['nomeContatoView'] = $data['nomeContatoView'];

	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new TarefasModel;

	$tarefa = $data['tarefa'];
	$dataAgendamento = converteData($data['dataAgendamento']);
	$horarioAgendamento = $data['horarioAgendamento'];
	$dataPrazo = converteData($data['dataPrazo']);
	$horarioPrazo = $data['horarioPrazo'];
	$responsavel = $data['responsavel'];
	$contato1 = $data['contato1'];
	$status = $data['status'];
	$descricao = $data['descricao'];
	$situacao = $data['situacao'];
	$id = $data['id'];

	$model->editar($id, $tarefa, $dataAgendamento, $horarioAgendamento, $dataPrazo, $horarioPrazo, $responsavel, $contato1, $status, $descricao, $situacao);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new TarefasModel;

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

	$model = new TarefasModel;

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

//despesas
function buscarDespesas($con, $dados){

	$id = $dados['idOrigem'];

	$model = new TarefasModel;

	$model->buscarDespesas($id);

	$data = array();
	while($res = mysqli_fetch_array($model->retorno)){
		$button = '<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['nome'].'" class="btn-acoes btn  btn-danger btndeldespesa" ><i class="fa fa-remove"></i></button>';
		$data['data'][] = array(
			'id' => $res['id'],
			'despesa' => $res['nome'],
			'valor' => $res['valor'],
			'descricao' => $res['descricao'],
			'arquivo' => '<a href="../uploads/despesas/'.$res['anexo'].'" download>'.$res['anexo'].'</a>',
			'dataCadastro' => date("d/m/Y", strtotime($res['dataCadastro'])),
			'button' => $button,
		);
	}
	echo json_encode($data);
}

function deletarDespesa($con, $data){

	$model = new TarefasModel;

	$id = $data['id'];

	$model->deletarDespesa($id);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function addDespesa($con, $data){
	$model = new TarefasModel;

    $despesa = $_POST['despesaadd'];
    $descricao = $_POST['descrisaoDespesa'];
    $valor = $_POST['valorDespesa'];
	$idUsuarioDespesa = $_POST['idUsuarioDespesa'];
	$arquivo = $_FILES['arquivoDespesa'];
	$ext = strtolower(strrchr($arquivo['name'],"."));
	$fotoComp  = "";
	if( $arquivo['error'] == 0 ){
		
		$fotoComp = md5(uniqid(time())).$ext;
					
		move_uploaded_file($arquivo['tmp_name'], "../../uploads/despesas/".$fotoComp);
		
	}

	$model->adicionarDespesa($despesa,$descricao,$valor, $fotoComp, $idUsuarioDespesa);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}
?>