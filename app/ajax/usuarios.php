<?php 
include_once('../model/usuarios.php');
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

	$model = new UsuariosModel;

	$nome = $data['nome'];
	$email = $data['email'];
	$contato1 = $data['contato1'];
	$contato2 = $data['contato2'];
	$senha = $data['senha'];
	$cargo = $data['cargo'];
	$nivel = $data['nivel'];

	$model->cadastrar($nome, $email, $contato1, $contato2, $senha, $cargo, $nivel);

	$res = array();
	if($model->retorno){
        $res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function buscar($con){

	$model = new UsuariosModel;

	$model->buscar();

	$data = array();
	while($res = mysqli_fetch_assoc($model->retorno)) {
		$data[] = $res;
	}
	$i=0;
	foreach ($data as $key) {
			// add new button
		if($data[$i]['ativo'] == 1){
			$data[$i]['button'] = '<button type="submit" id_user="'.$data[$i]['id'].'" class="btn  btn-info btnedit" ><i class="fa fa-edit"></i></button>
			<button type="submit" id_user="'.$data[$i]['id'].'" class="btn-acoes btn btn-default  btnviewbank" ><i class="fa fa-money"></i></button>
								   <button type="submit" id_user="'.$data[$i]['id'].'" nome_user="'.$data[$i]['nome'].'" class="btn  btn-danger btndel" ><i class="fa fa-remove"></i></button>';
		}else{
			$data[$i]['button'] = '<button type="submit" id_user="'.$data[$i]['id'].'" class="btn  btn-info btnedit" ><i class="fa fa-edit"></i></button>
								   <button type="submit" id_user="'.$data[$i]['id'].'" nome_user="'.$data[$i]['nome'].'" class="btn  btn-success btnativar" ><i class="fa fa-check"></i></button>';
		}
		$i++;
	}
	$datax = array('data' => $data);
	echo json_encode($datax);
}

function buscarDados($con, $dados){

	$id = $dados['id'];

	$model = new UsuariosModel;

	$model->buscarDados($id);

	$array = array();
	while($data = mysqli_fetch_array($model->retorno)){
		switch ($data['nivel']) {
			case 1:
				$nivel = "Administrador";	
			break;
			case 2:
				$nivel = "Gerente";	
			break;
			case 3:
				$nivel = "Suporte";	
			break;
		}
		$array['id']= $data['id'];
		$array['nome'] = $data['nome'];
		$array['contato1'] = $data['contato1'];
		$array['contato2'] = $data['contato2'];
		$array['email'] = $data['email'];
		$array['cargo'] = $data['cargo'];
		$array['nivel'] = $data['nivel'];
	}
	echo json_encode($array);
}

function editar($con, $data){

	$model = new UsuariosModel;

	$nome = $data['nome'];
	$email = $data['email'];
	$contato1 = $data['contato1'];
	$contato2 = $data['contato2'];
	$cargo = $data['cargo'];
	$nivel = $data['nivel'];
	$id = $data['id'];

	$model->editar($id, $nome, $email, $contato1, $contato2, $cargo, $nivel);

	$res = array();
	if($model->retorno){
		$res['status'] = 200;
    }else{
        $res['status'] = 511;
    }

    echo json_encode($res);
}

function deletar($con, $data){

	$model = new UsuariosModel;

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

	$model = new UsuariosModel;

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

	$model = new UsuariosModel;

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