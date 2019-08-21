<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class FinanceiroModel extends dbconnect{
		
		public $retorno;
		

		public function buscar($data1, $data2, $status){

			$sql = "SELECT os.id, c.nome, os.dataCadastro, os.dataPrazo, os.dataPagamento, os.valorAdicional, os.valorPago, os.statusPagamento, os.ativo, os.emitirNota FROM ordemservicos as os inner join clientes as c on os.cliente = c.id WHERE DATE_FORMAT(os.dataPrazo, \"%Y-%m-%d\") BETWEEN '$data1' and '$data2' and os.ativo = 1 ";

			if($status < 2){
				$sql .= " and os.statusPagamento = $status ";
			}

			$this->retorno = mysqli_query($this->con, $sql);

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT os.id, os.dataPrazo, c.nome, os.dataCadastro, os.dataPagamento, os.valorAdicional, os.valorPago, os.statusPagamento, os.ativo, os.emitirNota FROM ordemservicos as os inner join clientes as c on os.cliente = c.id WHERE os.id = $id");

			return $this->retorno;

		}	

		public function editar($id, $dataPagamento, $statusPago, $valorPago, $emitirNota){

			$this->retorno = mysqli_query($this->con, "UPDATE `ordemservicos` SET `valorPago`='$valorPago', `statusPagamento`='$statusPago', `dataPagamento`='$dataPagamento', `emitirNota`='$emitirNota' WHERE id = $id");

			return $this->retorno;

		}

		public function buscarContasPagar($data1, $data2, $status){

			$sql = "SELECT * FROM contas WHERE DATE_FORMAT(data, \"%Y-%m-%d\") BETWEEN '$data1' and '$data2' and ativo = 1 and tipo = 1 ";

			if($status < 2){
				$sql .= " and status = $status ";
			}

			$this->retorno = mysqli_query($this->con, $sql);

			return $this->retorno;

		}

		public function cadastrarContaPagar($origem, $dataVencimento, $valor, $status, $tipo, $cliente, $fornecedor, $formaPagamento){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `contas`(`tipo`, `tipoConta`, `idCliente`, `idFornecedor`, `origem`, `data`,  `valor`, `formaPagamento`, `status`, `dataCadastro`, `ativo`) VALUES (1, '$tipo', '$cliente', '$fornecedor','$origem', '$dataVencimento', '$valor', '$formaPagamento', 0, NOW(), 1)");

			return $this->retorno;

		}

		public function buscarDadosContaPagar($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM contas  WHERE id = $id");

			return $this->retorno;

		}

		public function editarContaPagar($id, $origem, $dataVencimento, $valor, $status, $dataPagamento, $tipo, $cliente, $fornecedor, $formaPagamento){

			$this->retorno = mysqli_query($this->con, "UPDATE `contas` SET `origem`='$origem',`data`='$dataVencimento',`dataPagamento`='$dataPagamento',`valor`='$valor',`status`='$status',`tipoConta`='$tipo',`idCliente`='$cliente',`idFornecedor`='$fornecedor',`formaPagamento`='$formaPagamento' WHERE id = $id ");

			return $this->retorno;

		}

		// contas receber
		public function buscarContasReceber($data1, $data2, $status){

			$sql = "SELECT * FROM contas WHERE DATE_FORMAT(data, \"%Y-%m-%d\") BETWEEN '$data1' and '$data2' and ativo = 1 and tipo = 2 ";

			if($status < 2){
				$sql .= " and status = $status ";
			}

			$this->retorno = mysqli_query($this->con, $sql);

			return $this->retorno;

		}

		public function cadastrarContaReceber($origem, $dataVencimento, $valor, $status, $tipo, $cliente, $fornecedor, $formaPagamento){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `contas`(`tipo`, `tipoConta`, `idCliente`, `idFornecedor`, `origem`, `data`,  `valor`, `formaPagamento`, `status`, `dataCadastro`, `ativo`) VALUES (2, '$tipo', '$cliente', '$fornecedor','$origem', '$dataVencimento', '$valor', '$formaPagamento', 0, NOW(), 1)");

			return $this->retorno;

		}

		public function buscarDadosContaReceber($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM contas  WHERE id = $id");

			return $this->retorno;

		}

		public function editarContaReceber($id, $origem, $dataVencimento, $valor, $status, $dataPagamento, $tipo, $cliente, $fornecedor, $formaPagamento){

			$this->retorno = mysqli_query($this->con, "UPDATE `contas` SET `origem`='$origem',`data`='$dataVencimento', `dataRecebimento`='$dataPagamento',`valor`='$valor',`status`='$status',`tipoConta`='$tipo',`idCliente`='$cliente',`idFornecedor`='$fornecedor',`formaPagamento`='$formaPagamento' WHERE id = $id ");

			return $this->retorno;

		}

		public function listarClientes(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM clientes WHERE ativo = 1 ");

			return $this->retorno;

		}

		public function listarFornecedores(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM fornecedores WHERE ativo = 1 ");

			return $this->retorno;

		}

		// arquivos
		public function buscarArquivosGerenciar($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `uploadfingerenciar` WHERE idGerenciar = $id and ativo = 1");

			return $this->retorno;

		}

		public function deletarArquivoGerenciar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `uploadfingerenciar` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function buscarArquivosConta($id){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `uploadconta` WHERE idConta = $id and ativo = 1");

			return $this->retorno;

		}

		public function deletarArquivoConta($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `uploadconta` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

	}

?>