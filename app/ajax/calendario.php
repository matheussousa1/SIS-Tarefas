<?php 
include_once('../model/calendario.php');
$con = condb();

//for handle post action and perform operations 
if(isset($_GET['acao']) && $_GET['acao'] != ''){
    switch ($_GET['acao']) {
        case 'buscar':
        	buscar($con, $_GET);
        break;
    }
}

function buscar($con, $data){

	$model = new CalendarioModel;

	$start = $data['start'];
	$end = $data['end'];
	//echo $start.$end;
	$model->buscar($start, $end);
	
	$data = array();
	while($res = mysqli_fetch_array($model->retorno)){
		switch ($res['tipo']) {
			case 1:
				$numero = $res['id']+1000;
				$title = $numero." - ".$res['title'];
				$className = "b-l b-2x b-greensea";
			 	
			 	if($res['status'] == 1){
					$color = "#FF6347";
				}elseif($res['status'] == 5){
					$color = "#8B0000";
				}else{
					$color = "#E9967A";
				}
			break;
			case 2:
				$numero = $res['id']+100;
			 	$title = $numero." - ".$res['title'];
			 	$className = "b-l b-2x b-lightred";
			 	
			 	if($res['status'] == 1){
					$color = "#1E90FF";
				}elseif($res['status'] == 5){
					$color = "#000080";
				}else{
					$color = "#B0C4DE";
				}
			break;
		}

		$data[] = array(
			'id' => $res['id'],
			'title' => $title,
			'start' => $res['dataAgendamento']."T".$res['horarioAgendamento'],
			'end' => $res['dataPrazo']."T".$res['horarioPrazo'],
			'className' => $className,
			'color'=> $color,     // an option!
      		'textColor'=> "#fff",
      		'description'=> $res['description']
		);
	}
	echo json_encode($data);
}

?>