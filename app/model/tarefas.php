<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class TarefasModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($tarefa, $dataAgendamento, $horarioAgendamento, $dataPrazo, $horarioPrazo, $responsavel, $contato1, $status, $situacao, $descricao){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `tarefas`(`tarefa`,`descricao`, `situacao`, `dataAgendamento`, `horarioAgendamento`, `dataPrazo`, `horarioPrazo`, `responsavel`, `contato1`, `status`,  `dataCadastro`, `ativo`) VALUES ('$tarefa','$descricao','$situacao', '$dataAgendamento', '$horarioAgendamento', '$dataPrazo', '$horarioPrazo','$responsavel', '$contato1', '$status', NOW(), 1)");

			return $this->retorno;

		}

		public function buscar(){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = t.responsavel) as responsavel FROM tarefas as t WHERE ativo = 1 order by id desc");

			return $this->retorno;

		}

		public function buscarTarefaUnitaria($idRef){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = t.responsavel) as responsavel FROM tarefas as t WHERE ativo = 1 and responsavel = $idRef");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM usuarios WHERE id = t.responsavel) as responsavelView, (SELECT nome FROM contatos WHERE id = t.contato1) as nomeContatoView, (SELECT contato1 FROM contatos WHERE id = t.contato1) as contatoView FROM tarefas as t WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $tarefa, $dataAgendamento, $horarioAgendamento, $dataPrazo, $horarioPrazo, $responsavel, $contato1, $status, $descricao, $situacao){

			$this->retorno = mysqli_query($this->con, "UPDATE `tarefas` SET `tarefa`='$tarefa',`descricao`='$descricao',`situacao`='$situacao',`dataAgendamento`='$dataAgendamento',`horarioAgendamento`='$horarioAgendamento',`dataPrazo`='$dataPrazo',`horarioPrazo`='$horarioPrazo',`responsavel`='$responsavel',`contato1`='$contato1',`status`='$status' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `tarefas` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `tarefas` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}

		public function listarUsuaios(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `usuarios` WHERE ativo = 1");

			return $this->retorno;

		}

		public function listarContatos(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `contatos` WHERE ativo = 1");

			return $this->retorno;

		}

		public function imprimirPDF($id){

			$this->retorno = mysqli_query($this->con, "SELECT o.*, (SELECT nome FROM usuarios WHERE id = o.responsavel) as responsavel, (SELECT contato1 FROM usuarios WHERE id = o.responsavel) as contatato1Responsavel, (SELECT contato2 FROM usuarios WHERE id = o.responsavel) as contatato2Responsavel, (SELECT email FROM usuarios WHERE id = o.responsavel) as emailResponsavel FROM tarefas as o  WHERE o.id = $id");

			return $this->retorno;

		}


		//despesas

		public function listarDespesas(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `despesas` WHERE ativo = 1");

			return $this->retorno;

		}

		public function buscarDespesas($id){

			$this->retorno = mysqli_query($this->con, "SELECT do.id as id, d.nome, do.anexo, do.valor, do.dataCadastro, do.descricao FROM despesasorigem as do inner join despesas as d on do.idDespesa = d.id WHERE do.tipo = 2 and do.idOrigem = $id and do.ativo = 1");

			return $this->retorno;

		}

		public function deletarDespesa($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `despesasorigem` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}


		public function adicionarDespesa($despesa,$descricao,$valor, $fotoComp, $idUsuarioDespesa){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `despesasorigem`(`tipo`, `idOrigem`, `idDespesa`, `descricao`, `valor`, `anexo`, `dataCadastro`, `idRef`, `ativo`) VALUES (2, '$idUsuarioDespesa', '$despesa', '$descricao', '$valor', '$fotoComp', NOW(), 1, 1)") or die(mysqli_error($this->con));

			return $this->retorno;
		}
		
	}

?>