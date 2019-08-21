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
        acao: 'buscarContasPagar',
        data1: data1,
        data2: data2,
        status: status
      }, function(retorno){
      complete:$("#carregando").addClass("hide");

      if (retorno.length) {

        var items = [];
        $.each(retorno, function(conta, valor) {

          items.push(
            '<tr>'+
            '<td>' + valor.id + '</td>'+
            '<td>' + valor.origem + '</td>'+
            '<td>' + valor.vinculado + '</td>'+
            '<td>' + valor.data + '</td>'+
            '<td> R$ ' + numberFormat(valor.valor) + '</td>'+
            '<td>' + valor.formaPagamento + '</td>'+
            '<td>' + valor.dataPagamento + '</td>'+
            '<td>' + valor.status + '</td>'+
            '<td>' + valor.button + '</td>'+
            '</tr>'
          );
          valorEntrar = parseFloat(valorEntrar) + parseFloat(valor.valorPago);
        });

        $('#tbody').html(items.join(''));
        $('#valorTotal').html(numberFormat(valorTotal));
        // $('#valorTotalEntrado').html(numberFormat(valorEntrar));

      }else{
        $('#tbody').html('<tr><td colspan="10">Nada encontrado.</td></tr>');                         
      }

    });

    return false;
  }
$(document).ready( function () {

  $('.datepicker').mask('99/99/9999');

   $('.valor').maskMoney({thousands:'', decimal:'.'});

  $("#status").change(function(){
    request();
  });

   $(".datepicker").change(function(){
    request();
  });

   // adicionar unser
    $(document).on("click","#btnadd",function(){
        $("#modal_add").modal("show");
        $("#nome").focus();
    });

     $('#formCadastrar').validate({
      rules: {
        tipo: { required: true},
        dataVencimento: { required: true},
        valor: { required: true},
        status: { required: true},
      },
      messages: {
        tipo: { required: 'Preencha este campo' },
        dataVencimento: { required: 'Preencha este campo' },
        valor: { required: 'Preencha este campo' },
        status: { required: 'Preencha este campo' },
      },
      submitHandler: function( form ){
        var tipo = $("#tipo").val();
        var origem = $("#origem").val();
        var cliente = $("#cliente").val();
        var fornecedor = $("#fornecedor").val();
        var dataVencimento = $("#dataVencimento").val();
        var valor = $("#valor").val();
        var formaPagamento = $("#formaPagamento").val();
        var status = $("#status").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>financeiro.php",
          data: {'acao':'cadastrarContaPagar', 'origem': origem, 'tipo': tipo, 'cliente': cliente, 'fornecedor': fornecedor, 'formaPagamento': formaPagamento, 'dataVencimento': dataVencimento, 'valor': valor, 'status': status},
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
      url : "<?php echo AJAX; ?>financeiro.php?acao=buscarDadosContaPagar",
      type: "GET",
      data : value,
      success: function(data, textStatus, jqXHR)
      {
        var data = jQuery.parseJSON(data);
        $("#origemEdit").val(data.origem);
        $("#dataVencimentoEdit").val(data.data);
        $("#dataPagamentoEdit").val(data.dataPagamento);
        $("#valorEdit").val(data.valor);
        $('#statusEdit').val(data.status);
        $('#tipoEdit').val(data.tipo);
        mudartipo(data.tipo);
        $('#clienteEdit').val(data.cliente);
        $('#fornecedorEdit').val(data.fornecedor);
        $('#formaPagamentoEdit').val(data.formaPagamento);
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
        tipo: { required: true},
        dataVencimento: { required: true},
        valor: { required: true},
        status: { required: true},
        dataPagamento: { required: true},
      },
      messages: {
        tipo: { required: 'Preencha este campo' },
        dataVencimento: { required: 'Preencha este campo' },
        valor: { required: 'Preencha este campo' },
        status: { required: 'Preencha este campo' },
        dataPagamento: {required: 'Preencha este campo'},
      },
    submitHandler: function( form ){
      var origem = $("#origemEdit").val();
      var dataVencimento = $("#dataVencimentoEdit").val();
      var valor = $("#valorEdit").val();
      var status = $("#statusEdit").val();
      var dataPagamento = $("#dataPagamentoEdit").val();
      var tipo = $("#tipoEdit").val();
      var cliente = $("#clienteEdit").val();
      var fornecedor = $("#fornecedorEdit").val();
      var formaPagamento = $("#formaPagamentoEdit").val();
      var id = $("#idUsuario").val();
      // console.log(id);
      $.ajax({
        type: "GET",
        url: "<?php echo AJAX; ?>financeiro.php",
        data: {'acao':'editarContaPagar', 'id': id, 'origem': origem, 'dataVencimento': dataVencimento, 'valor': valor, 'status': status, 'dataPagamento': dataPagamento, 'tipo': tipo, 'cliente': cliente, 'fornecedor': fornecedor, 'formaPagamento': formaPagamento},
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

  $('#tipo').change(function(){
        var tipo = $('#tipo').val();
        $('.esconder').addClass('hide');
        $('.limpar').val('');
        if(tipo == 1){
          $('#espcliente').removeClass('hide');
        }else if(tipo == 2){
          $('#espfornecedor').removeClass('hide');
        }else if(tipo == 3){
          $('#espcomum').removeClass('hide');
        }

     });

     $('#tipoEdit').change(function(){
        var tipo = $('#tipoEdit').val();
        $('.esconder').addClass('hide');
        $('.limpar').val('');
        if(tipo == 1){
          $('#espclienteEdit').removeClass('hide');
        }else if(tipo == 2){
          $('#espfornecedorEdit').removeClass('hide');
        }else if(tipo == 3){
          $('#espcomumEdit').removeClass('hide');
        }
     });
});

function mudartipo(tipo){
  var tipo = tipo;
  $('.esconder').addClass('hide');
  $('.limpar').val('');
  if(tipo == 1){
    $('#espclienteEdit').removeClass('hide');
  }else if(tipo == 2){
    $('#espfornecedorEdit').removeClass('hide');
  }else if(tipo == 3){
    $('#espcomumEdit').removeClass('hide');
  }
}

  // arquivos

  $(document).ready(function() {
    request();
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
          data: {'acao':'deletarArquivoConta', 'id': id_user},
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
        "url": "<?php echo AJAX; ?>financeiro.php?acao=buscarArquivosConta&idCliente="+idCliente,
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
          <strong>Financeiro Contas a Pagar</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="row">
          <div class="mb20 col-sm-12 text-right">
          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar Conta a Pagar</button>
        </div>
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
              <th>#</th>
              <th>Tipo</th>
              <th>Origem</th>
              <th>Dat Vencimento</th>
              <th>Valor</th>
              <th>Forma Pagamento</th>
              <th>Data Pagamento</th>
              <th>Status</th>
              <th width="10%">Ação</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <tr><td colspan="9"><strong>Escolha uma data acima.</strong></td></tr>
          </tbody>
        </table>
        <!-- <div class="row mt20">
          <div class="col-md-4">
            Valor entrado: <b>R$ <span id="valorTotalEntrado"></span></b>
          </div> 
        </div> -->
      </div>
    </section>
  </div>
</section>
</div>

<div id="modal_add" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Adicionar</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrar">
            <div class="form-group">
              <label>Tipo</label>
              <select tabindex="3" class="form-control" id="tipo" name="tipo">
                  <option value="">Selecione um Tipo</option>
                  <option value="1">Cliente</option>
                  <option value="2">Fornecedor</option>
                  <option value="3">Comum</option>
              </select>
            </div>
            <div class="form-group hide esconder" id="espcomum">
              <label>Origem</label>
              <input type="text" class="form-control" name="origem" id="origem">
            </div>
            <div class="form-group hide esconder" id="espcliente">
              <label>Cliente</label>
              <select tabindex="3" class="form-control limpar" id="cliente" name="cliente">
                  <option value="">Selecione um Cliente</option>
                  <?php while($cliente = mysqli_fetch_object($classe->resultado[0])): ?>
                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group hide esconder" id="espfornecedor">
              <label>Fornecedor</label>
              <select tabindex="3" class="form-control limpar" id="fornecedor" name="fornecedor">
                  <option value="">Selecione um Fornecedor</option>
                  <?php while($fornecedor = mysqli_fetch_object($classe->resultado[1])): ?>
                    <option value="<?php echo $fornecedor->id; ?>"><?php echo $fornecedor->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group">
            <label>Data Vencimento</label>
              <input type="text" class="form-control datepicker" id="dataVencimento" name="dataVencimento" placeholder="Data">
          </div>
            <div class="form-group">
            <label>Valor</label>
            <div class="input-group bootstrap-touchspin">
                <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                <input type="text" class="form-control valor" style="display: block;" id="valor" name="valor">
            </div>
          </div>
          <div class="form-group">
            <label>Forma Pagamento</label>
            <select tabindex="3" class="form-control" id="formaPagamento" name="formaPagamento">
              <option value="">Selecione uma Forma</option>
              <option value="1">Dinheiro</option>
              <option value="2">Cartão de Crédito</option>
              <option value="3">Cartão de Debito</option>
              <option value="4">Cheque</option>
              <option value="5">Deposito em Conta</option>
              <option value="6">Transferencia Bancaria</option>
              <option value="7">Debito em Conta</option>
            </select>
          </div>
            <div class="form-group">
            <label>Status</label>
            <select tabindex="3" class="form-control" id="status" name="status">
              <option value="">Selecione um Status</option>
              <option value="0">Não Pago</option>
              <option value="1">Pago</option>
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
              <label>Tipo</label>
              <select tabindex="3" class="form-control" id="tipoEdit" name="tipo">
                  <option value="">Selecione um Tipo</option>
                  <option value="1">Cliente</option>
                  <option value="2">Fornecedor</option>
                  <option value="3">Comum</option>
              </select>
            </div>
            <div class="form-group hide esconder" id="espcomumEdit">
              <label>Origem</label>
              <input type="text" class="form-control" name="origem" id="origemEdit">
            </div>
            <div class="form-group hide esconder" id="espclienteEdit">
              <label>Cliente</label>
              <select tabindex="3" class="form-control limpar" id="clienteEdit" name="cliente">
                  <option value="">Selecione um Cliente</option>
                  <?php while($cliente = mysqli_fetch_object($classe->resultado[2])): ?>
                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group hide esconder" id="espfornecedorEdit">
              <label>Fornecedor</label>
              <select tabindex="3" class="form-control limpar" id="fornecedorEdit" name="fornecedor">
                  <option value="">Selecione um Fornecedor</option>
                  <?php while($fornecedor = mysqli_fetch_object($classe->resultado[3])): ?>
                    <option value="<?php echo $fornecedor->id; ?>"><?php echo $fornecedor->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
          <div class="form-group">
            <label>Data Vencimento</label>
              <input type="text" class="form-control datepicker" id="dataVencimentoEdit" name="dataVencimento" placeholder="Data">
          </div>
            <div class="form-group">
            <label>Valor</label>
            <div class="input-group bootstrap-touchspin">
                <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                <input type="text" class="form-control valor" style="display: block;" id="valorEdit" name="valor">
            </div>
          </div>
          <div class="form-group">
            <label>Data Pagamento</label>
              <input type="text" class="form-control datepicker" id="dataPagamentoEdit" name="dataPagamento" placeholder="Data">
          </div>
          <div class="form-group">
            <label>Forma Pagamento</label>
            <select tabindex="3" class="form-control" id="formaPagamentoEdit" name="formaPagamento">
              <option value="">Selecione uma Forma</option>
              <option value="1">Dinheiro</option>
              <option value="2">Cartão de Crédito</option>
              <option value="3">Cartão de Debito</option>
              <option value="4">Cheque</option>
              <option value="5">Deposito em Conta</option>
              <option value="6">Transferencia Bancaria</option>
              <option value="7">Debito em Conta</option>
            </select>
          </div>
            <div class="form-group">
            <label>Status</label>
            <select tabindex="3" class="form-control" id="statusEdit" name="status">
              <option value="">Selecione um Status</option>
              <option value="0">Não Pago</option>
              <option value="1">Pago</option>
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
          <input type="hidden" name="acao" id="acao" value="arquivoConta">
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
