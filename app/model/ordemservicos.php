<?php
	include_once ("dbconnect.php");
	
	class OrdemServicosModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($cliente, $motivo, $laudo, $dataAgendamento, $horarioAgendamento, $dataPrazo, $horarioPrazo, $responsavel, $valorProduto, $valorMaoObra, $valorAdicional, $observacoes, $status){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `ordemservicos`(`cliente`, `motivo`, `laudo`, `dataAgendamento`, `horarioAgendamento`, `dataPrazo`, `horarioPrazo`, `responsavel`, `valorProduto`, `valorMaoObra`, `valorAdicional`, `observacoes`, `status`, `dataCadastro`, `ativo`) VALUES ('$cliente','$motivo', '$laudo', '$dataAgendamento', '$horarioAgendamento','$dataPrazo','$horarioPrazo','$responsavel','$valorProduto','$valorMaoObra','$valorAdicional','$observacoes', '$status', NOW(), 1)");

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM clientes WHERE id = o.cliente) as cliente, (SELECT nome FROM usuarios WHERE id = o.responsavel) as responsavel FROM ordemservicos as o  WHERE o.ativo = 1 order by o.id desc");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM clientes WHERE id = o.cliente) as clienteView, (SELECT nome FROM usuarios WHERE id = o.responsavel) as responsavelView FROM ordemservicos as o WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $cliente, $motivo, $laudo, $dataAgendamento, $horarioAgendamento, $dataPrazo, $horarioPrazo, $responsavel, $valorProduto, $valorMaoObra, $valorAdicional, $observacoes, $status){

			$this->retorno = mysqli_query($this->con, "UPDATE `ordemservicos` SET `cliente`='$cliente',`motivo`='$motivo',`laudo`='$laudo',`dataAgendamento`='$dataAgendamento',`horarioAgendamento`='$horarioAgendamento',`dataPrazo`='$dataPrazo',`horarioPrazo`='$horarioPrazo',`responsavel`='$responsavel',`valorProduto`='$valorProduto',`valorMaoObra`='$valorMaoObra',`valorAdicional`='$valorAdicional',`observacoes`='$observacoes',`status`='$status' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `ordemservicos` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `ordemservicos` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		public function listarUsuaios(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `usuarios` WHERE ativo = 1");

			return $this->retorno;

		}

		public function listarClientes(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `clientes` WHERE ativo = 1");

			return $this->retorno;

		}

		public function adicionarAndamento($id, $observacoes, $dataAnda, $porcentagem, $idRef, $statusAndamento, $horarioAndaEntrada, $horarioAndaSaida){

			$this->retorno[] = mysqli_query($this->con, "INSERT INTO `andamentoordemservico`(`idOs`, `descricao`, `dataAndamento`,`horaEntrada`,`horaSaida`, `porcentagem`,`idRef`, `ativo`) VALUES ('$id', '$observacoes', '$dataAnda', '$horarioAndaEntrada', '$horarioAndaSaida','$porcentagem', '$idRef',1)");

			$this->retorno[] = mysqli_query($this->con, "UPDATE `ordemservicos` SET `status`= '$statusAndamento' WHERE id = $id");

			return $this->retorno;

		}

		public function buscarAndamentoOs($id){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = a.idRef) as usuario FROM `andamentoordemservico` as a WHERE idOs = $id and ativo = 1");

			return $this->retorno;

		}

		public function buscarEditAndamentoOs($id){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = a.idRef) as usuario, (SELECT status FROM ordemservicos WHERE id = a.idOs) as status FROM `andamentoordemservico` as a WHERE id = $id and ativo = 1");

			return $this->retorno;

		}

		public function alterarAndamento($id, $observacoes, $dataAnda, $porcentagem, $statusAndamentoEdit, $horarioAndaEntradaEdit, $horarioAndaSaidaEdit){

			$this->retorno[] = mysqli_query($this->con, "UPDATE `andamentoordemservico` SET `descricao`='$observacoes',`dataAndamento`='$dataAnda',`horaEntrada`='$horarioAndaEntradaEdit',`horaSaida`='$horarioAndaSaidaEdit',`porcentagem`='$porcentagem' WHERE id = $id");

			$sqlOrdem = mysqli_query($this->con, "SELECT idOs FROM andamentoordemservico WHERE id = $id");
			$ordem = mysqli_fetch_object($sqlOrdem);

			$this->retorno[] = mysqli_query($this->con, "UPDATE `ordemservicos` SET `status`= '$statusAndamentoEdit' WHERE id = $ordem->idOs");

			return $this->retorno;

		}

		public function imprimirPDF($id){

			$this->retorno[] = mysqli_query($this->con, "SELECT c.observacoes as obsCliente, c.id as idCliente, o.id as id, dataAgendamento, horarioAgendamento, motivo, laudo, o.observacoes, c.nome, c.razao, c.logadouro, c.numero, c.bairro, c.cidade, c.estado, c.contato1, c.contato2, (SELECT nome FROM usuarios WHERE id = o.responsavel) as responsavel, (SELECT contato1 FROM usuarios WHERE id = o.responsavel) as contatato1Responsavel, (SELECT contato2 FROM usuarios WHERE id = o.responsavel) as contatato2Responsavel, (SELECT email FROM usuarios WHERE id = o.responsavel) as emailResponsavel FROM ordemservicos as o inner join clientes as c on o.cliente = c.id WHERE o.id = $id");

			return $this->retorno;

		}

		public function buscarAndamentoOsPrint($id){

			$this->retorno[] = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = a.idRef) as usuario FROM `andamentoordemservico` as a WHERE idOs = $id and ativo = 1");

			return $this->retorno;

		}

		public function checkin($idOS, $idRef){

			$this->retorno = mysqli_query($this->con, "UPDATE `ordemservicos` SET `responsavel`= $idRef, `inicio`= NOW() WHERE id = $idOS");

			return $this->retorno;

		}

		public function checkout($idOS, $idRef, $status){

			$this->retorno = mysqli_query($this->con, "UPDATE `ordemservicos` SET `responsavel`= $idRef, `terminio`= NOW(), `status` = '$status' WHERE id = $idOS");

			return $this->retorno;

		}

		// arquivos
		public function buscarArquivos($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `uploados` WHERE idOs = $id and ativo = 1");

			return $this->retorno;

		}

		public function deletarArquivo($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `uploados` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		//despesas

		public function listarDespesas(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `despesas` WHERE ativo = 1");

			return $this->retorno;

		}

		public function buscarDespesas($id){

			$this->retorno = mysqli_query($this->con, "SELECT do.id as id, d.nome, do.anexo, do.valor, do.dataCadastro, do.descricao FROM despesasorigem as do inner join despesas as d on do.idDespesa = d.id WHERE do.tipo = 1 and do.idOrigem = $id and do.ativo = 1");

			return $this->retorno;

		}

		public function deletarDespesa($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `despesasorigem` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}


		public function adicionarDespesa($despesa,$descricao,$valor, $fotoComp, $idUsuarioDespesa){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `despesasorigem`(`tipo`, `idOrigem`, `idDespesa`, `descricao`, `valor`, `anexo`, `dataCadastro`, `idRef`, `ativo`) VALUES (1, '$idUsuarioDespesa', '$despesa', '$descricao', '$valor', '$fotoComp', NOW(), 1, 1)") or die(mysqli_error($this->con));

			return $this->retorno;
		}

		
	}

?>