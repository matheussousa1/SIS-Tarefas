<link rel="stylesheet" href="<?php echo SITE; ?>assets/js/vendor/touchspin/jquery.bootstrap-touchspin.min.css">

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

    $('#contato1').mask(maskBehavior, options);
    $('#contato2').mask(maskBehavior, options);

    $('#contato1Edit').mask(maskBehavior, options);
    $('#contato2Edit').mask(maskBehavior, options);

  $('#tabela').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": false,
    "responsive": true,
    "autoWidth": false,
    "pageLength": 10,
    "ajax": {
        "url": "<?php echo AJAX; ?>contasBancarias.php?acao=buscar",
        "type": "GET"
    },
    "language": {
      "url": "http://cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
    },
    "columns": [
      { "data": "tipo" },
      { "data": "nome" },
      { "data": "banco" },
      { "data": "agencia" },
      { "data": "conta" },
      { "data": "tipoConta" },
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
        tipo: { required: true},
        banco: { required: true},
        agencia: { required: true},
        conta: { required: true},
        tipoConta: { required: true},
      },
      messages: {
        tipo: { required: 'Preencha este campo' },
        banco: { required: 'Preencha este campo' },
        agencia: { required: 'Preencha este campo' },
        conta: { required: 'Preencha este campo' },
        tipoConta: { required: 'Preencha este campo' },
      },
      submitHandler: function( form ){
        var tipo = $("#tipo").val();
        var banco = $("#banco").val();
        var conta = $("#conta").val();
        var agencia = $("#agencia").val();
        var tipoConta = $("#tipoConta").val();
        var usuario = $("#usuario").val();
        var fornecedor = $("#fornecedor").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>contasBancarias.php",
          data: {'acao':'cadastrar', 'tipo': tipo, 'banco': banco, 'conta': conta, 'agencia': agencia, 'tipoConta': tipoConta, 'usuario': usuario, 'fornecedor': fornecedor},
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
        url : "<?php echo AJAX; ?>contasBancarias.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#tipoEdit").val(data.tipo);
          $("#bancoEdit").val(data.banco);
          mudartipo(data.tipo);
          $("#usuarioEdit").val(data.idUsuario);
          $("#fornecedorEdit").val(data.idFornecedor);
          $("#agenciaEdit").val(data.agencia);
          $("#contaEdit").val(data.conta);
          $("#tipoContaEdit").val(data.tipoConta);
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
        banco: { required: true},
        agencia: { required: true},
        conta: { required: true},
        tipoConta: { required: true},
      },
      messages: {
        tipo: { required: 'Preencha este campo' },
        banco: { required: 'Preencha este campo' },
        agencia: { required: 'Preencha este campo' },
        conta: { required: 'Preencha este campo' },
        tipoConta: { required: 'Preencha este campo' },
      },
      submitHandler: function( form ){
        var tipo = $("#tipoEdit").val();
        var banco = $("#bancoEdit").val();
        var conta = $("#contaEdit").val();
        var agencia = $("#agenciaEdit").val();
        var tipoConta = $("#tipoContaEdit").val();
        var usuario = $("#usuarioEdit").val();
        var fornecedor = $("#fornecedorEdit").val();
        var id = $("#idUsuario").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>contasBancarias.php",
          data: {'acao':'editar', 'tipo': tipo, 'banco': banco, 'conta': conta, 'agencia': agencia, 'tipoConta': tipoConta, 'usuario': usuario, 'fornecedor': fornecedor, 'id': id},
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
          url: "<?php echo AJAX; ?>contasBancarias.php",
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
          url: "<?php echo AJAX; ?>contasBancarias.php",
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

     $('#tipo').change(function(){
        var tipo = $('#tipo').val();
        $('.esconder').addClass('hide');
        $('.limpar').val('');
        if(tipo == 1){
          $('#espcliente').removeClass('hide');
        }else if(tipo == 2){
          $('#espfornecedor').removeClass('hide');
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
  }
}
</script>

<section id="content">
  <div class="page col-md-12">   
    <section class="boxs">
      <div class="boxs-header">
        <h3 class="custom-font hb-cyan">
          <strong>Contas Bancárias</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="mb20 col-sm-12 text-right">
          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar Conta Bancária</button>
        </div>
        <table id="tabela" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th>Tipo</th>
                <th>Nome</th>
                <th>Banco</th>
                <th>Agência / DV</th>
                <th>Conta / DV</th>
                <th>Tipo Conta</th>
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
          <form role="form" id="formCadastrar">
            <div class="form-group">
              <label>Tipo</label>
              <select tabindex="3" class="form-control" id="tipo" name="tipo">
                  <option value="">Selecione um Tipo</option>
                  <option value="1">Usuário</option>
                  <option value="2">Fornecedor</option>
              </select>
            </div>
            <div class="form-group hide esconder" id="espcliente">
              <label>Usuário</label>
              <select tabindex="3" class="form-control limpar" id="usuario" name="usuario">
                  <option value="">Selecione um Usuário</option>
                  <?php while($usuario = mysqli_fetch_object($classe->resultado[0])): ?>
                    <option value="<?php echo $usuario->id; ?>"><?php echo $usuario->nome; ?></option>
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
              <label>Banco</label>
              <input type="text" class="form-control" name="banco" id="banco">
            </div>
            <div class="form-group">
              <label>Agência / DV</label>
              <input type="text" class="form-control" name="agencia" id="agencia">
            </div>
            <div class="form-group">
              <label>Conta / DV</label>
              <input type="text" class="form-control" name="conta" id="conta">
            </div>
            <div class="form-group">
              <label>Tipo Conta</label>
              <select name="tipoConta" id="tipoConta" class="form-control" >
                <option value="">Selecione o tipo de conta</option>
                <option value="1">Corrente</option>
                <option value="2">Poupança</option>
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
                  <option value="1">Usuário</option>
                  <option value="2">Fornecedor</option>
              </select>
            </div>
            <div class="form-group hide esconder" id="espclienteEdit">
              <label>Usuário</label>
              <select tabindex="3" class="form-control limpar" id="usuarioEdit" name="usuario">
                  <option value="">Selecione um Usuário</option>
                  <?php while($usuarioEdit = mysqli_fetch_object($classe->resultado[2])): ?>
                    <option value="<?php echo $usuarioEdit->id; ?>"><?php echo $usuarioEdit->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
             <div class="form-group hide esconder" id="espfornecedorEdit">
              <label>Fornecedor</label>
              <select tabindex="3" class="form-control limpar" id="fornecedorEdit" name="fornecedor">
                  <option value="">Selecione um Fornecedor</option>
                  <?php while($fornecedorEdit = mysqli_fetch_object($classe->resultado[3])): ?>
                    <option value="<?php echo $fornecedorEdit->id; ?>"><?php echo $fornecedorEdit->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Banco</label>
              <input type="text" class="form-control" name="banco" id="bancoEdit">
            </div>
            <div class="form-group">
              <label>Agência / DV</label>
              <input type="text" class="form-control" name="agencia" id="agenciaEdit">
            </div>
            <div class="form-group">
              <label>Conta / DV</label>
              <input type="text" class="form-control" name="conta" id="contaEdit">
            </div>
            <div class="form-group">
              <label>Tipo Conta</label>
              <select name="tipoConta" id="tipoContaEdit" class="form-control" >
                <option value="">Selecione o tipo de conta</option>
                <option value="1">Corrente</option>
                <option value="2">Poupança</option>
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
  </div>
