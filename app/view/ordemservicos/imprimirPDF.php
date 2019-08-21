<?php
ob_start();
$con = condb();
$res = mysqli_fetch_object($this->resultado[0][0]);
print_r($res);
$sqlContato = mysqli_query($con, "SELECT * FROM `contatos` where idCliente = $res->idCliente and ativo = 1") or die(mysqli_error($con));
$contato = mysqli_fetch_object($sqlContato);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8" />

		<title>Imprimir OS</title>
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
			.italico {
              font-style: italic !important;
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
					<p><b>OS: <?php echo $res->id+1000; ?></b></p>
					<p>Agendado para:</p>
					<p><?php echo date("d/m/y", strtotime($res->dataAgendamento))." - ".$res->horarioAgendamento; ?></p>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-5 semmargemesquerda">
					<h5>Cliente</h5>
					<h6 class="marginh"><b><?php echo $res->nome; ?></b></h6>
					<h6 class="marginh"><?php echo $res->logadouro.', '.$res->numero.', '.$res->bairro; ?></h6>
					<h6 class="marginh"><?php echo $res->cidade." - ".$res->estado; ?></h6>
				</div>
				<div class="col-xs-4 semmargem">
					<h5>Contato</h5>
					<h6 class="marginh"><?php echo $contato->nome; ?></h6>
					<h6 class="marginh">✆ <?php echo $contato->contato1; ?></h6>
					<h6 class="marginh">✉ <?php echo $contato->email; ?></h6>
				</div>
				<div class="col-xs-2-do-chato semmargem">
					<h5>Responsável</h5>
					<h6 class="marginh"><?php echo $res->responsavel; ?></h6>
					<h6 class="marginh">✆ <?php echo $res->contatato1Responsavel; ?></h6>
					<h6 class="marginh">✉ <?php echo $res->emailResponsavel; ?></h6>
				</div>
			</div>
			<hr>
			<?php if($res->motivo != ''): ?>
			<div class="row">
				<div class="col-xs-12">
					<h5><b>Motivo</b></h5>
					<h5><?php echo $res->motivo; ?></h5>
				</div>
			</div>
			<?php endif; ?>
			<?php if($res->laudo != '' OR (isset($GLOBALS['url'][3]) && !empty($GLOBALS['url'][3])) ): ?>
			<div class="row">
				<div class="col-xs-12">
					<h5><b>Laudo Técnico</b></h5>
					<h5><?php 
							echo ($res->laudo == '')? '' : $res->laudo."<br>";
							if(isset($GLOBALS['url'][3]) && !empty($GLOBALS['url'][3]) ){
								while($anda = mysqli_fetch_object($this->resultado[0][1])){
									echo "<p>".date("d/m/Y", strtotime($anda->dataAndamento))." - Entrada: ".$anda->horaEntrada." - Saída: ".$anda->horaSaida."<br> <span class='italico'>".$anda->descricao."</span></p>";
								}
							}
						?></h5>
				</div>
			</div>
			<?php endif; ?>
			<?php if($res->obsCliente != ''): ?>
			<div class="row">
				<div class="col-xs-12">
					<h5><b>Observações do Cliente</b></h5>
					<h6><?php echo $res->obsCliente; ?></h6>
				</div>
			</div>
			<?php endif; ?>
			<?php if($res->observacoes != ''): ?>
			<div class="row">
				<div class="col-xs-12">
					<h5><b>Observações</b></h5>
					<h5><?php echo $res->observacoes; ?></h5>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</body>
</html>
<?php
$html = ob_get_clean();
?>