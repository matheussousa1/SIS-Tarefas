<?php
ob_start();
$con = condb();
$res = mysqli_fetch_object($this->resultado);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8" />

		<title>Imprimir Proposta</title>
		<meta name="description" content="" />
		<meta name="author" content="Matheus Sousa" />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet"  href="http://sistema.sgoes.com.br/bootstrapPDF/bootstrap.css">
		<style type="text/css" media="all">
			body {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 10.5px;
				/* text-align: justify; */
			}
			.espImgContrato{
				width: 20px;
			}
			.logoMaisSaude{
				/*margin-top:-40px;*/
				/* margin-left:40px; */
				width: 250px;
				height:auto;
			}
			
			.centralizar{
				text-align:center;
			}
			.textomaisculo{
				text-transform: uppercase;
			}
			.espacoparagrafo{
				text-indent: 25px;
			}
			.linhapontilhada{
				width: 100%;
				height:auto;
			}
			.back{
				background-color: red;
			}
			.marginh{
				 margin-top: 1px !important;
  				margin-bottom: 1px  !important;
			}
			.semmargemesquerda{
			  padding-right: 0px !important; 
			  /*padding-left: 0px !important;*/
			}
			.col-xs-2-do-chato {
			  width: 22%;
			}
		</style>

	</head>

	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-4"><img src="http://sistema.sgoes.com.br/img/logopdf.jpeg" class="logoMaisSaude"></div>
				<div class="col-xs-4 text-left semmargem">
					<b>Sistemas de segurança e automação<br> 
						✉ atendimento@sgoes.com<br>
						☏ 51 3330.7866 ✆ 51 996.706030 <br>
					SGOES.COM.BR</b></div>
				<div class="col-xs-3 text-right semmargem">
					<p><b>Proposta: <?php echo $res->id+5000; ?></b></p>
					<p>Emissão: <?php echo date("d/m/y", strtotime($res->dataCadastro)); ?></p>
					<p>Validade: 15 dias</p>
				</div>
			</div>
			<hr>
			<div class="row">
				<?php if($res->tipo == 1):
					$sqlContato = mysqli_query($con, "SELECT * FROM `contatos` where idCliente = $res->idCliente and ativo = 1") or die(mysqli_error($con));
					$contato = mysqli_fetch_object($sqlContato);
				 ?>
				<div class="col-xs-5 semmargemesquerda">
					<h5>Cliente</h5>
					<h6 class="marginh"><b><?php echo $res->nome; ?></b></h6>
					<h6 class="marginh"><?php echo $res->logadouro.', '.$res->numero.', '.$res->bairro; ?></h6>
					<h6 class="marginh"><?php echo $res->cidade." - ".$res->estado; ?></h6>
				</div>
				<div class="col-xs-4 semmargem">
					<h5>Contato</h5>
					<h6 class="marginh"><b><?php echo $contato->nome; ?></b></h6>
					<h6 class="marginh">✆ <?php echo $contato->contato1; ?></h6>
					<h6 class="marginh">✉ <?php echo $contato->email; ?></h6>
				</div>
				<?php else:
					$sqlContato = mysqli_query($con, "SELECT * FROM `contatos` where id = $res->contato and ativo = 1") or die(mysqli_error($con));
					$contato = mysqli_fetch_object($sqlContato);
				 ?>
					<div class="col-xs-2-do-chato semmargem">
					<h5>Contato</h5>
					<h6 class="marginh"><b><?php echo $contato->nome; ?></b></h6>
					<h6 class="marginh">✆ <?php echo $contato->contato1; ?></h6>
					<h6 class="marginh">✉ <?php echo $contato->email; ?></h6>
				</div>
				<?php endif; ?>
				<div class="col-xs-2-do-chato semmargem">
					<h5>Responsável</h5>
					<h6 class="marginh"><?php echo $res->responsavel; ?></h6>
					<h6 class="marginh">✆ <?php echo $res->contatato1Responsavel; ?></h6>
					<h6 class="marginh">✉ <?php echo $res->emailResponsavel; ?></h6>
				</div>
			</div>
			<hr>
			<?php if($res->servico != ''): ?>
			<div class="row">
				<div class="col-xs-12">
					<h4>Serviço</h4>
					<h5><?php echo $res->servico; ?></h5>
				</div>
			</div>
			<hr>
			<?php endif; ?>
			<?php if($res->proposta != ''): ?>
			<div class="row">
				<div class="col-xs-12">
					<h4>Detalhes da proposta</h4>
					<h5><?php echo $res->proposta; ?></h5>
				</div>
			</div>
			<hr>
			<?php endif; ?>
			<?php if($res->observacoes != ''): ?>
			<div class="row">
				<div class="col-xs-12">
					<h4>Observações</h4>
					<h5><?php echo $res->observacoes; ?></h5>
				</div>
			</div>
			<hr>
			<?php endif; ?>
			<?php if(($res->garantiaEquipamento != '') && ($res->garantiaMaoObra != '')): ?>
			<div class="row">
				<div class="col-xs-12">
					<h4>Garantias</h4>
					<h5>Equipamentos: <?php echo $res->garantiaEquipamento; ?> meses</h5>
					<h5>Mão-de-obra: <?php echo $res->garantiaMaoObra; ?> meses</h5>
				</div>
			</div>
			<hr>
			<?php endif; ?>
			<?php if($res->valorMaterial != ''): ?>
			<div class="row">
				<div class="col-xs-12">
					<h4>Valores</h4>
					<h5>Materiais e insumos: R$ <?php echo number_format($res->valorMaterial, 2, ',', '.'); ?></h5>
					<h5>Mão-de-obra especializada: R$ <?php echo number_format($res->valorMaoObra, 2, ',', '.'); ?></h5>
					<h5>TOTAL: R$ <?php echo number_format($res->valorAdicional, 2, ',', '.'); ?></h5>
				</div>
			</div>
			<hr>
			<?php endif; ?>
			<?php if($res->entrada != ''): ?>
			<div class="row">
				<div class="col-xs-12">
					<h4>Condições de pagamento</h4>
					<h5>Entrada: <?php echo $res->entrada; ?>% do valor, no ato da aprovação.</h5>
					<h5><?php echo $res->saldo; ?> dias após o término.</h5>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</body>
</html>
<?php
$html = ob_get_clean();
?>