
<link rel="stylesheet" type="text/css" href="<?php echo SITE ?>assets/datetimepicker/chung-timepicker.css">
<script type="text/javascript" src="<?php echo SITE ?>assets/datetimepicker/chung-timepicker.js"></script>
<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="<?php echo SITE ?>assets/js/vendor/summernote/lang-br.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<!-- arquivos -->
<script src="<?php echo SITE; ?>assets/js/vendor/filestyle/bootstrap-filestyle.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready( function () {
  //mascara digito 9
    var maskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = { onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    };

    $('.horario').chungTimePicker({
      viewType: 1
    });
    $('.valor').maskMoney({thousands:'', decimal:'.'});
    $('.horario').mask('99:99');

    $('#dataAgendamento').mask('99/99/9999');
    $('#dataPrazo').mask('99/99/9999');

    $('#dataAgendamentoEdit').mask('99/99/9999');
    $('#dataPrazoEdit').mask('99/99/9999');

    $('.summernote').summernote({
      height: 200,
      lang: 'pt-BR',
      toolbar: [
        ['style', ['bold', 'italic', 'underline']],
        ['font', ['strikethrough']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
      ]
    });

  $('#tabela').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "order": [[0, "desc"]],
    "ordering": true,
    "info": false,
    "responsive": true,
    "autoWidth": false,
    "pageLength": 50,
    "ajax": {
        "url": "<?php echo AJAX; ?>tarefas.php?acao=buscar&tipoUser="+<?php echo $_SESSION['nivelSession']; ?>+"&idRef="+<?php echo $_SESSION['idSession']; ?>,
        "type": "GET"
    },
    "language": {
      "url": "http://cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
    },
    "createdRow": function ( row, data, index ) {
      console.log(data['ativo']);
        if(data['ativo'] == 0){
          $(row).addClass('danger');
        }
      },
    "columns": [
      { "data": "id" },
      { "data": "tarefa" },
      { "data": "agendamento" },
      { "data": "prazo" },
      { "data": "responsavel" },
      { "data": "status" },
      { "data": "button" }
    ]
  });

      // adicionar unser
    $(document).on("click","#btnadd",function(){
        $("#modal_add").modal("show");
        $("#nome").focus();
    });

     $('#formCadastrar').validate({
      rules: {
        tarefa : { required: true},
        descricao : { required: true},
        dataAgendamento : { required: true},
        horarioAgendamento : { required: true},
        dataPrazo : { required: true},
        horarioPrazo : { required: true},
        responsavel : { required: true},
        status : { required: true},
      },
      messages: {
        tarefa : { required: 'Preencha este campo'},
        descricao : { required: 'Preencha este campo'},
        dataAgendamento : { required: 'Preencha este campo'},
        horarioAgendamento : { required: 'Preencha este campo'},
        dataPrazo : { required: 'Preencha este campo'},
        horarioPrazo : { required: 'Preencha este campo'},
        responsavel : { required: 'Preencha este campo'},
        status : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var tarefa = $("#tarefa").val();
        var dataAgendamento = $("#dataAgendamento").val();
        var horarioAgendamento = $("#horarioAgendamento").val();
        var dataPrazo = $("#dataPrazo").val();
        var horarioPrazo = $("#horarioPrazo").val();
        var responsavel = $("#responsavel").val();
        var contato1 = $("#contato1").val();
        var status = $("#status").val();
        var situacao = $("#situacao").val();
        var descricao = $("#descricao").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>tarefas.php",
          data: {'acao':'cadastrar', 'tarefa': tarefa, 'dataAgendamento': dataAgendamento, 'horarioAgendamento': horarioAgendamento, 'dataPrazo': dataPrazo, 'horarioPrazo': horarioPrazo, 'responsavel': responsavel, 'contato1': contato1, 'status': status, 'situacao': situacao , 'descricao': descricao },
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
             swal({   
                title: "Cadastrado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
                 });
               window.setTimeout(function(){
                   $('#formCadastrar input').val(""); 
                   swal.close();
                    var table = $('#tabela').DataTable(); 
                    table.ajax.reload( null, false );
                    $("#modal_add").modal("hide");
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
      }
    });
     //abrir modal pra edição
    $(document).on("click",".btnedit",function(){
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
          $("#tarefaEdit").val(data.tarefa);
          $("#dataAgendamentoEdit").val(data.dataAgendamento);
          $("#horarioAgendamentoEdit").val(data.horarioAgendamento);
          $("#dataPrazoEdit").val(data.dataPrazo);
          $("#horarioPrazoEdit").val(data.horarioPrazo);
          $("#responsavelEdit").val(data.responsavel);
          $("#contato1Edit").val(data.contato1);
          $("#statusEdit").val(data.status);
          $('#descricaoEdit').summernote('code', data.descricao);
          $('#situacaoEdit').summernote('code', data.situacao);
          $("#idUsuario").val(data.id);
          $("#moda_edit").modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });
    });

    $('#formCadastrarEdit').validate({
      rules: {
        tarefa : { required: true},
        descricao : { required: true},
        dataAgendamento : { required: true},
        horarioAgendamento : { required: true},
        dataPrazo : { required: true},
        horarioPrazo : { required: true},
        responsavel : { required: true},
        status : { required: true},
      },
      messages: {
        tarefa : { required: 'Preencha este campo'},
        descricao : { required: 'Preencha este campo'},
        dataAgendamento : { required: 'Preencha este campo'},
        horarioAgendamento : { required: 'Preencha este campo'},
        dataPrazo : { required: 'Preencha este campo'},
        horarioPrazo : { required: 'Preencha este campo'},
        responsavel : { required: 'Preencha este campo'},
        status : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var tarefa = $("#tarefaEdit").val();
        var dataAgendamento = $("#dataAgendamentoEdit").val();
        var horarioAgendamento = $("#horarioAgendamentoEdit").val();
        var dataPrazo = $("#dataPrazoEdit").val();
        var horarioPrazo = $("#horarioPrazoEdit").val();
        var responsavel = $("#responsavelEdit").val();
        var contato1 = $("#contato1Edit").val();
        var status = $("#statusEdit").val();
        var descricao = $("#descricaoEdit").val();
        var situacao = $("#situacaoEdit").val();
        var dataInicio = $("#dataInicioEdit").val();
        var horarioInicio = $("#horarioInicioEdit").val();
        var dataTerminio = $("#dataTerminioEdit").val();
        var horarioTerminio =$("#horarioTerminioEdit").val();
        var id = $("#idUsuario").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>tarefas.php",
          data: {'acao':'editar',  'tarefa': tarefa, 'dataAgendamento': dataAgendamento, 'horarioAgendamento': horarioAgendamento, 'dataPrazo': dataPrazo, 'horarioPrazo': horarioPrazo, 'responsavel': responsavel, 'contato1': contato1, 'status': status, 'situacao': situacao , 'descricao': descricao,'dataInicio': dataInicio, 'horarioInicio': horarioInicio, 'dataTerminio': dataTerminio, 'horarioTerminio': horarioTerminio, 'id': id},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
             swal({   
                title: "Alterado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
                 });
               window.setTimeout(function(){
                   $('#formCadastrarEdit input').val(""); 
                   swal.close();
                    location.reload();
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
      }
    });
    // inativar usuarios
     $(document).on( "click",".btndel", function() {
      var id_user = $(this).attr("id_user");
      var name = $(this).attr("nome_user");
      swal({   
        title: "Deletar",   
        text: "Deletar: "+name+" ?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Deletar",   
        closeOnConfirm: true}).then(function(){   
          $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>tarefas.php",
          data: {'acao':'deletar', 'id': id_user},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
             swal({   
                title: "Alterado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
                 });
               window.setTimeout(function(){ 
                   swal.close();
                    var table = $('#tabela').DataTable(); 
                    table.ajax.reload( null, false );
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
     // ativar usuarios
     $(document).on( "click",".btnativar", function() {
      var id_user = $(this).attr("id_user");
      var name = $(this).attr("nome_user");
      swal({   
        title: "Ativar",   
        text: "Ativar: "+name+" ?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Ativar",   
        closeOnConfirm: true}).then(function(){   
          $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>tarefas.php",
          data: {'acao':'ativar', 'id': id_user},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
             swal({   
                title: "Alterado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
                 });
               window.setTimeout(function(){ 
                   swal.close();
                    var table = $('#tabela').DataTable(); 
                    table.ajax.reload( null, false );
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

     $(document).on("click",".btnview",function(){
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
          $("#tarefaView").html(data.tarefa);
          $("#dataAgendamentoView").html(data.dataAgendamento);
          $("#horarioAgendamentoView").html(data.horarioAgendamento);
          $("#dataPrazoView").html(data.dataPrazo);
          $("#horarioPrazoView").html(data.horarioPrazo);
          $("#responsavelView").html(data.responsavelView);
          $("#contato1View").html(data.nomeContatoView+' - '+data.contatoView);
          $("#statusView").html(data.statusView);
          $('#descricaoView').html(data.descricao);
          $('#situacaoView').html(data.situacao);
          $('#dataInicioView').html(data.dataInicioView);
          $('#horarioInicioView').html(data.horarioInicioView);
          $('#dataTerminioView').html(data.dataTerminioView);
          $('#horarioTerminioView').html(data.horarioTerminioView);
          //$("#idUsuario").val(data.id);
          $("#moda_view").modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });
    });

     $(document).on("click",".btnprint",function(){
      var id_user = $(this).attr("id_user");
      window.open("<?php echo SITE;?>tarefas/imprimirpdf/"+id_user);
    });

     $('#statusEdit').change(function(){
        var status = $('#statusEdit').val();
        if(status == 7){
          $('#dataPrazoEdit').val('').attr("required", "true");
          $('#horarioPrazoEdit').val('').attr("required", "true");
        }
     });
 }); 

//despesas
  $(document).ready(function() {

    $(document).on("click",".btnlistdespesas",function(){
      var id_user = $(this).attr("id_user");
      $("#idUsuarioDespesa").val(id_user);
      buscarDespesas(id_user);
    });


    $(document).on("click","#btnadddespesa",function(){
        $("#modal_add_despesa").modal("show");
        $("#nome").focus();
    });


    $('#formCadastrarDespesa').on('submit', function(e){
        e.preventDefault();
        var form = e.target;
        var data = new FormData(form);
        $.ajax({
          url: form.action,
          method: form.method,
          processData: false,
          contentType: false,
          data: data,
          processData: false,
          success: function(data){
           swal({   
              title: "Adicionado com Sucesso",  
              type: "success",   
              showConfirmButton: false,
            });
             window.setTimeout(function(){ 
                swal.close();
                var tableDados = $('#tabelaDespesas').DataTable(); 
                tableDados.ajax.reload( null, false );
                $("#modal_add_despesa").modal("hide");
            } ,2500);
          }
        });
      });

    $(document).on( "click",".btndeldespesa", function() {
      var id_user = $(this).attr("id_user");
      var name = $(this).attr("nome_user");
      swal({   
        title: "Deletar",   
        text: "Deletar: "+name+" ?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Deletar",   
        closeOnConfirm: true}).then(function(){   
          $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>tarefas.php",
          data: {'acao':'deletarDespesa', 'id': id_user},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
             swal({   
                title: "Alterado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
              });
               window.setTimeout(function(){ 
                  swal.close();
                  var tableDados = $('#tabelaDespesas').DataTable(); 
                  tableDados.ajax.reload( null, false );
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

  function buscarDespesas(id) {

  var idOrigem = id;

  $('#tabelaDespesas').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": false,
    "responsive": true,
    "autoWidth": false,
    "pageLength": 10,
    "destroy": true,
    "ajax": {
        "url": "<?php echo AJAX; ?>tarefas.php?acao=buscarDespesas&idOrigem="+idOrigem,
        "type": "GET"
    },
    "language": {
      "url": "http://cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
    },
    "createdRow": function ( row, data, index ) {
      console.log(data['ativo']);
        if(data['ativo'] == 0){
          $(row).addClass('danger');
        }
      },
    "columns": [
      { "data": "id" },
      { "data": "despesa" },
      { "data": "valor" },
      { "data": "arquivo" },
      { "data": "dataCadastro" },
      { "data": "button" }
    ]
  });
  $("#moda_view_despesas_tabela").modal('show');
  } 

</script>

<section id="content">
  <div class="page col-md-12">   
    <section class="boxs">
      <div class="boxs-header">
        <h3 class="custom-font hb-cyan">
          <strong>Tarefas</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="mb20 col-sm-12 text-right">
          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar uma Tarefa</button>
        </div>
        <table id="tabela" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th width="7%">Cod</th>
                <th>Tarefa</th>
                <th>Agendamento</th>
                <th>Prazo</th>
                <th>Responsável</th>
                <th>Status</th>
                <th width="15%">Ações</th>
              </tr>
            </thead>
            <tbody>
              <!-- resultado -->
            </tbody>
          </table>
      </div>
    </section>
  </div>
</section>
    
<div id="modal_add" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Adicionar</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrar" autocomplete="off">
            <div class="form-group">
              <label>Tarefa</label>
              <input type="text" class="form-control" name="tarefa" id="tarefa">
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <textarea class="summernote" id="descricao" name="descricao"></textarea>
            </div>
            <div class="form-group">
              <label>Agendamento</label><br>
              <div class="col-md-6">
                <input type="text" class="form-control datepicker" id="dataAgendamento" placeholder="Data">
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control horario" id="horarioAgendamento" placeholder="Horario">
              </div>
            </div>
            <div class="form-group">
              <label>Prazo</label><br>
              <div class="col-md-6">
                <input type="text" class="form-control datepicker" id="dataPrazo" placeholder="Data">
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control horario" id="horarioPrazo" placeholder="Horario">
              </div>
            </div>
            <div class="form-group">
              <label>Responsável</label>
              <select tabindex="3" class="form-control" id="responsavel" name="responsavel">
                  <option value="">Selecione um Responsável</option>
                  <?php while($responsaval = mysqli_fetch_object($classe->resultado[0])): ?>
                    <option value="<?php echo $responsaval->id; ?>"><?php echo $responsaval->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Contato</label>
              <select tabindex="3" class="form-control" id="contato1" name="contato1">
                  <option value="">Selecione um Contato</option>
                  <?php while($contato = mysqli_fetch_object($classe->resultado[2])): ?>
                    <option value="<?php echo $contato->id; ?>"><?php echo $contato->nome." - ".$contato->contato1; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Situação</label>
              <textarea class="summernote" id="situacao" name="situacao"></textarea>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select tabindex="3" class="form-control" id="status" name="status">
                  <option value="">Selecione um Status</option>
                  <option value="1" selected>Aberto</option>
                  <option value="2">Iniciado</option>
                  <option value="3">Em andamento</option>
                  <option value="4">Em conclusão</option>
                  <option value="5">Finalizado</option>
                  <option value="6">Cancelado</option>
                  <option value="7">Pendente</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-raised  btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-raised  btn-primary">Cadastrar</button>
            </div>
           </form>
        </div>
          <!--modal footer-->
        </div>
        <!--modal-content-->
      </div>
      <!--modal-dialog modal-lg-->
    </div>


    <div id="moda_edit" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Editar</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrarEdit">
          <div class="form-group">
              <label>Tarefa</label>
              <input type="text" class="form-control" name="tarefa" id="tarefaEdit">
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <textarea class="summernote" id="descricaoEdit" name="descricaoEdit"></textarea>
            </div>
            <div class="form-group">
              <label>Agendamento</label><br>
              <div class="col-md-6">
                <input type="text" class="form-control datepicker" id="dataAgendamentoEdit" placeholder="Data">
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control horario" id="horarioAgendamentoEdit" placeholder="Horario">
              </div>
            </div>
            <div class="form-group">
              <label>Prazo</label><br>
              <div class="col-md-6">
                <input type="text" class="form-control datepicker" id="dataPrazoEdit" placeholder="Data">
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control horario" id="horarioPrazoEdit" placeholder="Horario">
              </div>
            </div>
            <div class="form-group">
              <label>Responsável</label>
              <select tabindex="3" class="form-control" id="responsavelEdit" name="responsavel">
                  <option value="">Selecione um Responsável</option>
                  <?php while($responsavalEdit = mysqli_fetch_object($classe->resultado[1])): ?>
                    <option value="<?php echo $responsavalEdit->id; ?>"><?php echo $responsavalEdit->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Contato</label>
              <select tabindex="3" class="form-control" id="contato1Edit" name="contato1">
                  <option value="">Selecione um Contato</option>
                  <?php while($contatoEdit = mysqli_fetch_object($classe->resultado[3])): ?>
                    <option value="<?php echo $contatoEdit->id; ?>"><?php echo $contatoEdit->nome." - ".$contatoEdit->contato1; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Situação</label>
              <textarea class="summernote" id="situacaoEdit" name="situacaoEdit"></textarea>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select tabindex="3" class="form-control" id="statusEdit" name="status">
                  <option value="">Selecione um Status</option>
                  <option value="1" selected>Aberto</option>
                  <option value="2">Iniciado</option>
                  <option value="3">Em andamento</option>
                  <option value="4">Em conclusão</option>
                  <option value="5">Finalizado</option>
                  <option value="6">Cancelado</option>
                  <option value="7">Pendente</option>
              </select>
            </div>
         <input type="hidden" name="idUsuario" id="idUsuario" value="">
        <div class="modal-footer">
          <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-raised btn-primary">Alterar</button>
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

    <div id="moda_view" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Visualizar</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrarEdit">
          <div class="form-group">
              <label>Tarefa</label>
              <p id="tarefaView"></p>
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <p id="descricaoView"></p>
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
              <label>Responsável</label>
              <p id="responsavelView"></p>
            </div>
            <div class="form-group">
              <label>Contato</label>
              <p id="contato1View"></p>
            </div>
            <div class="form-group">
              <label>Situação</label>
              <p id="situacaoView"></p>
            </div>
            <div class="form-group">
              <label>Status</label>
              <p id="statusView">
            </div>
        <div class="modal-footer">
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
  </div>



    <div id="moda_view_despesas_tabela" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Visualizar Arquivos</h4>
          </div>
          <!--modal header-->
          <div class="modal-body">
            <button type="submit" class="btn btn-raised  btn-primary " id="btnadddespesa" name="btnadddespesa"><i class="fa fa-plus"></i> Adicionar Despesa</button>
            <table id="tabelaDespesas" class="table table-striped table-bordered table-hover">
              <thead>
                <tr class="tableheader">
                  <th width="7%">Cod</th>
                  <th>Despesa</th>
                  <th>Valor</th>
                  <th>Arquivo</th>
                  <th>Data Cadastro</th>
                  <th width="15%">Ações</th>
                </tr>
              </thead>
              <tbody>
                <!-- resultado -->
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Fechar</button>
          </div>
          </div>
          <!--modal footer-->
        </div>
        <!--modal-content-->
      </div>

<div id="modal_add_despesa" class="modal fade">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Adicionar Despesa</h4>
      </div>
      <!--modal header-->
      <div class="modal-body">
        <form role="form" id="formCadastrarDespesa" action="<?php echo AJAX; ?>tarefas.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
              <label>Despesa</label>
              <select tabindex="3" class="form-control" id="despesaadd" name="despesaadd">
                  <option value="">Selecione uma Despesa</option>
                  <?php while($despesa = mysqli_fetch_object($classe->resultado[4])): ?>
                    <option value="<?php echo $despesa->id; ?>"><?php echo $despesa->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Descrisão</label>
              <input type="text" class="form-control" name="descrisaoDespesa" id="descrisaoDespesa">
            </div>
            <div class="form-group">
              <label>Valor</label>
              <input type="text" class="form-control valor" name="valorDespesa" id="valorDespesa">
            </div>  
          <div class="form-group row">
            <label class="col-sm-2 control-label">Arquivo</label>
            <div class="col-sm-10">
                <input type="file" class="filestyle" id="arquivoDespesa" name="arquivoDespesa" data-buttonText="Procurar Arquivo" data-iconName="fa fa-inbox">
            </div>
          </div>
          <input type="hidden" name="idUsuarioDespesa" id="idUsuarioDespesa" value="">
          <input type="hidden" name="acao" id="acao" value="addDespesa">
          <div class="modal-footer">
            <button type="button" class="btn btn-raised  btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-raised  btn-primary">Cadastrar</button>
          </div>
         </form>
      </div>
        <!--modal footer-->
      </div>
      <!--modal-content-->
    </div>
    <!--modal-dialog modal-lg-->
  </div>

<!-- fim -->
