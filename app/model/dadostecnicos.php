<?php
	include_once ("dbconnect.php");
	include_once ("funcoes/criptaSenha.php");
	
	class DadosTecnicosModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($nome, $equipamento, $cliente, $serial, $portainicio, $portafim, $senharemoto, $usuario, $senha, $responsavel, $observacoes,$idRef ){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `dadostecnicos`(`idEquipamento`, `nome`, `idCliente`, `serial`, `portainicio`, `portafim`, `senharemoto`, `usuario`, `senha`, `observacoes`, `ultimaAlteracao`,`idResponsavel`, `idRef`, `dataCadastro`, `ativo`) VALUES ('$equipamento', '$nome','$cliente','$serial','$portainicio','$portafim','$senharemoto','$usuario','$senha','$observacoes',NOW(),'$responsavel','$idRef',NOW(),1)");

			return $this->retorno;

		}

		public function buscar($idCliente){

			$this->retorno = mysqli_query($this->con, "SELECT d.ativo as ativo, d.id as id, d.nome as nome, c.nome as cliente, p.descricao as descricaoproduto, p.marcamodelo as marcamodelo, d.serial as serial FROM dadostecnicos as d inner join clientes as c on d.idCliente = c.id inner join produtos as p on d.idEquipamento = p.id  WHERE d.ativo = 1 and d.idCliente = $idCliente");

			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM produtos WHERE id = d.idEquipamento) as equipamentoView, (SELECT nome FROM clientes WHERE id = d.idCliente) as clienteView, (SELECT nome FROM usuarios WHERE id = d.idResponsavel) as responsavelView FROM dadostecnicos as d WHERE d.id = $id");

			return $this->retorno;

		}	

		public function editar($id, $nome, $equipamento, $cliente, $serial, $portainicio, $portafim, $senharemoto, $usuario, $senha, $responsavel, $observacoes){

			$this->retorno = mysqli_query($this->con, "UPDATE `dadostecnicos` SET `idEquipamento`='$equipamento',`nome`='$nome',`idCliente`='$cliente',`serial`='$serial',`portainicio`='$portainicio',`portafim`='$portafim',`senharemoto`='$senharemoto',`usuario`='$usuario',`senha`='$senha',`observacoes`='$observacoes',`ultimaAlteracao`= NOW(), `idResponsavel`='$responsavel' WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `dadostecnicos` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `dadostecnicos` SET `ativo`= 1 WHERE id = $id");

			return $this->retorno;

		}


		public function listarClientes(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `clientes` WHERE ativo = 1");

			return $this->retorno;

		}

		public function listarProdutos(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `produtos` WHERE ativo = 1");

			return $this->retorno;

		}

		public function listarUsuaios(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `usuarios` WHERE ativo = 1");

			return $this->retorno;

		}

		
	}

?>