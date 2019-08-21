<?php 
include_once('../model/ordemservicos.php');
include_once('../model/funcoes/converteData.php');
$con = condb();
session_start();

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
        case 'adicionarAndamento':
        	adicionarAndamento($con, $_GET);
        break;
        case 'buscarAndamentoOs':
        	buscarAndamentoOs($con, $_GET);
        break;
        case 'buscarEditAndamentoOs':
        	buscarEditAndamentoOs($con, $_GET);
        break;
        case 'alterarAndamento':
        	alterarAndamento($con, $_GET);
        break;
        case 'checkin':
        	checkin($con, $_GET);
        break;
        case 'checkout':
        	checkout($con, $_GET);
        break;
        case 'buscarArquivos':
        	buscarArquivos($con, $_GET);
        break;
        case 'deletarArquivo':
        	deletarArquivo($con, $_GET);
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

	$model = new OrdemServicosModel;

	$cliente = $data['cliente'];
	$motivo = $data['motivo'];
	$laudo = $data['laudo'];
	$dataAgendamento = converteData($data['dataAgendamento']);
	$horarioAgendamento = $data['horarioAgendamento'];
	$dataPrazo = converteData($data['dataPrazo']);
	$horarioPrazo = $data['horarioPrazo'];
	$responsavel = $data['responsavel'];
	$valorProduto = $data['valorProduto'];
	$valorMaoObra = $data['valorMaoObra'];
	$valorAdicional = $data['valorAdicional'];
	$observacoes = $data['observacoes'];
	$status = $data['status'];

	$model->cadastrar($cliente, $motivo, $laudo, $dataAgendamento, $horarioAgendamento, $dataPrazo, $horarioPrazo, $responsavel, $valorProduto, $valorMaoObra, $valorAdicional, $observacoes, $status);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscar($con){

	$model = new OrdemServicosModel;

	$model->buscar();

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
	
		if($res['ativo'] == 1){
			if($_SESSION['nivelSession'] == 1):
				$impressoraPreta = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnprint" data-toggle="tooltip" data-placement="top" title="Imprimir O.S"><i class="fa fa-print"></i></button>';
			else:
				$impressoraPreta = '';
			endif;
			$button = 
			$impressoraPreta.'<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnprint2" data-toggle="tooltip" data-placement="top" title="Imprimir O.S com andamento"><i class="fa fa-print"></i></button>
			<button type="submit" id_user="'.$res['id'].'" status="'.$res['status'].'" class="btn-acoes btn btn-success btnplus"><i class="fa fa-plus"></i></button>
			<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnlistdespesas" ><i class="fa fa-cart-plus"></i></button>
			<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnlistarquivos"><i class="fa fa-archive"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
						<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['cliente'].'" class="btn-acoes btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		}else{
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-success btnplus"><i class="fa fa-plus"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
						<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
						<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['cliente'].'" class="btn-acoes btn btn-success btnativar" ><i class="fa fa-check"></i></button>';
		}

		// if($res['ativo'] == 1){
		// 	$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnprint"><i class="fa fa-print"></i></button>
		// 	<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-success btnplus"><i class="fa fa-plus"></i></button>
		// 	<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnlist"><i class="fa fa-list"></i></button>
		// 				<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
		// 				<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
		// 				<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['cliente'].'" class="btn-acoes btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		// }else{
		// 	$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-success btnplus"><i class="fa fa-plus"></i></button>
		// 				<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnview"><i class="fa fa-eye"></i></button>
		// 				<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button>
		// 				<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['cliente'].'" class="btn-acoes btn btn-success btnativar" ><i class="fa fa-check"></i></button>';
		// }
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
			'id' => $res['id']+1000,
			'cliente' => $res['cliente'],
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

	$model = new OrdemServicosModel;

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
		$array['cliente'] = $data['cliente'];
		$array['motivo'] = $data['motivo'];
		$array['laudo'] = $data['laudo'];
		$array['dataAgendamento'] = date("d/m/Y", strtotime($data['dataAgendamento']));
		$array['horarioAgendamento'] = $data['horarioAgendamento'];
		$array['dataPrazo'] = date("d/m/Y", strtotime($data['dataPrazo']));
		$array['horarioPrazo']= $data['horarioPrazo'];
		$array['responsavel']= $data['responsavel'];
		$array['valorProduto']= $data['valorProduto'];
		$array['valorMaoObra']= $data['valorMaoObra'];
		$array['valorAdicional']= $data['valorAdicional'];
		$array['status']= $data['status'];
		$array['statusView']= $status;
		$array['clienteView']= $data['clienteView'];
		$array['responsavelView']= $data['responsavelView'];
		$array['dataInicioView'] = ($data['inicio'] == "0000-00-00 00:00:00")? 'Não definido' : date("d/m/Y", strtotime($data['inicio']));
		$array['horarioInicioView'] = date("H:i:s", strtotime($data['inicio']));
		$array['dataTerminioView'] = ($data['terminio'] == "0000-00-00 00:00:00")? 'Não definido' : date("d/m/Y", strtotime($data['terminio']));
		$array['horarioTerminioView'] = date("H:i:s", strtotime($data['terminio']));
		$array['observacoes'] = $data['observacoes'];
	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new OrdemServicosModel;

	$cliente = $data['cliente'];
	$motivo = $data['motivo'];
	$laudo = $data['laudo'];
	$dataAgendamento = converteData($data['dataAgendamento']);
	$horarioAgendamento = $data['horarioAgendamento'];
	$dataPrazo = converteData($data['dataPrazo']);
	$horarioPrazo = $data['horarioPrazo'];
	$responsavel = $data['responsavel'];
	$valorProduto = $data['valorProduto'];
	$valorMaoObra = $data['valorMaoObra'];
	$valorAdicional = $data['valorAdicional'];
	$observacoes = $data['observacoes'];
	$status = $data['status'];
	$id = $data['id'];

	$model->editar($id, $cliente, $motivo, $laudo, $dataAgendamento, $horarioAgendamento, $dataPrazo, $horarioPrazo, $responsavel, $valorProduto, $valorMaoObra, $valorAdicional, $observacoes, $status);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new OrdemServicosModel;

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

	$model = new OrdemServicosModel;

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

function adicionarAndamento($con, $data){

	$model = new OrdemServicosModel;

	$observacoes = $data['observacoesAnda'];
	$dataAnda = converteData($data['dataAnda']);
	$porcentagem = 0;
	$statusAndamento = $data['statusAndamento'];
	$horarioAndaEntrada = $data['horarioAndaEntrada'];
	$horarioAndaSaida = $data['horarioAndaSaida'];
	$id = $data['id'];
	$idRef = $data['idRef'];

	$model->adicionarAndamento($id, $observacoes, $dataAnda, $porcentagem, $idRef, $statusAndamento, $horarioAndaEntrada, $horarioAndaSaida);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscarAndamentoOs($con, $dados){

	$id = $dados['id'];

	$model = new OrdemServicosModel;

	$model->buscarAndamentoOs($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array[] = array(
			'id' => $data['id'],
			'porcentagem' => $data['porcentagem'],
			'data' => date("d/m/Y", strtotime($data['dataAndamento'])),
			'descricao' => $data['descricao'],
			'usuario' => $data['usuario'],
			'idRef' => $data['idRef'],
		); 
	}
	echo json_encode($array);
}

function buscarEditAndamentoOs($con, $dados){

	$id = $dados['id'];

	$model = new OrdemServicosModel;

	$model->buscarEditAndamentoOs($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array = array(
			'id' => $data['id'],
			'porcentagem' => $data['porcentagem'],
			'dataAndamento' => date("d/m/Y", strtotime($data['dataAndamento'])),
			'descricao' => $data['descricao'],
			'status' => $data['status'],
			'horaEntrada' => $data['horaEntrada'],
			'horaSaida' => $data['horaSaida'],
			'idRef' => $data['idRef'],
		); 
	}
	echo json_encode($array);
}

function alterarAndamento($con, $data){

	$model = new OrdemServicosModel;

	$observacoes = $data['observacoesAnda'];
	$dataAnda = converteData($data['dataAnda']);
	$porcentagem = 0;
	$statusAndamentoEdit = $data['statusAndamentoEdit'];
	$horarioAndaEntradaEdit = $data['horarioAndaEntradaEdit'];
	$horarioAndaSaidaEdit = $data['horarioAndaSaidaEdit'];
	$id = $data['id'];
	$membroEdit = $data['membroEdit'];

	$model->alterarAndamento($id, $observacoes, $dataAnda, $porcentagem, $statusAndamentoEdit, $horarioAndaEntradaEdit, $horarioAndaSaidaEdit, $membroEdit);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function checkin($con, $data){

	$model = new OrdemServicosModel;

	$idOS = $data['idOS'];
	$idRef = $data['idRef'];

	$model->checkin($idOS, $idRef);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function checkout($con, $data){

	$model = new OrdemServicosModel;

	$idOS = $data['idOS'];
	$idRef = $data['idRef'];
	$status = $data['status'];

	$model->checkout($idOS, $idRef, $status);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

// arquivos
function buscarArquivos($con, $dados){

	$id = $dados['idCliente'];

	$model = new OrdemServicosModel;

	$model->buscarArquivos($id);

	$data = array();
	while($res = mysqli_fetch_array($model->retorno)){
		$button = '<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['nome'].'" class="btn-acoes btn  btn-danger btndelarquivo" ><i class="fa fa-remove"></i></button>';
		$data['data'][] = array(
			'id' => $res['id'],
			'nome' => $res['nome'],
			'arquivo' => '<a href="../uploads/os/'.$res['arquivo'].'" download>'.$res['arquivo'].'</a>',
			'dataCadastro' => date("d/m/Y", strtotime($res['dataCadastro'])),
			'button' => $button,
		);
	}
	echo json_encode($data);
}

function deletarArquivo($con, $data){

	$model = new OrdemServicosModel;

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

//despesas
function buscarDespesas($con, $dados){

	$id = $dados['idOrigem'];

	$model = new OrdemServicosModel;

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

	$model = new OrdemServicosModel;

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
	$model = new OrdemServicosModel;

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