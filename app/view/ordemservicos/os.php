<?php
    $res = mysqli_fetch_object($classe->resultado[0]);
    switch ($res->status) {
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
<script type="text/javascript">
$(document).ready( function () {

  verificarcheckin();

   $(document).on( "click","#checkin", function() {
      var idRef = <?php echo $idRef; ?>;
      var idOS = <?php echo $res->id ?>;
      swal({   
        title: "Iniciar",      
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Iniciar",   
        closeOnConfirm: true}).then(function(){   
          $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>ordemservicos.php",
          data: {'acao':'checkin', 'idOS': idOS, 'idRef': idRef},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
             swal({   
                title: "Iniciado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
                 });
               window.setTimeout(function(){ 
                   swal.close();
                   $('#espcheckout').removeClass('hide');
                   $('#espstatus').removeClass('hide');
                   $('#espcheckin').addClass('hide');
              } ,2500);
            }else{
              swal({   
                  title: "Error",  
                  type: "error",   
                  showConfirmButton: false,
                   });
                 window.setTimeout(function(){
                     swal.close();
                } ,2500);
            }
          }
        });
        return false;
      });
    });

   $(document).on( "click","#checkout", function() {
      var idRef = <?php echo $idRef; ?>;
      var idOS = <?php echo $res->id ?>;
      var status = $('#statusos').val();
      swal({   
        title: "Termina",      
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Termina",   
        closeOnConfirm: true}).then(function(){   
          $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>ordemservicos.php",
          data: {'acao':'checkout', 'idOS': idOS, 'idRef': idRef, 'status': status},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
             swal({   
                title: "Iniciado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
                 });
               window.setTimeout(function(){ 
                   swal.close();
                   $('#espcheckout').addClass('hide');
                   $('#espstatus').addClass('hide');
                   $('#espcheckin').addClass('hide');
              } ,2500);
            }else{
              swal({   
                  title: "Error",  
                  type: "error",   
                  showConfirmButton: false,
                   });
                 window.setTimeout(function(){
                     swal.close();
                } ,2500);
            }
          }
        });
        return false;
      });
    });

});

function verificarcheckin(){
  var inicio = <?php echo ($res->inicio == "0000-00-00 00:00:00")? 0 : 1; ?>;
  var terminio = <?php echo ($res->terminio == "0000-00-00 00:00:00")? 0 : 1; ?>;
  if(inicio == 0){
    $('#espcheckout').addClass('hide');
    $('#espstatus').addClass('hide');
  }else{
    $('#espcheckin').addClass('hide');
  }
  if(inicio == 1 && terminio == 1){
    $('#espcheckout').addClass('hide');
    $('#espstatus').addClass('hide');
    $('#espcheckin').addClass('hide');
  }
}
</script>

<section id="content">
  <div class="page col-md-6">   
    <section class="boxs">
      <div class="boxs-header">
        <h3 class="custom-font hb-cyan">
          <strong>Detalhes da O.S</strong></h3>
      </div>
      <div class="boxs-body">
        <form role="form">
            <div class="form-group is-empty">
              <label>Cliente</label>
              <h4><?php echo $res->clienteView; ?></h4>
            </div>
            <div class="form-group">
              <label>Motivo</label>
              <h4><?php echo $res->motivo; ?></h4>
            </div>
            <div class="form-group">
              <label>Laudo</label>
              <h4><?php echo $res->laudo; ?></h4>
            </div>
             <div class="form-group">
              <label>Observações</label>
              <h4><?php echo $res->observacoes; ?></h4>
            </div>
            <div class="form-group">
              <label>Agendamento</label><br>
              <div class="col-md-3">
                <h4><?php echo date("d/m/Y", strtotime($res->dataAgendamento)); ?></h4>
              </div>
              <div class="col-md-9">
                <h4><?php echo $res->horarioAgendamento; ?></h4>
              </div>
            </div>
            <div class="form-group">
              <label>Prazo</label><br>
              <div class="col-md-3">
                <h4><?php echo date("d/m/Y", strtotime($res->dataPrazo)); ?></h4>
              </div>
              <div class="col-md-9">
                <h4><?php echo $res->horarioPrazo; ?></h4>
              </div>
            </div>
             <div class="form-group">
              <label>Inicío</label><br>
              <div class="col-md-3">
                <h4 id="dataInicioView"><?php echo ($res->inicio == "0000-00-00 00:00:00")? 'Não definido' : date("d/m/Y", strtotime($res->inicio)); ?></h4>
              </div>
              <div class="col-md-9">
                <h4 id="horarioInicioView"><?php echo date("H:i:s", strtotime($res->inicio)); ?></h4>
              </div>
            </div>
            <div class="form-group">
              <label>Termínio</label><br>
              <div class="col-md-3">
                <h4 id="dataTerminioView"><?php echo ($res->terminio == "0000-00-00 00:00:00")? 'Não definido' : date("d/m/Y", strtotime($res->terminio)); ?></h4>
              </div>
              <div class="col-md-9">
                <h4 id="horarioTerminioView"><?php echo date("H:i:s", strtotime($res->terminio)); ?></h4>
              </div>
            </div>
            <div class="form-group">
              <label>Status</label>
              <h4><?php echo $status; ?></h4>
            </div>
        </form> 
      </div>
    </section>
  </div>
   <div class="page col-md-6">   
    <section class="boxs">
      <div class="boxs-header">
        <h3 class="custom-font hb-green">
          <strong>Iniciar O.S</strong></h3>
      </div>
      <div class="boxs-body">
        <form role="form">
          <div class="form-group" id="espcheckin">
              <label>Iniciar O.S</label>
              <p><button class="btn btn-raised btn-primary" type="button" id="checkin">Check-in</button></p>
          </div>
          <div class="form-group" id="espstatus">
            <label>Status</label>
            <select tabindex="3" class="form-control" id="statusos" name="status">
                <option value="">Selecione um Status</option>
                <option value="1">Aberto</option>
                <option value="2" selected>Iniciado</option>
                <option value="3">Em andamento</option>
                <option value="4">Em conclusão</option>
                <option value="5">Finalizado</option>
                <option value="6">Cancelado</option>
                <option value="7">Pendente</option>
            </select>
          </div>
           <div class="form-group" id="espcheckout">
              <label>Terminar O.S</label>
              <p><button class="btn btn-raised btn-success" type="button" id="checkout">Check-out</button></p>
          </div>
          <a href="<?php echo SITE.'inicio/inicio'; ?>" class="btn btn-raised btn-success">Voltar</a>
        </form> 
      </div>
    </section>
  </div>
</section>
        <!--form-kantor-modal-->
  </div>
