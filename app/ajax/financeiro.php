<?php 
include_once('../model/financeiro.php');
include_once('../model/funcoes/converteData.php');
$con = condb();

//for handle post action and perform operations 
if(isset($_GET['acao']) && $_GET['acao'] != ''){
    switch ($_GET['acao']) {
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
        case 'buscarContasPagar':
        	buscarContasPagar($con, $_GET);
        break;
        case 'cadastrarContaPagar':
        	cadastrarContaPagar($con, $_GET);
        break;
        case 'buscarDadosContaPagar':
        	buscarDadosContaPagar($con, $_GET);
        break;
        case 'editarContaPagar':
        	editarContaPagar($con, $_GET);
        break;
        case 'buscarContasReceber':
        	buscarContasReceber($con, $_GET);
        break;
        case 'cadastrarContaReceber':
        	cadastrarContaReceber($con, $_GET);
        break;
        case 'buscarDadosContaReceber':
        	buscarDadosContaReceber($con, $_GET);
        break;
        case 'editarContaReceber':
        	editarContaReceber($con, $_GET);
        break;
        case 'buscarArquivosGerenciar':
        	buscarArquivosGerenciar($con, $_GET);
        break;
        case 'deletarArquivoGerenciar':
        	deletarArquivoGerenciar($con, $_GET);
       	break;
       	case 'buscarArquivosConta':
        	buscarArquivosConta($con, $_GET);
        break;
        case 'deletarArquivoConta':
        	deletarArquivoConta($con, $_GET);
       	break;
    }
}

function buscar($con, $dados){

	$data1 = converteData($dados['data1']);
	$data2 = converteData($dados['data2']);
	$status = $dados['status'];

	$model = new FinanceiroModel;

	$model->buscar($data1, $data2, $status);

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
	
		if($res['ativo'] == 1){
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button><button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnlistarquivos"><i class="fa fa-archive"></i></button>';
		}

		switch ($res['statusPagamento']) {
			case 0:
				$status = '<span class="label label-default">Aberto</span>';
			break;
			case 1:
				$status = '<span class="label label-danger">Pago</span>';
			break;
		}

		switch ($res['emitirNota']) {
			case 0:
				$emitirNota = '<span class="label label-default">Não</span>';
			break;
			case 1:
				$emitirNota = '<span class="label label-info">Sim</span>';
			break;
			case 2:
				$emitirNota = '<span class="label label-success">Emitida</span>';
			break;
		}

		$data[] = array(
			'id' => $res['id'],
			'cliente' => $res['nome'],
			'dataCadastro' => date('d/m/Y', strtotime($res['dataCadastro'])),
			'dataPrazo' => date('d/m/Y', strtotime($res['dataPrazo'])),
			'dataPagamento' => ($res['dataPagamento'] == '0000-00-00 00:00:00')? '' : date('d/m/Y', strtotime($res['dataPagamento'])),
			'valorAdicional' => $res['valorAdicional'],
			'valorPago' => $res['valorPago'],
			'status' => $status,
			'ativo' => $res['ativo'],
			'emitirNota' => $emitirNota,
			'button' => $button,
		);
	}
	
	echo json_encode($data);
}

function buscarDados($con, $dados){

	$id = $dados['id'];

	$model = new FinanceiroModel;

	$model->buscarDados($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array['id']= $data['id'];
		$array['cliente']= $data['nome'];
		$array['dataCadastro']= date('d/m/Y', strtotime($data['dataCadastro']));
		$array['dataPrazo']= date('d/m/Y', strtotime($data['dataPrazo']));
		$array['dataPagamento']= ($data['dataPagamento'] == '0000-00-00 00:00:00')? '' : date('d/m/Y', strtotime($data['dataPagamento']));
		$array['valorAdicional']= $data['valorAdicional'];
		$array['valorPago']= $data['valorPago'];
		$array['statusPagamento']= $data['statusPagamento'];
		$array['emitirNota']= $data['emitirNota'];

	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new FinanceiroModel;

	$dataPagamento = converteData($data['dataPagamento']);
	$statusPago = $data['statusPago'];
	$valorPago = $data['valorPago'];
	$emitirNota = $data['emitirNota'];
	$id = $data['id'];

	$model->editar($id, $dataPagamento, $statusPago, $valorPago, $emitirNota);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new FinanceiroModel;

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

	$model = new FinanceiroModel;

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

function buscarContasPagar($con, $dados){

	$data1 = converteData($dados['data1']);
	$data2 = converteData($dados['data2']);
	$status = $dados['status'];

	$model = new FinanceiroModel;

	$model->buscarContasPagar($data1, $data2, $status);

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
	
		if($res['ativo'] == 1){
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button></button><button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnlistarquivos"><i class="fa fa-archive"></i></button>';
		}

		switch ($res['status']) {
			case 0:
				$status = '<span class="label label-default">Aberto</span>';
			break;
			case 1:
				$status = '<span class="label label-danger">Pago</span>';
			break;
		}

		switch ($res['tipoConta']) {
			case 1:
				$sql = mysqli_query($con, "SELECT nome FROM clientes WHERE id = '".$res['idCliente']."' ");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
				$origem = 'Cliente';
			break;
			case 2:
				$sql = mysqli_query($con, "SELECT nome FROM fornecedores WHERE id = '".$res['idFornecedor']."'");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
				$origem = "Fornecedor";
			break;
			default:
				$vinculado = $res['origem'];
				$origem = "Comum";
			break;
		}

		switch ($res['formaPagamento']) {
			case 1:
				$formaPagamento = '<span class="label label-default">Dinheiro</span>';
			break;
			case 2:
				$formaPagamento = '<span class="label label-default">Cartão de Crédito</span>';
			break;
			case 3:
				$formaPagamento = '<span class="label label-default">Cartão de Debito</span>';
			break;
			case 4:
				$formaPagamento = '<span class="label label-default">Cheque</span>';
			break;
			case 5:
				$formaPagamento = '<span class="label label-default">Deposito em Conta</span>';
			break;
			case 6:
				$formaPagamento = '<span class="label label-default">Transferencia Bancaria</span>';
			break;
			case 7:
				$formaPagamento = '<span class="label label-default">Debito em Conta</span>';
			break;
			default:
				$formaPagamento = '';
			break;
		}

		$data[] = array(
			'id' => $res['id'],
			'origem' => $origem,
			'vinculado' => $vinculado,
			'formaPagamento' => $formaPagamento,
			'data' => date('d/m/Y', strtotime($res['data'])),
			'dataPagamento' => ($res['dataPagamento'] == '0000-00-00')? '' : date('d/m/Y', strtotime($res['dataPagamento'])),
			'valor' => $res['valor'],
			'status' => $status,
			'ativo' => $res['ativo'],
			'button' => $button,
		);
	}
	
	echo json_encode($data);
}

function cadastrarContaPagar($con, $data){

	$model = new FinanceiroModel;

	$origem = $data['origem'];
	$dataVencimento = converteData($data['dataVencimento']);
	$valor = $data['valor'];
	$status = $data['status'];
	$tipo = $data['tipo'];
	$cliente = $data['cliente'];
	$fornecedor = $data['fornecedor'];
	$formaPagamento = $data['formaPagamento'];

	$model->cadastrarContaPagar($origem, $dataVencimento, $valor, $status, $tipo, $cliente, $fornecedor, $formaPagamento);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscarDadosContaPagar($con, $dados){

	$id = $dados['id'];

	$model = new FinanceiroModel;

	$model->buscarDadosContaPagar($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array['id']= $data['id'];
		$array['origem']= $data['origem'];
		$array['data']= date('d/m/Y', strtotime($data['data']));
		$array['dataPagamento']= ($data['dataPagamento'] == '0000-00-00')? '' : date('d/m/Y', strtotime($data['dataPagamento']));
		$array['valor']= $data['valor'];
		$array['status']= $data['status'];
		$array['tipo']= $data['tipoConta'];
		$array['cliente']= $data['idCliente'];
		$array['fornecedor']= $data['idFornecedor'];
		$array['formaPagamento']= $data['formaPagamento'];

	}
	echo json_encode($array);
}

function editarContaPagar($con, $data){

	$model = new FinanceiroModel;

	$origem = $data['origem'];
	$dataVencimento = converteData($data['dataVencimento']);
	$dataPagamento = converteData($data['dataPagamento']);
	$valor = $data['valor'];
	$status = $data['status'];
	$id = $data['id'];
	$tipo = $data['tipo'];
	$cliente = $data['cliente'];
	$fornecedor = $data['fornecedor'];
	$formaPagamento = $data['formaPagamento'];

	$model->editarContaPagar($id, $origem, $dataVencimento, $valor, $status, $dataPagamento, $tipo, $cliente, $fornecedor, $formaPagamento);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscarContasReceber($con, $dados){

	$data1 = converteData($dados['data1']);
	$data2 = converteData($dados['data2']);
	$status = $dados['status'];

	$model = new FinanceiroModel;

	$model->buscarContasReceber($data1, $data2, $status);

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
	
		if($res['ativo'] == 1){
			$button = '<button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-info btnedit" ><i class="fa fa-edit"></i></button><button type="submit" id_user="'.$res['id'].'" class="btn-acoes btn btn-default btnlistarquivos"><i class="fa fa-archive"></i></button>';
		}

		switch ($res['status']) {
			case 0:
				$status = '<span class="label label-default">Aberto</span>';
			break;
			case 1:
				$status = '<span class="label label-danger">Recebido</span>';
			break;
		}

		switch ($res['tipoConta']) {
			case 1:
				$sql = mysqli_query($con, "SELECT nome FROM clientes WHERE id = '".$res['idCliente']."' ");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
				$origem = 'Cliente';
			break;
			case 2:
				$sql = mysqli_query($con, "SELECT nome FROM fornecedores WHERE id = '".$res['idFornecedor']."'");
				$row = mysqli_fetch_array($sql);
				$vinculado = $row['nome'];
				$origem = "Fornecedor";
			break;
			default:
				$vinculado = $res['origem'];
				$origem = "Comum";
			break;
		}

		switch ($res['formaPagamento']) {
			case 1:
				$formaPagamento = '<span class="label label-default">Dinheiro</span>';
			break;
			case 2:
				$formaPagamento = '<span class="label label-default">Cartão de Crédito</span>';
			break;
			case 3:
				$formaPagamento = '<span class="label label-default">Cartão de Debito</span>';
			break;
			case 4:
				$formaPagamento = '<span class="label label-default">Cheque</span>';
			break;
			case 5:
				$formaPagamento = '<span class="label label-default">Deposito em Conta</span>';
			break;
			case 6:
				$formaPagamento = '<span class="label label-default">Transferencia Bancaria</span>';
			break;
			case 7:
				$formaPagamento = '<span class="label label-default">Debito em Conta</span>';
			break;
			default:
				$formaPagamento = '';
			break;
		}

		$data[] = array(
			'id' => $res['id'],
			'origem' => $origem,
			'vinculado' => $vinculado,
			'formaPagamento' => $formaPagamento,
			'data' => date('d/m/Y', strtotime($res['data'])),
			'dataPagamento' => ($res['dataRecebimento'] == '0000-00-00')? '' : date('d/m/Y', strtotime($res['dataRecebimento'])),
			'valor' => $res['valor'],
			'status' => $status,
			'ativo' => $res['ativo'],
			'button' => $button,
		);
	}
	
	echo json_encode($data);
}

function cadastrarContaReceber($con, $data){

	$model = new FinanceiroModel;

	$origem = $data['origem'];
	$dataVencimento = converteData($data['dataVencimento']);
	$valor = $data['valor'];
	$status = $data['status'];
	$tipo = $data['tipo'];
	$cliente = $data['cliente'];
	$fornecedor = $data['fornecedor'];
	$formaPagamento = $data['formaPagamento'];

	$model->cadastrarContaReceber($origem, $dataVencimento, $valor, $status, $tipo, $cliente, $fornecedor, $formaPagamento);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscarDadosContaReceber($con, $dados){

	$id = $dados['id'];

	$model = new FinanceiroModel;

	$model->buscarDadosContaReceber($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array['id']= $data['id'];
		$array['origem']= $data['origem'];
		$array['data']= date('d/m/Y', strtotime($data['data']));
		$array['dataPagamento']= ($data['dataRecebimento'] == '0000-00-00')? '' : date('d/m/Y', strtotime($data['dataRecebimento']));
		$array['valor']= $data['valor'];
		$array['status']= $data['status'];
		$array['tipo']= $data['tipoConta'];
		$array['cliente']= $data['idCliente'];
		$array['fornecedor']= $data['idFornecedor'];
		$array['formaPagamento']= $data['formaPagamento'];

	}
	echo json_encode($array);
}

function editarContaReceber($con, $data){

	$model = new FinanceiroModel;

	$origem = $data['origem'];
	$dataVencimento = converteData($data['dataVencimento']);
	$dataPagamento = converteData($data['dataPagamento']);
	$valor = $data['valor'];
	$status = $data['status'];
	$id = $data['id'];
	$tipo = $data['tipo'];
	$cliente = $data['cliente'];
	$fornecedor = $data['fornecedor'];
	$formaPagamento = $data['formaPagamento'];

	$model->editarContaReceber($id, $origem, $dataVencimento, $valor, $status, $dataPagamento, $tipo, $cliente, $fornecedor, $formaPagamento);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

// arquivos
function buscarArquivosGerenciar($con, $dados){

	$id = $dados['idCliente'];

	$model = new FinanceiroModel;

	$model->buscarArquivosGerenciar($id);

	$data = array();
	while($res = mysqli_fetch_array($model->retorno)){
		$button = '<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['nome'].'" class="btn-acoes btn  btn-danger btndelarquivo" ><i class="fa fa-remove"></i></button>';
		$data['data'][] = array(
			'id' => $res['id'],
			'nome' => $res['nome'],
			'arquivo' => '<a href="../uploads/fingerenciar/'.$res['arquivo'].'" download>'.$res['arquivo'].'</a>',
			'dataCadastro' => date("d/m/Y", strtotime($res['dataCadastro'])),
			'button' => $button,
		);
	}
	echo json_encode($data);
}

function deletarArquivoGerenciar($con, $data){

	$model = new FinanceiroModel;

	$id = $data['id'];

	$model->deletarArquivoGerenciar($id);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscarArquivosConta($con, $dados){

	$id = $dados['idCliente'];

	$model = new FinanceiroModel;

	$model->buscarArquivosConta($id);

	$data = array();
	while($res = mysqli_fetch_array($model->retorno)){
		$button = '<button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['nome'].'" class="btn-acoes btn  btn-danger btndelarquivo" ><i class="fa fa-remove"></i></button>';
		$data['data'][] = array(
			'id' => $res['id'],
			'nome' => $res['nome'],
			'arquivo' => '<a href="../uploads/contas/'.$res['arquivo'].'" download>'.$res['arquivo'].'</a>',
			'dataCadastro' => date("d/m/Y", strtotime($res['dataCadastro'])),
			'button' => $button,
		);
	}
	echo json_encode($data);
}

function deletarArquivoConta($con, $data){

	$model = new FinanceiroModel;

	$id = $data['id'];

	$model->deletarArquivoConta($id);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}
?>