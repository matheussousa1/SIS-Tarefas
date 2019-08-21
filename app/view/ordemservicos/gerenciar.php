
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

    $('.horario').mask('99:99');

    $('#dataAgendamento').mask('99/99/9999');
    $('#dataPrazo').mask('99/99/9999');
    $('#contato1').mask(maskBehavior, options);

    $('#dataAgendamentoEdit').mask('99/99/9999');
    $('#dataPrazoEdit').mask('99/99/9999');
    $('#contato1Edit').mask(maskBehavior, options);

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

    $('.valor').maskMoney({thousands:'', decimal:'.'});

  // ativar o tooltip
  $('body').tooltip({selector: '[data-toggle="tooltip"]'});

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
        "url": "<?php echo AJAX; ?>ordemservicos.php?acao=buscar",
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
      { "data": "cliente" },
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
        cliente : { required: true},
        motivo : { required: true},
        dataAgendamento : { required: true},
      },
      messages: {
        cliente : { required: 'Preencha este campo'},
        motivo : { required: 'Preencha este campo'},
        dataAgendamento : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var cliente = $("#cliente").val();
        var motivo = $("#motivo").val();
        var laudo = $("#laudo").val();
        var dataAgendamento = $("#dataAgendamento").val();
        var horarioAgendamento = $("#horarioAgendamento").val();
        var dataPrazo = $("#dataPrazo").val();
        var horarioPrazo = $("#horarioPrazo").val();
        var responsavel = $("#responsavel").val();
        var valorProduto = $("#valorProduto").val();
        var valorMaoObra = $("#valorMaoObra").val();
        var valorAdicional = $("#valorAdicional").val();
        var observacoes = $("#observacoes").val();
        var status = $("#status").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>ordemservicos.php",
          data: {'acao':'cadastrar', 'cliente': cliente, 'motivo': motivo, 'laudo': laudo, 'dataAgendamento': dataAgendamento, 'horarioAgendamento': horarioAgendamento, 'dataPrazo': dataPrazo, 'horarioPrazo': horarioPrazo, 'responsavel': responsavel, 'valorProduto': valorProduto, 'valorMaoObra': valorMaoObra, 'valorAdicional': valorAdicional, 'observacoes': observacoes, 'status': status  },
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
        url : "<?php echo AJAX; ?>ordemservicos.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#clienteEdit").val(data.cliente);
          $('#motivoEdit').summernote('code', data.motivo);
          $('#laudoEdit').summernote('code', data.laudo);       
          $("#dataAgendamentoEdit").val(data.dataAgendamento);
          $("#horarioAgendamentoEdit").val(data.horarioAgendamento);
          $("#dataPrazoEdit").val(data.dataPrazo);
          $("#horarioPrazoEdit").val(data.horarioPrazo);
          $("#responsavelEdit").val(data.responsavel);
          $("#valorProdutoEdit").val(data.valorProduto);
          $("#valorMaoObraEdit").val(data.valorMaoObra);
          $("#valorAdicionalEdit").val(data.valorAdicional);
          $("#observacoesEdit").summernote('code', data.observacoes);
          $("#statusEdit").val(data.status);
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
        cliente : { required: true},
        motivo : { required: true},
        dataAgendamento : { required: true},
      },
      messages: {
        cliente : { required: 'Preencha este campo'},
        motivo : { required: 'Preencha este campo'},
        dataAgendamento : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var cliente = $("#clienteEdit").val();
        var motivo = $("#motivoEdit").val();
        var laudo = $("#laudoEdit").val();
        var dataAgendamento = $("#dataAgendamentoEdit").val();
        var horarioAgendamento = $("#horarioAgendamentoEdit").val();
        var dataPrazo = $("#dataPrazoEdit").val();
        var horarioPrazo = $("#horarioPrazoEdit").val();
        var responsavel = $("#responsavelEdit").val();
        var valorProduto = $("#valorProdutoEdit").val();
        var valorMaoObra = $("#valorMaoObraEdit").val();
        var valorAdicional = $("#valorAdicionalEdit").val();
        var observacoes = $("#observacoesEdit").val();
        var status = $("#statusEdit").val();
        var id = $("#idUsuario").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>ordemservicos.php",
          data: {'acao':'editar',  'cliente': cliente, 'motivo': motivo, 'laudo': laudo, 'dataAgendamento': dataAgendamento, 'horarioAgendamento': horarioAgendamento, 'dataPrazo': dataPrazo, 'horarioPrazo': horarioPrazo, 'responsavel': responsavel, 'valorProduto': valorProduto, 'valorMaoObra': valorMaoObra, 'valorAdicional': valorAdicional, 'observacoes': observacoes, 'status': status, 'id': id},
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
          url: "<?php echo AJAX; ?>ordemservicos.php",
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
          url: "<?php echo AJAX; ?>ordemservicos.php",
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

      // calculo valor total
     $(".soma").keyup(function(){ 
      var valorProduto = $('#valorProduto').val();
      var valorMaoObra = $('#valorMaoObra').val();
      if($(this).length >= 1){
        var valorTotal = parseFloat(valorProduto) + parseFloat(valorMaoObra);
        $('#valorAdicional').val(valorTotal);
      }else{
        $('#valorAdicional').html('');
      } 
    });

     $(".somaEdit").keyup(function(){ 
      var valorProduto = $('#valorProdutoEdit').val();
      var valorMaoObra = $('#valorMaoObraEdit').val();
      if($(this).length >= 1){
        var valorTotal = parseFloat(valorProduto) + parseFloat(valorMaoObra);
        $('#valorAdicionalEdit').val(valorTotal);
      }else{
        $('#valorAdicionalEdit').html('');
      } 
    });

      //abrir modal pra edição
    $(document).on("click",".btnview",function(){
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
          $("#responsavelView").html(data.responsavelView);
          $("#valorProdutoView").html(data.valorProduto);
          $("#valorMaoObraView").html(data.valorMaoObra);
          $("#valorAdicionalView").html(data.valorAdicional);
          $("#observacoesView").html(data.observacoes);
          $("#statusView").html(data.statusView);
          $('#dataInicioView').html(data.dataInicioView);
          $('#horarioInicioView').html(data.horarioInicioView);
          $('#dataTerminioView').html(data.dataTerminioView);
          $('#horarioTerminioView').html(data.horarioTerminioView);
          listarandamentos(data.id);
          $('#btnImprimir').html('<a href="<?php echo SITE.'ordemservicos/imprimirpdf/';?>'+data.id+'" class="btn btn-raised btn-default" target="_blank"><i class="fa fa-print"></i> PDF</a>');
          //$("#idUsuario").val(data.id);
          $("#moda_view").modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });
    });

    // andamento
      //abrir modal pra edição
    $(document).on("click",".btnplus",function(){
      var id_user = $(this).attr("id_user");
      var status = $(this).attr("status");
      $("#idUsuarioPlus").val(id_user);
      $("#statusAndamento").val(status);
      $("#moda_plus").modal('show');
    });



    $('#formCadastrarAnda').validate({
      rules: {
        observacoesAnda : { required: true},
        dataAnda : { required: true},
        statusAndamento : { required: true},
        membro : { required: true},
      },
      messages: {
        observacoesAnda : { required: 'Preencha este campo'},
        dataAnda : { required: 'Preencha este campo'},
        statusAndamento : { required: 'Preencha este campo'},
        membro : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var observacoesAnda = $("#observacoesAnda").val();
        var dataAnda = $("#dataAnda").val();
        var statusAndamento = $("#statusAndamento").val();
        var horarioAndaEntrada = $("#horarioAndaEntrada").val();
        var horarioAndaSaida = $("#horarioAndaSaida").val();
        var id = $("#idUsuarioPlus").val();
        var idRef = $("#membro").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>ordemservicos.php",
          data: {'acao':'adicionarAndamento',  'observacoesAnda': observacoesAnda,'dataAnda': dataAnda, 'id': id, 'idRef': idRef, 'statusAndamento': statusAndamento, 'horarioAndaEntrada': horarioAndaEntrada,'horarioAndaSaida': horarioAndaSaida},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
             swal({   
                title: "Adicionado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
                 });
               window.setTimeout(function(){
                   $('#formCadastrarAnda input').val(""); 
                   swal.close();
                    var table = $('#tabela').DataTable(); 
                    table.ajax.reload( null, false );
                    $("#moda_plus").modal("hide");
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

    // editar andamento

    $(document).on("click",".btneditandamento",function(){
      var id_user = $(this).attr("id_user");
      var value = {
        id: id_user
      };
      $.ajax({
        url : "<?php echo AJAX; ?>ordemservicos.php?acao=buscarEditAndamentoOs",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#observacoesAndaEdit").summernote('code', data.descricao);
          $("#dataAndaEdit").val(data.dataAndamento);
          $("#statusAndamentoEdit").val(data.status);
          $("#horarioAndaEntradaEdit").val(data.horaEntrada);
          $("#horarioAndaSaidaEdit").val(data.horaSaida);
          $("#membroEdit").val(data.idRef);
          $("#idEditAndamento").val(data.id);
          $("#moda_plus_edit").modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });
    });

    $('#formAlterarAnda').validate({
      rules: {
        observacoesAnda : { required: true},
        dataAnda : { required: true},
        statusAndamento : { required: true},
        membro : { required: true},
      },
      messages: {
        observacoesAnda : { required: 'Preencha este campo'},
        dataAnda : { required: 'Preencha este campo'},
        statusAndamento : { required: 'Preencha este campo'},
        membro : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var observacoesAnda = $("#observacoesAndaEdit").val();
        var dataAnda = $("#dataAndaEdit").val();
        var statusAndamentoEdit = $("#statusAndamentoEdit").val();
        var horarioAndaEntradaEdit = $("#horarioAndaEntradaEdit").val();
        var horarioAndaSaidaEdit = $("#horarioAndaSaidaEdit").val();
        var membroEdit = $("#membroEdit").val();
        var id = $("#idEditAndamento").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>ordemservicos.php",
          data: {'acao':'alterarAndamento', 'observacoesAnda': observacoesAnda,'dataAnda': dataAnda, 'id': id, 'statusAndamentoEdit': statusAndamentoEdit, 'horarioAndaEntradaEdit': horarioAndaEntradaEdit, 'horarioAndaSaidaEdit': horarioAndaSaidaEdit, 'membroEdit': membroEdit},
          dataType: 'json',
          success: function(res) {
            if(res.status == 200){
             swal({   
                title: "Adicionado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
                 });
               window.setTimeout(function(){
                   $('#formAlterarAnda input').val(""); 
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

    $(document).on("click","#btnAddMembro",function(){
      var id_user = $(this).attr("id_user");
    });

    // print
    $(document).on("click",".btnprint",function(){
      var id_user = $(this).attr("id_user");
      window.open("<?php echo SITE;?>ordemservicos/imprimirpdf/"+id_user);
    });

    $(document).on("click",".btnprint2",function(){
      var id_user = $(this).attr("id_user");
      window.open("<?php echo SITE;?>ordemservicos/imprimirpdf/"+id_user+"/1");
    });

    
    $('#statusEdit').change(function(){
        var status = $('#statusEdit').val();
        if(status == 7){
          $('#dataPrazoEdit').val('').attr("required", "true");
          $('#horarioPrazoEdit').val('').attr("required", "true");
        }
     });

 });  

function listarandamentos(id){
  var id_user = id;
      var value = {
        id: id_user
      };
  $.ajax({
        url : "<?php echo AJAX; ?>ordemservicos.php?acao=buscarAndamentoOs",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          var items = [];
          $.each(data, function(conta, valor) {
            items.push(
              ' <li class="media btneditandamento" id_user="'+valor.id+'">'+
                    '<div class="media-img"><i class="fa fa-info-circle"></i></div>'+
                    '<div class="media-body">'+
                      '<small><i class="fa fa-user"></i> '+valor.usuario+'</small>'+
                      '<hr>'+
                      '<small>'+valor.descricao+'</small>'+
                    '</div>'+
                  '</li> '
            );
          });
          $('#andamentoView').html(items.join(''));
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });

}

  // arquivos

  $(document).ready(function() {

    $(document).on("click",".btnlistarquivos",function(){
      var id_user = $(this).attr("id_user");
      $("#idUsuarioArquivo").val(id_user);
      buscarArquivosCliente(id_user);
    });


    $(document).on("click","#btnaddarquivo",function(){
        $("#modal_add_arquivo").modal("show");
        $("#nome").focus();
    });


    $('#formCadastrarArquivo').on('submit', function(e){
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
                var tableDados = $('#tabelaArquivos').DataTable(); 
                tableDados.ajax.reload( null, false );
                $("#modal_add_arquivo").modal("hide");
            } ,2500);
          }
        });
      });

    $(document).on( "click",".btndelarquivo", function() {
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
          url: "<?php echo AJAX; ?>ordemservicos.php",
          data: {'acao':'deletarArquivo', 'id': id_user},
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
                  var tableDados = $('#tabelaArquivos').DataTable(); 
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

  function buscarArquivosCliente(id) {

  var idCliente = id;

  $('#tabelaArquivos').DataTable({
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
        "url": "<?php echo AJAX; ?>ordemservicos.php?acao=buscarArquivos&idCliente="+idCliente,
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
      { "data": "nome" },
      { "data": "arquivo" },
      { "data": "dataCadastro" },
      { "data": "button" }
    ]
  });
  $("#moda_view_arquivos_tabela").modal('show');
  } 

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
          url: "<?php echo AJAX; ?>ordemservicos.php",
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
                  var tableDadosDespesas = $('#tabelaDespesas').DataTable(); 
                  tableDadosDespesas.ajax.reload( null, false );
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
        "url": "<?php echo AJAX; ?>ordemservicos.php?acao=buscarDespesas&idOrigem="+idOrigem,
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
          <strong>Ordem de Serviços</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="mb20 col-sm-12 text-right">
          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar uma Ordem</button>
        </div>
        <table id="tabela" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th width="7%">O.S.</th>
                <th>Cliente</th>
                <th>Agendamento</th>
                <th>Prazo</th>
                <th>Responsável</th>
                <th>Status</th>
                <th width="23%">Ações</th>
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
              <label>Cliente</label>
              <select tabindex="3" class="form-control" id="cliente" name="cliente">
                  <option value="">Selecione um Cliente</option>
                  <?php while($cliente = mysqli_fetch_object($classe->resultado[0])): ?>
                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Motivo</label>
              <textarea class="summernote" id="motivo" name="motivo"></textarea>
            </div>
          <?php if($_SESSION['nivelSession'] == 1): ?>
            <div class="form-group">
              <label>Laudo</label>
              <textarea class="summernote" id="laudo" name="laudo"></textarea>
            </div>
          <?php endif; ?>
             <div class="form-group">
              <label>Observações</label>
              <textarea class="summernote" id="observacoes" name="observacoes"></textarea>
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
                  <?php while($responsaval = mysqli_fetch_object($classe->resultado[1])): ?>
                    <option value="<?php echo $responsaval->id; ?>"><?php echo $responsaval->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
                <label>Valor Produtos</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control valor soma" style="display: block;" id="valorProduto" name="valorProduto">
                </div>
            </div>
            <div class="form-group">
                <label>Valor Mão de Obra</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control valor soma" style="display: block;" id="valorMaoObra" name="valorMaoObra">
                </div>
            </div>
            <div class="form-group">
                <label>Valor Total</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control" style="display: block;" id="valorAdicional" name="valorAdicional" readonly="readonly">
                </div>
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
              <label>Cliente</label>
              <select tabindex="3" class="form-control" id="clienteEdit" name="cliente">
                  <option value="">Selecione um Cliente</option>
                  <?php while($clienteEdit = mysqli_fetch_object($classe->resultado[2])): ?>
                    <option value="<?php echo $clienteEdit->id; ?>"><?php echo $clienteEdit->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Motivo</label>
              <textarea class="summernote" id="motivoEdit" name="motivo"></textarea>
            </div>
            <?php if($_SESSION['nivelSession'] == 1): ?>
            <div class="form-group">
              <label>Laudo</label>
              <textarea class="summernote" id="laudoEdit" name="laudo"></textarea>
            </div>
            <?php endif; ?>
            <div class="form-group">
              <label>Observações</label>
              <textarea class="summernote" id="observacoesEdit" name="observacoes"></textarea>
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
                  <?php while($responsavalEdit = mysqli_fetch_object($classe->resultado[3])): ?>
                    <option value="<?php echo $responsavalEdit->id; ?>"><?php echo $responsavalEdit->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
                <label>Valor Produtos</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control valor somaEdit" style="display: block;" id="valorProdutoEdit" name="valorProduto">
                </div>
            </div>
            <div class="form-group">
                <label>Valor Mão de Obra</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control valo somaEdit" style="display: block;" id="valorMaoObraEdit" name="valorMaoObra">
                </div>
            </div>
            <div class="form-group">
                <label>Valor Total</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control" style="display: block;" id="valorAdicionalEdit" name="valorAdicional" readonly="readonly">
                </div>
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
          <form role="form" id="formCadastrarEditrew">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Impressões</label><br>
                  <span id="btnImprimir"></span>
                </div>
                <div class="form-group">
              <label>Cliente</label>
              <p id="clienteView"></p>
            </div>
            <div class="form-group">
              <label>Motivo</label>
              <p id="motivoView"></p>
            </div>
          <?php if($_SESSION['nivelSession'] == 1): ?>
            <div class="form-group">
              <label>Laudo</label>
              <p id="laudoView"></p>
            </div>
          <?php endif; ?>
            <div class="form-group">
              <label>Andamento</label>
              <ul class="media-list feeds_widget m-0" id="andamentoView">
                                  
              </ul>
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
              <label>Responsável</label>
              <p id="responsavelView"></p>
            </div>
            <div class="form-group">
                <label>Valor Produtos</label>
                <div class="input-group bootstrap-touchspin">
                    <span>R$ </span>
                    <span id="valorProdutoView"></span>
                </div>
            </div>
            <div class="form-group">
                <label>Valor Mão de Obra</label>
                <div class="input-group bootstrap-touchspin">
                    <span>R$ </span>
                    <span id="valorMaoObraView"></span>
                </div>
            </div>
            <div class="form-group">
                <label>Valor Total</label>
                <div class="input-group bootstrap-touchspin">
                    <span>R$ </span>
                    <span id="valorAdicionalView"></span>
                </div>
            </div>
            <div class="form-group">
              <label>Status</label>
              <p id="statusView"></p>
            </div>
              </div>
          <div class="col-md-6">
            
          </div>
          <div class="col-md-12">
            <div class="modal-footer">
              <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Fechar</button>
            </div>
          </div>
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

    <div id="moda_plus" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Andamento</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrarAnda">
            <div class="form-group">
              <label>Observações</label>
              <textarea class="summernote" id="observacoesAnda" name="observacoesAnda">&nbsp;</textarea>
            </div>
            <div class="form-group">
              <label>Data</label>
              <input type="text" class="form-control datepicker" id="dataAnda" name="dataAnda" placeholder="Data">
            </div>
            <div class="form-group">
              <label>Hora Entrada</label>
              <input type="text" class="form-control horario" id="horarioAndaEntrada" placeholder="Horario">
            </div>
            <div class="form-group">
              <label>Hora Saída</label>
              <input type="text" class="form-control horario" id="horarioAndaSaida" placeholder="Horario">
            </div>
            <div class="form-group">
              <label>Membros</label>
              <select tabindex="3" class="form-control" id="membro" name="membro">
                  <option value="">Selecione um Membro</option>
                  <?php while($membro = mysqli_fetch_object($classe->resultado[4])): ?>
                    <option value="<?php echo $membro->id; ?>"><?php echo $membro->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select tabindex="3" class="form-control" id="statusAndamento" name="statusAndamento">
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
         <input type="hidden" name="idUsuario" id="idUsuarioPlus" value="">
        <div class="modal-footer">
          <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-raised btn-primary">Adicionar</button>
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

     <div id="moda_list" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Visualizar Andamento</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrarAnda">
            <div class="boxs-body">
              <ul class="media-list feeds_widget m-0" id="listaAndamento">
                                  
              </ul>
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

    <div id="moda_plus_edit" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Editar Andamento</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formAlterarAnda">
            <div class="form-group">
              <label>Observações</label>
              <textarea class="summernote" id="observacoesAndaEdit" name="observacoesAnda">&nbsp;</textarea>
            </div>
            <div class="form-group">
              <label>Data</label>
              <input type="text" class="form-control datepicker" id="dataAndaEdit" name="dataAnda" placeholder="Data">
            </div>
            <div class="form-group">
              <label>Hora Entrada</label>
              <input type="text" class="form-control horario" id="horarioAndaEntradaEdit" placeholder="Horario">
            </div>
            <div class="form-group">
              <label>Hora Saída</label>
              <input type="text" class="form-control horario" id="horarioAndaSaidaEdit" placeholder="Horario">
            </div>
            <div class="form-group">
              <label>Membro</label>
              <select tabindex="3" class="form-control" id="membroEdit" name="membro">
                  <option value="">Selecione um Membro</option>
                  <?php while($membroEdit = mysqli_fetch_object($classe->resultado[5])): ?>
                    <option value="<?php echo $membroEdit->id; ?>"><?php echo $membroEdit->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select tabindex="3" class="form-control" id="statusAndamentoEdit" name="statusAndamentoEdit">
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
         <input type="hidden" name="idEditAndamento" id="idEditAndamento" value="">
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

  </div>
<!-- anexar arquivo -->


    <div id="moda_view_arquivos_tabela" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Visualizar Arquivos</h4>
          </div>
          <!--modal header-->
          <div class="modal-body">
            <button type="submit" class="btn btn-raised  btn-primary " id="btnaddarquivo" name="btnadddados"><i class="fa fa-plus"></i> Adicionar Arquivo</button>
            <table id="tabelaArquivos" class="table table-striped table-bordered table-hover">
              <thead>
                <tr class="tableheader">
                  <th width="7%">Cod</th>
                  <th>Nome</th>
                  <th>Arquivo</th>
                  <th>Data Upload</th>
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

<div id="modal_add_arquivo" class="modal fade">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Adicionar Arquivo</h4>
      </div>
      <!--modal header-->
      <div class="modal-body">
        <form role="form" id="formCadastrarArquivo" action="<?php echo AJAX; ?>uploads.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" class="form-control" name="nome" id="nomeArquivo">
          </div>
          <div class="form-group row">
            <label class="col-sm-2 control-label">Arquivo</label>
            <div class="col-sm-10">
                <input type="file" class="filestyle" id="arquivo" name="arquivo" data-buttonText="Procurar Arquivo" data-iconName="fa fa-inbox">
            </div>
          </div>
          <input type="hidden" name="idUsuarioArquivo" id="idUsuarioArquivo" value="">
          <input type="hidden" name="acao" id="acao" value="arquivoOs">
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
        <form role="form" id="formCadastrarDespesa" action="<?php echo AJAX; ?>ordemservicos.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
              <label>Despesa</label>
              <select tabindex="3" class="form-control" id="despesaadd" name="despesaadd">
                  <option value="">Selecione uma Despesa</option>
                  <?php while($despesa = mysqli_fetch_object($classe->resultado[6])): ?>
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