<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<!-- arquivos -->
<script src="<?php echo SITE; ?>assets/js/vendor/filestyle/bootstrap-filestyle.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript">
  function numberFormat(n) {
    var parts=n.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + (parts[1] ? "," + parts[1] : "");
  }

  function request(){

    var data1   = $("#inicial").val();
    var data2   = $("#final").val();
    var status = $("#status").val();
    var valorrestante = 0;
    var valorTotal = 0;
    var valorEntrar = 0;

    if(data2 == '')
      return false;

    beforeSend:$("#carregando").removeClass("hide");
    $.getJSON("<?php echo AJAX."financeiro.php";?>", 
      {
        acao: 'buscar',
        data1: data1,
        data2: data2,
        status: status
      }, function(retorno){
      complete:$("#carregando").addClass("hide");

      if (retorno.length) {

        var items = [];
        $.each(retorno, function(conta, valor) {
          
          valorrestante = parseFloat(valor.valorAdicional) - parseFloat(valor.valorPago);

          items.push(
            '<tr>'+
            '<td>' + valor.id + '</td>'+
            '<td>' + valor.cliente + '</td>'+
            '<td>' + valor.dataCadastro + '</td>'+
            '<td>' + valor.dataPrazo + '</td>'+
            '<td>' + valor.dataPagamento + '</td>'+
            '<td> R$ ' + numberFormat(valor.valorAdicional) + '</td>'+
            '<td> R$ ' + numberFormat(valor.valorPago) + '</td>'+
            '<td> R$ ' + numberFormat(valorrestante) + '</td>'+
            '<td>' + valor.status + '</td>'+
            '<td>' + valor.emitirNota + '</td>'+
            '<td>' + valor.button + '</td>'+
            '</tr>'
          );
          valorTotal = parseFloat(valorTotal) + parseFloat(valor.valorAdicional);
          valorEntrar = parseFloat(valorEntrar) + parseFloat(valor.valorPago);
        });

        $('#tbody').html(items.join(''));
        $('#valorTotal').html(numberFormat(valorTotal));
        $('#valorTotalEntrado').html(numberFormat(valorEntrar));

      }else{
        $('#tbody').html('<tr><td colspan="11">Nada encontrado.</td></tr>');                         
      }

    });

    return false;
  }
$(document).ready( function () {

  request();
  
  $('.datepicker').mask('99/99/9999');

   $('.valor').maskMoney({thousands:'', decimal:'.'});

  $("#status").change(function(){
    request();
  });

   $(".datepicker").change(function(){
    request();
  });
  //abrir modal pra edição
  $(document).on("click",".btnedit",function(){
    var id_user = $(this).attr("id_user");
    var value = {
      id: id_user
    };
    $.ajax({
      url : "<?php echo AJAX; ?>financeiro.php?acao=buscarDados",
      type: "GET",
      data : value,
      success: function(data, textStatus, jqXHR)
      {
        var data = jQuery.parseJSON(data);
        valorrestante = parseFloat(data.valorAdicional) - parseFloat(data.valorPago);
        $("#os").html(data.id);
        $("#cliente").html(data.cliente);
        $("#dataCadastro").html(data.dataCadastro);
        $("#dataPrazo").html(data.dataPrazo);
        $("#dataPagamento").val(data.dataPagamento);
        $("#valorPago").val(data.valorPago);
        $("#valorAdicional").html('R$ '+numberFormat(data.valorAdicional));
        $("#statusPagamento").val(data.statusPagamento);
        $('#faltaPagar').html('R$ '+ numberFormat(valorrestante.toFixed(2)));
        $('#statusPago').val(data.statusPagamento);
        $('#emitirNota').val(data.emitirNota);
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
    submitHandler: function( form ){
      var statusPago = $("#statusPago").val();
      var dataPagamento = $("#dataPagamento").val();
      var valorPago = $("#valorPago").val();
      var emitirNota = $("#emitirNota").val();
      var id = $("#idUsuario").val();
      $.ajax({
        type: "GET",
        url: "<?php echo AJAX; ?>financeiro.php",
        data: {'acao':'editar', 'statusPago': statusPago, 'dataPagamento': dataPagamento, 'valorPago': valorPago, 'id': id, 'emitirNota': emitirNota},
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
                  var table = $('#tabela').DataTable(); 
                  table.ajax.reload( null, false );
                  $("#moda_edit").modal("hide");
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
});

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
          url: "<?php echo AJAX; ?>financeiro.php",
          data: {'acao':'deletarArquivoGerenciar', 'id': id_user},
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
        "url": "<?php echo AJAX; ?>financeiro.php?acao=buscarArquivosGerenciar&idCliente="+idCliente,
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
</script>
<section id="content">
  <div class="page col-md-12">   
    <section class="boxs">
      <div class="boxs-header">
        <h3 class="custom-font hb-cyan">
          <strong>Financeiro</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="row">
          <div class="col-md-12"> 
            <span class="pull-left form-inline">
              <label for="datepicker">Escolha a data: </label>
              <input type="text" class="form-control datepicker" id="inicial" name="inicial" placeholder="Data inicial" value="<?php echo date('d/m/Y', strtotime('-1day')); ?>" />
              <input type="text" class="form-control datepicker" id="final" name="final" placeholder="Data final" value="<?php echo date('d/m/Y', strtotime('+1day')); ?>" />
            </span> 
            <span class="pull-right form-inline">
            <label>Escolha Status: </label>
            <select name="status" id="status" class="form-control">
              <option value="">Selecione um Status</option>
              <option value="2" selected="">Todos</option>
              <option value="0">Não pago</option>
              <option value="1">Pago</option>
            </select>
            </span>
          </div>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>O.S</th>
              <th>Cliente</th>
              <th>Data Geração</th>
              <th>Data Final</th>
              <th>Data Pagamento</th>
              <th>Valor Total</th>
              <th>Valor Pago</th>
              <th>Valor Restante</th>
              <th>Status</th>
              <th>Emitir Nota</th>
              <th width="10%">Ação</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <tr><td colspan="10"><strong>Escolha uma data acima.</strong></td></tr>
          </tbody>
        </table>
        <div class="row mt20">
          <div class="col-md-4">
            Valor para entrar: <b>R$ <span id="valorTotal"></span></b>
          </div> 
          <div class="col-md-4">
            Valor entrado: <b>R$ <span id="valorTotalEntrado"></span></b>
          </div> 
        </div>
      </div>
    </section>
  </div>
</section>
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
            <label>O.S</label>
            <p id="os"></p>
          </div>
          <div class="form-group">
            <label>Cliente</label>
            <p id="cliente"></p>
          </div>
          <div class="form-group">
            <label>Data Geração</label>
            <p id="dataCadastro"></p>
          </div>
          <div class="form-group">
            <label>Data Final</label>
            <p id="dataPrazo"></p>
          </div>
          <div class="form-group">
            <label>Valor Pagar</label>
            <p id="valorAdicional"></p>
          </div>
          <div class="form-group">
            <label>Falta Pagar</label>
            <p id="faltaPagar"></p>
          </div>
          <div class="form-group">
            <label>Valor Pago</label>
            <div class="input-group bootstrap-touchspin">
                <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                <input type="text" class="form-control valor" style="display: block;" id="valorPago" name="valorPago">
            </div>
          </div>
          <div class="form-group">
            <label>Data Pagamento</label>
              <input type="text" class="form-control datepicker" id="dataPagamento" name="dataPagamento" placeholder="Data">
          </div>
          <div class="form-group">
            <label>Status Pagamento</label>
            <select tabindex="3" class="form-control limpar" id="statusPago" name="statusPago">
              <option value="">Selecione um Status</option>
              <option value="0">Não Pago</option>
              <option value="1">Pago</option>
            </select>
          </div>
          <div class="form-group">
            <label>Emitir Nota</label>
            <select tabindex="3" class="form-control limpar" id="emitirNota" name="emitirNota">
              <option value="">Selecione um Status</option>
              <option value="0">Não</option>
              <option value="1">Sim</option>
              <option value="2">Emitida</option>
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
          <input type="hidden" name="acao" id="acao" value="arquivoFinGerenciar">
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
