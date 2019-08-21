<?php 
include_once('../model/contasBancarias.php');
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

	$model = new ContasBancariasModel;

	$tipo = $data['tipo'];
	$usuario = $data['usuario'];
	$fornecedor = $data['fornecedor'];
	$banco = $data['banco'];
	$agencia = $data['agencia'];
	$conta = $data['conta'];
	$tipoConta = $data['tipoConta'];

	$model->cadastrar($tipo, $usuario, $fornecedor, $banco, $agencia, $conta, $tipoConta);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscar($con){

	$model = new ContasBancariasModel;

	$model->buscar();

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {

		$button = '<button type="submit" id_user="'.$res['id'].'" class="btn btn-info  btnedit" ><i class="fa fa-edit"></i></button>
				    <button type="submit" id_user="'.$res['id'].'" nome_user="'.$res['conta'].'" class="btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';

		switch ($res['tipo']) {
			case 1:
				$sql = mysqli_query($con, "SELECT nome FROM usuarios WHERE id = '".$res['idUsuario']."' ");
				$row = mysqli_fetch_array($sql);
				$nome = $row['nome'];
				$tipo = 'Usuario';
			break;
			case 2:
				$sql = mysqli_query($con, "SELECT nome FROM fornecedores WHERE id = '".$res['idFornecedor']."'");
				$row = mysqli_fetch_array($sql);
				$nome = $row['nome'];
				$tipo = "Fornecedor";
			break;
			default:
				$tipo = "";
				$nome = "";
			break;
		}
		switch ($res['tipoConta']) {
			case 1:
				$tipoConta = "Corrente";
			break;
			case 2:
				$tipoConta = "Poupança";
			break;
		}
		$data['data'][] = array(
			'tipo' => $tipo,
			'nome' => $nome,
			'banco' => $res['banco'],
			'agencia' => $res['agencia'],
			'conta' => $res['conta'],
			'tipoConta' => $tipoConta,
			'button' => $button
		);
	}

	echo json_encode($data);
}

function buscarDados($con, $dados){

	$id = $dados['id'];

	$model = new ContasBancariasModel;

	$model->buscarDados($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		$array['id']= $data['id'];
		$array['tipo']= $data['tipo'];
		$array['idFornecedor']= $data['idFornecedor'];
		$array['idUsuario']= $data['idUsuario'];
		$array['banco']= $data['banco'];
		$array['agencia']= $data['agencia'];
		$array['conta']= $data['conta'];
		$array['tipoConta']= $data['tipoConta'];
	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new ContasBancariasModel;

	$tipo = $data['tipo'];
	$usuario = $data['usuario'];
	$fornecedor = $data['fornecedor'];
	$banco = $data['banco'];
	$agencia = $data['agencia'];
	$conta = $data['conta'];
	$tipoConta = $data['tipoConta'];
	$id = $data['id'];

	$model->editar($id, $tipo, $usuario, $fornecedor, $banco, $agencia, $conta, $tipoConta);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new ContasBancariasModel;

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

	$model = new ContasBancariasModel;

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