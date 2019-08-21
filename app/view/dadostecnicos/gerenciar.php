<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="<?php echo SITE ?>assets/js/vendor/summernote/lang-br.js"></script> 
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

    $('.summernote').summernote({
      height: 200,
      lang: 'pt-BR',
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
      ]
    });

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
        "url": "<?php echo AJAX; ?>dadostecnicos.php?acao=buscar",
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
      { "data": "descricaoproduto" },
      { "data": "nome" },
      { "data": "serial" },
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
        nome : { required: true},
        equipamento : { required: true},
        cliente: { required: true},
        responsavel: { required: true},
      },
      messages: {
        nome : { required: 'Preencha este campo' },
        equipamento : { required: 'Preencha este campo' },
        cliente : { required: 'Preencha este campo' },
        responsavel : { required: 'Preencha este campo' },
      },
      submitHandler: function( form ){
        var nome = $("#nome").val();
        var equipamento = $("#equipamento").val();
        var cliente = $("#cliente").val();
        var serial = $("#serial").val();
        var portainicio = $("#portainicio").val();
        var portafim = $("#portafim").val();
        var senharemoto = $("#senharemoto").val();
        var usuario = $("#usuario").val();
        var senha = $("#senha").val();
        var responsavel = $("#responsavel").val();
        var observacoes = $("#observacoes").val();
        var idRef = <?php echo $idRef; ?>;
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>dadostecnicos.php",
          data: {'acao':'cadastrar', 'nome': nome, 'equipamento': equipamento, 'cliente': cliente, 'serial': serial, 'portainicio': portainicio, 'portafim': portafim, 'senharemoto': senharemoto, 'usuario': usuario, 'senha': senha, 'responsavel': responsavel, 'observacoes': observacoes, 'idRef':idRef},
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
        url : "<?php echo AJAX; ?>dadostecnicos.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#nomeEdit").val(data.nome);
          $("#equipamentoEdit").val(data.equipamento);
          $("#clienteEdit").val(data.cliente);
          $("#serialEdit").val(data.serial);
          $("#portainicioEdit").val(data.portainicio);
          $("#portafimEdit").val(data.portafim);
          $("#senharemotoEdit").val(data.senharemoto);
          $("#usuarioEdit").val(data.usuario);
          $("#senhaEdit").val(data.senha);
          $("#observacoesEdit").summernote('code', data.observacoes);
          $("#responsavelEdit").val(data.responsavel);
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
        nome : { required: true},
        equipamento : { required: true},
        cliente: { required: true},
        responsavel: { required: true},
      },
      messages: {
        nome : { required: 'Preencha este campo' },
        equipamento : { required: 'Preencha este campo' },
        cliente : { required: 'Preencha este campo' },
        responsavel : { required: 'Preencha este campo' },
      },
      submitHandler: function( form ){
        var nome = $("#nomeEdit").val();
        var equipamento = $("#equipamentoEdit").val();
        var cliente = $("#clienteEdit").val();
        var serial = $("#serialEdit").val();
        var portainicio = $("#portainicioEdit").val();
        var portafim = $("#portafimEdit").val();
        var senharemoto = $("#senharemotoEdit").val();
        var usuario = $("#usuarioEdit").val();
        var senha = $("#senhaEdit").val();
        var observacoes = $("#observacoesEdit").val();
        var responsavel = $("#responsavelEdit").val();
        var id = $("#idUsuario").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>dadostecnicos.php",
          data: {'acao':'editar', 'nome': nome, 'equipamento': equipamento, 'cliente': cliente, 'serial': serial, 'portainicio': portainicio, 'portafim': portafim, 'senharemoto': senharemoto, 'usuario': usuario, 'senha': senha, 'responsavel': responsavel, 'observacoes': observacoes,'id': id},
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
          url: "<?php echo AJAX; ?>dadostecnicos.php",
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
          url: "<?php echo AJAX; ?>dadostecnicos.php",
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

      //abrir modal pra edição
    $(document).on("click",".btnview",function(){
      var id_user = $(this).attr("id_user");
      var value = {
        id: id_user
      };
      $.ajax({
        url : "<?php echo AJAX; ?>dadostecnicos.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#nomeView").html(data.nome);
          $("#equipamentoView").html(data.equipamentoView);
          $("#clienteView").html(data.clienteView);
          $("#serialView").html(data.serial);
          $("#portainicioView").html(data.portainicio);
          $("#portafimView").html(data.portafim);
          $("#senharemotoView").html(data.senharemoto);
          $("#usuarioView").html(data.usuario);
          $("#senhaView").html(data.senha);
          $("#observacoesView").html(data.observacoes);
          $("#responsavelView").html(data.responsavelView);
          //$("#idUsuario").val(data.id);
          $("#moda_view").modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });
    });
 });  
</script>

<section id="content">
  <div class="page col-md-12">   
    <section class="boxs">
      <div class="boxs-header">
        <h3 class="custom-font hb-cyan">
          <strong>Dados Técnicos</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="mb20 col-sm-12 text-right">
          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar Dados Técnicos</button>
        </div>
        <table id="tabela" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th width="7%">Cod</th>
                <th>Cliente</th>
                <th>Equipamento</th>
                <th>Local</th>
                <th>Serial</th>
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
              <label>Equipamento</label>
              <select tabindex="3" class="form-control" id="equipamento" name="equipamento">
                  <option value="">Selecione um equipamento</option>
                  <?php while($equipamento = mysqli_fetch_object($classe->resultado[0])): ?>
                    <option value="<?php echo $equipamento->id; ?>"><?php echo $equipamento->descricao; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Local</label>
              <input type="text" class="form-control" name="nome" id="nome">
            </div>
            <div class="form-group">
              <label>Cliente</label>
              <select tabindex="3" class="form-control" id="cliente" name="cliente">
                  <option value="">Selecione um Cliente</option>
                  <?php while($cliente = mysqli_fetch_object($classe->resultado[1])): ?>
                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Serial / MAC / IP</label>
              <input type="text" class="form-control" name="serial" id="serial">
            </div>
            <div class="form-group">
              <label>Porta http inicio</label>
              <input type="text" class="form-control" name="portainicio" id="portainicio">
            </div>
            <div class="form-group">
              <label>Porta http fim</label>
              <input type="text" class="form-control" name="portafim" id="portafim">
            </div>
            <div class="form-group">
              <label>Senha acesso remoto</label>
              <input type="text" class="form-control" name="senharemoto" id="senharemoto">
            </div>
            <div class="form-group">
              <label>Usuário</label>
              <input type="text" class="form-control" name="usuario" id="usuario">
            </div>
            <div class="form-group">
              <label>Senha</label>
              <input type="text" class="form-control" name="senha" id="senha">
            </div>
            <div class="form-group">
              <label>Responsável</label>
              <select tabindex="3" class="form-control" id="responsavel" name="responsavel">
                  <option value="">Selecione um Responsavel</option>
                  <?php while($responsavel = mysqli_fetch_object($classe->resultado[2])): ?>
                    <option value="<?php echo $responsavel->id; ?>"><?php echo $responsavel->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Observações</label>
              <textarea name="observacoes" id="observacoes" class="form-control summernote" rows="3"></textarea>
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
              <label>Equipamento</label>
              <select tabindex="3" class="form-control" id="equipamentoEdit" name="equipamento">
                  <option value="">Selecione um equipamento</option>
                  <?php while($equipamentoEdit = mysqli_fetch_object($classe->resultado[3])): ?>
                    <option value="<?php echo $equipamentoEdit->id; ?>"><?php echo $equipamentoEdit->marcamodelo; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Local</label>
              <input type="text" class="form-control" name="nome" id="nomeEdit">
            </div>
            <div class="form-group">
              <label>Cliente</label>
              <select tabindex="3" class="form-control" id="clienteEdit" name="cliente">
                  <option value="">Selecione um Cliente</option>
                  <?php while($clienteEdit = mysqli_fetch_object($classe->resultado[4])): ?>
                    <option value="<?php echo $clienteEdit->id; ?>"><?php echo $clienteEdit->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Serial / MAC / IP</label>
              <input type="text" class="form-control" name="serial" id="serialEdit">
            </div>
            <div class="form-group">
              <label>Porta http inicio</label>
              <input type="text" class="form-control" name="portainicio" id="portainicioEdit">
            </div>
            <div class="form-group">
              <label>Porta http fim</label>
              <input type="text" class="form-control" name="portafim" id="portafimEdit">
            </div>
            <div class="form-group">
              <label>Senha acesso remoto</label>
              <input type="text" class="form-control" name="senharemoto" id="senharemotoEdit">
            </div>
            <div class="form-group">
              <label>Usuário</label>
              <input type="text" class="form-control" name="usuario" id="usuarioEdit">
            </div>
            <div class="form-group">
              <label>Senha</label>
              <input type="text" class="form-control" name="senha" id="senhaEdit">
            </div>
            <div class="form-group">
              <label>Responsável</label>
              <select tabindex="3" class="form-control" id="responsavelEdit" name="responsavel">
                  <option value="">Selecione um Responsavel</option>
                  <?php while($responsavelEdit = mysqli_fetch_object($classe->resultado[5])): ?>
                    <option value="<?php echo $responsavelEdit->id; ?>"><?php echo $responsavelEdit->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Observações</label>
              <textarea name="observacoes" id="observacoesEdit" class="form-control summernote" rows="3"></textarea>
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
              <label>Equipamento</label>
              <p id="equipamentoView"></p>
            </div>
            <div class="form-group">
              <label>Local</label>
              <p id="nomeView"></p>
            </div>
            <div class="form-group">
              <label>Cliente</label>
              <p id="clienteView"></p>
            </div>
            <div class="form-group">
              <label>Serial / MAC / IP</label>
              <p id="serialView"></p>
            </div>
            <div class="form-group">
              <label>Porta http inicio</label>
              <p id="portainicioView"></p>
            </div>
            <div class="form-group">
              <label>Porta http fim</label>
              <p id="portafimView"></p>
            </div>
            <div class="form-group">
              <label>Senha acesso remoto</label>
              <p id="senharemotoView"></p>
            </div>
            <div class="form-group">
              <label>Usuário</label>
              <p id="usuarioView"></p>
            </div>
            <div class="form-group">
              <label>Senha</label>
              <p id="senhaView"></p>
            </div>
            <div class="form-group">
              <label>Responsável</label>
              <p id="responsavelView"></p>
            </div>
            <div class="form-group">
              <label>Observações</label>
              <p id="observacoesView"></p>
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
