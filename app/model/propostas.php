<?php
	include_once ("dbconnect.php");
	
	class PropostasModel extends dbconnect{
		
		public $retorno;
		

		public function cadastrar($cliente, $servico, $proposta, $observacoes, $garantiaEquipamento, $garantiaMaoObra, $prazoEntrega, $valorMaterial, $valorMaoObra, $valorAdicional, $entrada, $valorEntrada, $saldo, $status, $idRef, $tipo, $contato){

			$this->retorno = mysqli_query($this->con, "INSERT INTO `propostas`(`tipo`,`cliente`,`contato`, `servico`, `proposta`, `observacoes`, `garantiaEquipamento`, `garantiaMaoObra`, `prazoEntrega`, `valorMaterial`, `valorMaoObra`, `valorAdicional`, `entrada`, `valorEntrada`, `saldo`, `status`, `idRef`, `dataCadastro`, `ativo`) VALUES ('$tipo','$cliente','$contato','$servico','$proposta','$observacoes','$garantiaEquipamento','$garantiaMaoObra', '$prazoEntrega', '$valorMaterial','$valorMaoObra','$valorAdicional','$entrada','$valorEntrada','$saldo','$status','$idRef', NOW(), 1)");

			return $this->retorno;

		}

		public function buscar($nivel, $idRef){

			if($nivel < 3){
				$this->retorno = mysqli_query($this->con, "SELECT * FROM propostas as o  WHERE o.ativo = 1 order by o.id desc");
			}else{
				$this->retorno = mysqli_query($this->con, "SELECT * FROM propostas as o WHERE o.ativo = 1 and idRef = $idRef order by o.id desc");
			}


			return $this->retorno;

		}

		public function buscarDados($id){

			$this->retorno = mysqli_query($this->con, "SELECT *, (SELECT nome FROM clientes WHERE id = p.cliente) as clienteView FROM propostas as p WHERE id = $id");

			return $this->retorno;

		}	

		public function editar($id, $cliente, $servico, $proposta, $observacoes, $garantiaEquipamento, $garantiaMaoObra, $prazoEntrega, $valorMaterial, $valorMaoObra, $valorAdicional, $entrada, $valorEntrada, $saldo, $status, $tipo, $contato){

			$this->retorno = mysqli_query($this->con, "UPDATE `propostas` SET `tipo`='$tipo',`cliente`='$cliente',`contato`='$contato',`servico`='$servico',`proposta`='$proposta',`observacoes`='$observacoes',`garantiaEquipamento`='$garantiaEquipamento',`garantiaMaoObra`='$garantiaMaoObra',`prazoEntrega`='$prazoEntrega',`valorMaterial`='$valorMaterial',`valorMaoObra`='$valorMaoObra',`valorAdicional`='$valorAdicional',`entrada`='$entrada',`valorEntrada`='$valorEntrada',`saldo`='$saldo',`status`='$status',`dataCadastro`=NOW() WHERE id = $id");

			return $this->retorno;

		}

		public function deletar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `propostas` SET `ativo`= 0 WHERE id = $id");

			return $this->retorno;

		}

		public function ativar($id){

			$this->retorno = mysqli_query($this->con, "UPDATE `propostas` SET `ativo`= 1 WHERE id = $id");

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

		public function imprimirPDF($id){

			$this->retorno = mysqli_query($this->con, "SELECT o.tipo as tipo, o.contato as contato, o.cliente as cliente, c.id as idCliente, o.id as id, servico, proposta, o.observacoes, garantiaEquipamento, garantiaMaoObra, prazoEntrega, valorMaterial, valorMaoObra, valorAdicional, entrada, valorEntrada, saldo, o.dataCadastro, c.nome, c.razao, c.logadouro, c.numero, c.bairro, c.cidade, c.estado, c.contato1, c.contato2, (SELECT nome FROM usuarios WHERE id = o.idRef) as responsavel, (SELECT contato1 FROM usuarios WHERE id = o.idRef) as contatato1Responsavel, (SELECT contato2 FROM usuarios WHERE id = o.idRef) as contatato2Responsavel, (SELECT email FROM usuarios WHERE id = o.idRef) as emailResponsavel FROM propostas as o left join clientes as c on o.cliente = c.id WHERE o.id = $id");

			return $this->retorno;

		}

		public function listarContatos(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `contatos` WHERE ativo = 1");

			return $this->retorno;

		}

		public function listarProdutos(){

			$this->retorno = mysqli_query($this->con, "SELECT * FROM `produtos` WHERE ativo = 1");

			return $this->retorno;

		}
		
	}

?>