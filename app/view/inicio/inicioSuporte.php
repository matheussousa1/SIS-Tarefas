<link rel="stylesheet" href="<?php echo SITE; ?>assets/js/vendor/morris/morris.css"> 
<?php 
    $osCriadas = mysqli_fetch_object($classe->resultado[0][0]);
    $osAbertasAndamento = mysqli_fetch_object($classe->resultado[0][1]);
    $osConcluidas = mysqli_fetch_object($classe->resultado[0][2]);
    $osCanceladas = mysqli_fetch_object($classe->resultado[0][3]);

    $tarefasCriadas = mysqli_fetch_object($classe->resultado[0][4]);
    $tarefasAbertasAndamento = mysqli_fetch_object($classe->resultado[0][5]);
    $tarefasConcluidas = mysqli_fetch_object($classe->resultado[0][6]);
    $tarefasCanceladas = mysqli_fetch_object($classe->resultado[0][7]);
?>

	<!-- CONTENT -->
        <section id="content">
            <div class="page dashboard-page">
                <!-- bradcome -->
                <div class="b-b mb-20">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <h1 class="h3 m-0">Painel</h1>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                        <div class="boxs top_report_chart l-blue">
                            <div class="boxs-body">
                                <h3 class="mt-0"><?php echo $osCriadas->osCriadas; ?></h3>
                                <p>O.S criadas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                        <div class="boxs top_report_chart l-parpl">
                            <div class="boxs-body">
                                <h3 class="mt-0"><?php echo $osAbertasAndamento->osAbertasAndamento; ?></h3>
                                <p>O.S Abertas/Andamento</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                        <div class="boxs top_report_chart l-seagreen">
                            <div class="boxs-body">
                                <h3 class="mt-0"><?php echo $osConcluidas->osConcluidas; ?></h3>
                                <p>O.S concluídas </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                        <div class="boxs top_report_chart l-amber">
                            <div class="boxs-body">
                                <h3 class="mt-0"><?php echo $osCanceladas->osCanceladas; ?></h3>
                                <p>O.S Canceladas</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- terafas -->
                <div class="row clearfix">
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                        <div class="boxs top_report_chart l-blue">
                            <div class="boxs-body">
                                <h3 class="mt-0"><?php echo $tarefasCriadas->tarefasCriadas; ?></h3>
                                <p>Tarefas criadas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                        <div class="boxs top_report_chart l-parpl">
                            <div class="boxs-body">
                                <h3 class="mt-0"><?php echo $tarefasAbertasAndamento->tarefasAbertasAndamento; ?></h3>
                                <p>Tarefas Abertas/Andam</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                        <div class="boxs top_report_chart l-seagreen">
                            <div class="boxs-body">
                                <h3 class="mt-0"><?php echo $tarefasConcluidas->tarefasConcluidas; ?></h3>
                                <p>Tarefas concluídas </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                        <div class="boxs top_report_chart l-amber">
                            <div class="boxs-body">
                                <h3 class="mt-0"><?php echo $tarefasCanceladas->tarefasCanceladas; ?></h3>
                                <p>Tarefas canceladas  </p>
                            </div>
                        </div>
                    </div>
                </div>
               <!--  <div class="row clearfix">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <section class="boxs">
                            <div class="boxs-header">
                                <h3 class="custom-font hb-cyan">
                                    <strong>Resumo </strong>Mensal</h3>
                            </div>
                            <div class="boxs-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                                    <div class="text-muted">CLIENTES MÊS</div>
                                    <h2 class="text-warning mt-5">13</h2>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                                    <div class="text-muted">O.S. MÊS</div>
                                    <h2 class="text-warning mt-5">6741</h2>
                                    </div>
                                </div>
                                <div id="combined-chart" style="height: 290px"></div>
                            </div>
                        </section>
                    </div>
                </div> -->
            
            <!--     <div class="row clearfix hide">
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <section class="boxs">
                            <div class="boxs-header">
                                <h3 class="custom-font hb-green">
                                    <strong>Yearly </strong>Report</h3>
                                <ul class="controls">
                                    <li class="remove">
                                        <a role="button" tabindex="0" class="boxs-close">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="boxs-body">                                
                                <div class="boxs xl-parpl">
                                    <div class="boxs-body">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 col-xs-12 text-center mb-10">
                                                <h3 class="mt-10">518</h3>
                                                <span class="text-muted">Customers</span>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12 text-center mb-10">
                                                <h3 class="mt-10">36%</h3>
                                                <span class="text-muted">Target Achieved</span>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12 text-center mb-10">
                                                <h3 class="mt-10">23%</h3>
                                                <span class="text-muted">New Sales</span>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12 text-center mb-10">
                                                <h3 class="mt-10">46</h3>
                                                <span class="text-muted">New Customers</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="line-area-example" style="height: 230px;"></div>
                            </div>
                        </section>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12"> </div>
                </div>
                 -->
                
                <div class="row clearfix">
                    <div class="col-md-12">
                        <section class="boxs progress-report">
                            <div class="boxs-header">
                                <h3 class="custom-font hb-green">
                                    <strong>O.S. </strong>Processos</h3>
                                <ul class="controls">
                                    <li class="remove">
                                        <a role="button" tabindex="0" class="boxs-close">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="boxs-body table-custom">
                                <div class="table-responsive">
                                    <table class="table table-custom table-hover" id="project-progress">
                                        <thead>
                                            <tr>
                                                <th>O.S</th>
                                                <th>Cliente</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                while ($os = mysqli_fetch_object($classe->resultado[1])):
                                                    switch ($os->status) {
                                                        case 1:
                                                            $status = '<span class="label label-default">Aberto</span>';
                                                        break;
                                                        case 2:
                                                            $status = '<span class="label label-danger">Iniciado</span>';
                                                        break;
                                                        case 3:
                                                            $status = '<span class="label label-warning">Em andamento</span>';
                                                        break;
                                                        case 4:
                                                            $status = '<span class="label label-warning">Em conclusão</span>';
                                                        break;
                                                        case 5:
                                                            $status = '<span class="label label-success">Finalizado</span>';
                                                        break;
                                                        case 6:
                                                            $status = '<span class="label label-primary">Cancelado</span>';
                                                        break;
                                                        case 7:
                                                            $status = '<span class="label label-warning">Pendente</span>';
                                                        break;
                                                    }
                                            ?>
                                                <tr class="btnviewos" id_user="<?php echo $os->id; ?>">
                                                    <td><?php echo $os->id; ?></td>
                                                    <td><?php echo $os->cliente; ?></td>
                                                    <td><small class="text-danger"><?php echo $status; ?></small></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                 <div class="row clearfix">
                    <div class="col-md-12">
                        <section class="boxs progress-report">
                            <div class="boxs-header">
                                <h3 class="custom-font hb-green">
                                    <strong>Tarefas </strong>Processos</h3>
                                <ul class="controls">
                                    <li class="remove">
                                        <a role="button" tabindex="0" class="boxs-close">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="boxs-body table-custom">
                                <div class="table-responsive">
                                    <table class="table table-custom table-hover" id="project-progress">
                                        <thead>
                                            <tr>
                                                <th>Cod.</th>
                                                <th>Tarefa</th>
                                                <th>Responsável</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                while ($tarefa = mysqli_fetch_object($classe->resultado[2])):
                                                    switch ($tarefa->status) {
                                                        case 1:
                                                            $status = '<span class="label label-default">Aberto</span>';
                                                        break;
                                                        case 2:
                                                            $status = '<span class="label label-danger">Iniciado</span>';
                                                        break;
                                                        case 3:
                                                            $status = '<span class="label label-warning">Em andamento</span>';
                                                        break;
                                                        case 4:
                                                            $status = '<span class="label label-warning">Em conclusão</span>';
                                                        break;
                                                        case 5:
                                                            $status = '<span class="label label-success">Finalizado</span>';
                                                        break;
                                                        case 6:
                                                            $status = '<span class="label label-primary">Cancelado</span>';
                                                        break;
                                                        case 7:
                                                            $status = '<span class="label label-warning">Pendente</span>';
                                                        break;
                                                    }
                                            ?>
                                                <tr class="btnviewtarefa" id_user="<?php echo $tarefa->id; ?>">
                                                    <td><?php echo $tarefa->id; ?></td>
                                                    <td><?php echo $tarefa->tarefa; ?></td>
                                                    <td><?php echo $tarefa->responsavel; ?></td>
                                                    <td><small class="text-danger"><?php echo $status; ?></small></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
	<!--/ CONTENT --> 
         <div id="moda_view" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Visualizar Ordem de Serviço</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrarEdit">
          <div class="form-group">
              <label>Cliente</label>
              <p id="clienteView"></p>
            </div>
            <div class="form-group">
              <label>Motivo</label>
              <p id="motivoView"></p>
            </div>
            <div class="form-group">
              <label>Laudo</label>
              <p id="laudoView"></p>
            </div>
            <div class="form-group">
              <label>Observações</label>
              <p id="observacoesView"></p>
            </div>
            <div class="form-group">
              <label>Agendamento</label><br>
              <div class="col-md-6">
                <p id="dataAgendamentoView"></p>
              </div>
              <div class="col-md-6">
                <p id="horarioAgendamentoView"></p>
              </div>
            </div>
            <div class="form-group">
              <label>Prazo</label><br>
              <div class="col-md-6">
                <p id="dataPrazoView"></p>
              </div>
              <div class="col-md-6">
                <p id="horarioPrazoView"></p>
              </div>
            </div>
            <div class="form-group">
              <label>Inicío</label><br>
              <div class="col-md-6">
                <p id="dataInicioView"></p>
              </div>
              <div class="col-md-6">
                <p id="horarioInicioView"></p>
              </div>
            </div>
            <div class="form-group">
              <label>Termínio</label><br>
              <div class="col-md-6">
                <p id="dataTerminioView"></p>
              </div>
              <div class="col-md-6">
                <p id="horarioTerminioView"></p>
              </div>
            </div>
            <div class="form-group">
              <label>Status</label>
              <p id="statusView">
            </div>
        <div class="modal-footer">
            <a href="" class="btn btn-raised btn-primary" id="linkordem">Pegar O.S</a>
          <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </form>
          </div>
          <!--modal footer-->
        </div>
        <!--modal-content-->
      </div>
      <!--modal-dialog modal-lg-->
    </div>
    <!--form-kantor-modal-->

   <div id="moda_view_tarefa" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Visualizar Tarefa</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrarEdit">
          <div class="form-group">
              <label>Tarefa</label>
              <p id="tarefaViewTarefa"></p>
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <p id="descricaoViewTarefa"></p>
            </div>
            <div class="form-group">
              <label>Agendamento</label><br>
              <div class="col-md-6">
                <p id="dataAgendamentoViewTarefa"></p>
              </div>
              <div class="col-md-6">
                <p id="horarioAgendamentoViewTarefa"></p>
              </div>
            </div>
            <div class="form-group">
              <label>Prazo</label><br>
              <div class="col-md-6">
                <p id="dataPrazoViewTarefa"></p>
              </div>
              <div class="col-md-6">
                <p id="horarioPrazoViewTarefa"></p>
              </div>
            </div>
            <div class="form-group">
              <label>Inicío</label><br>
              <div class="col-md-6">
                <p id="dataInicioViewTarefa"></p>
              </div>
              <div class="col-md-6">
                <p id="horarioInicioViewTarefa"></p>
              </div>
            </div>
            <div class="form-group">
              <label>Termínio</label><br>
              <div class="col-md-6">
                <p id="dataTerminioViewTarefa"></p>
              </div>
              <div class="col-md-6">
                <p id="horarioTerminioViewTarefa"></p>
              </div>
            </div>
            <div class="form-group">
              <label>Responsável</label>
              <p id="responsavelViewTarefa"></p>
            </div>
            <div class="form-group">
              <label>Contato</label>
              <p id="contato1ViewTarefa"></p>
            </div>
            <div class="form-group">
              <label>Situação</label>
              <p id="situacaoViewTarefa"></p>
            </div>
            <div class="form-group">
              <label>Status</label>
              <p id="statusViewTarefa">
            </div>
        <div class="modal-footer">
            <a href="" class="btn btn-raised btn-primary" id="linktarefa">Pegar Tarefa</a>
          <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </form>
          </div>
          <!--modal footer-->
        </div>
        <!--modal-content-->
      </div>
      <!--modal-dialog modal-lg-->
    </div>
    <!--form-kantor-modal-->
<script type="text/javascript">
    $(document).ready( function () {
      //abrir modal pra edição
        $(document).on("click",".btnviewos",function(){
          var id_user = $(this).attr("id_user");
          var value = {
            id: id_user
          };
          $.ajax({
            url : "<?php echo AJAX; ?>ordemservicos.php?acao=buscarDados",
            type: "GET",
            data : value,
            success: function(data, textStatus, jqXHR)
            {
              var data = jQuery.parseJSON(data);
              $("#clienteView").html(data.clienteView);
              $('#motivoView').html(data.motivo);
              $('#laudoView').html(data.laudo);       
              $("#dataAgendamentoView").html(data.dataAgendamento);
              $("#horarioAgendamentoView").html(data.horarioAgendamento);
              $("#dataPrazoView").html(data.dataPrazo);
              $("#horarioPrazoView").html(data.horarioPrazo);
              $("#observacoesView").html(data.observacoes);
              $("#statusView").html(data.statusView);
              $('#dataInicioView').html(data.dataInicioView);
              $('#horarioInicioView').html(data.horarioInicioView);
              $('#dataTerminioView').html(data.dataTerminioView);
              $('#horarioTerminioView').html(data.horarioTerminioView);
              $('#linkordem').attr('href', '<?php echo SITE.'ordemservicos/os/';?>'+data.id+'');
              //$("#idUsuario").val(data.id);
              $("#moda_view").modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
              swal("Error!", textStatus, "error");
            }
          });
        });

        $(document).on("click",".btnviewtarefa",function(){
          var id_user = $(this).attr("id_user");
          var value = {
            id: id_user
          };
          $.ajax({
            url : "<?php echo AJAX; ?>tarefas.php?acao=buscarDados",
            type: "GET",
            data : value,
            success: function(data, textStatus, jqXHR)
            {
              var data = jQuery.parseJSON(data);
              $("#tarefaViewTarefa").html(data.tarefa);
              $("#dataAgendamentoViewTarefa").html(data.dataAgendamento);
              $("#horarioAgendamentoViewTarefa").html(data.horarioAgendamento);
              $("#dataPrazoViewTarefa").html(data.dataPrazo);
              $("#horarioPrazoViewTarefa").html(data.horarioPrazo);
              $("#responsavelViewTarefa").html(data.responsavelView);
              $("#contato1ViewTarefa").html(data.nomeContatoView+' - '+data.contatoView);
              $("#statusViewTarefa").html(data.statusView);
              $('#descricaoViewTarefa').html(data.descricao);
              $('#situacaoViewTarefa').html(data.situacao);
              $('#dataInicioViewTarefa').html(data.dataInicioView);
              $('#horarioInicioViewTarefa').html(data.horarioInicioView);
              $('#dataTerminioViewTarefa').html(data.dataTerminioView);
              $('#horarioTerminioViewTarefa').html(data.horarioTerminioView);
              $('#linkordem').attr('href', '<?php echo SITE.'tarefas/tarefa/';?>'+data.id+'');
              //$("#idUsuario").val(data.id);
              $("#moda_view_tarefa").modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
              swal("Error!", textStatus, "error");
            }
          });
        });
    });
</script>
<script src="<?php echo SITE; ?>assets/bundles/flotscripts.bundle.js"></script>    
<script src="<?php echo SITE; ?>assets/bundles/d3cripts.bundle.js"></script>
<script src="<?php echo SITE; ?>assets/bundles/sparkline.bundle.js"></script>
<script src="<?php echo SITE; ?>assets/bundles/raphael.bundle.js"></script>
<script src="<?php echo SITE; ?>assets/bundles/morris.bundle.js"></script>
<script src="<?php echo SITE; ?>assets/bundles/loadercripts.bundle.js"></script>
<script src="<?php echo SITE; ?>assets/js/page/index.js"></script> 