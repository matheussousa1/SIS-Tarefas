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
        "url": "<?php echo AJAX; ?>usuarios.php?acao=buscar",
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
      { "data": "nome" },
      { "data": "email" },
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
        email : { required: true},
        contato1 : { required: true},
        senha : { required: true},
        cargo : { required: true},
        nivel : { required: true},
      },
      messages: {
        nome : { required: 'Preencha este campo' },
        email : { required: 'Preencha este campo'},
        contato1 : { required: 'Preencha este campo'},
        senha : { required: 'Preencha este campo'},
        cargo : { required: 'Preencha este campo'},
        nivel : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var nome = $("#nome").val();
        var email = $("#email").val();
        var contato1 = $("#contato1").val();
        var contato2 = $("#contato2").val();
        var senha = $("#senha").val();
        var cargo = $("#cargo").val();
        var nivel = $("#nivel").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>usuarios.php",
          data: {'acao':'cadastrar', 'nome': nome, 'email': email, 'contato1': contato1, 'contato2': contato2, 'senha': senha, 'cargo': cargo, 'nivel': nivel },
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
        url : "<?php echo AJAX; ?>usuarios.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#nomeEdit").val(data.nome);
          $("#emailEdit").val(data.email);
          $("#contato1Edit").val(data.contato1);
          $("#contato2Edit").val(data.contato2);
          $("#cargoEdit").val(data.cargo);
          $("#nivelEdit").val(data.nivel);
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
        email : { required: true},
        contato1 : { required: true},
        senha : { required: true},
        cargo : { required: true},
        nivel : { required: true},
      },
      messages: {
        nome : { required: 'Preencha este campo' },
        email : { required: 'Preencha este campo'},
        contato1 : { required: 'Preencha este campo'},
        senha : { required: 'Preencha este campo'},
        cargo : { required: 'Preencha este campo'},
        nivel : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var nome = $("#nomeEdit").val();
        var email = $("#emailEdit").val();
        var contato1 = $("#contato1Edit").val();
        var contato2 = $("#contato2Edit").val();
        var cargo = $("#cargoEdit").val();
        var nivel = $("#nivelEdit").val();
        var id = $("#idUsuario").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>usuarios.php",
          data: {'acao':'editar', 'nome': nome, 'email': email, 'contato1': contato1, 'contato2': contato2, 'cargo': cargo, 'nivel': nivel, 'id': id},
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
        title: "Inativar",   
        text: "Inativar: "+name+" ?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Deletar",   
        closeOnConfirm: true}).then(function(){   
          $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>usuarios.php",
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
          url: "<?php echo AJAX; ?>usuarios.php",
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

    $(document).on("click",".btnviewbank",function(){
      var id_user = $(this).attr("id_user");
      var value = {
        id: id_user
      };
      $.ajax({
        url : "<?php echo AJAX; ?>usuarios.php?acao=buscarContasBancarias",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          var items = [];
          $.each(data, function(conta, valor) {
            items.push(
              ' <li class="media">'+
                  '<div class="media-body">'+
                    '<p> <b>Banco:</b> '+valor.banco+'</p>'+
                    '<p> <b>Agência:</b> '+valor.agencia+'</p>'+
                    '<p> <b>Conta:</b> '+valor.conta+'</p>'+
                    '<p> <b>Tipo Conta:</b> '+valor.tipoConta+'</p>'+
                  '</div>'+
                '</li> '
            );
          });
          $('#listarContasBancarias').html(items.join(''));
          $("#moda_list_bank").modal('show');
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
          <strong>Usuarios</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="mb20 col-sm-12 text-right">
          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar Usuário</button>
        </div>
        <table id="tabela" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th>Nome</th>
                <th>Email</th>
                <th width="17%">Ações</th>
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
              <label>Nome</label>
              <input type="text" class="form-control" name="nome" id="nome">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="form-group">
              <label>Senha</label>
              <input type="password" class="form-control" name="senha" id="senha">
            </div>
            <div class="form-group">
              <label>Contato 1</label>
              <input type="text" class="form-control" name="contato1" id="contato1">
            </div>
            <div class="form-group">
              <label>Contato 2</label>
              <input type="text" class="form-control" name="contato2" id="contato2">
            </div>
            <div class="form-group">
              <label>Cargo</label>
              <input type="text" class="form-control" name="cargo" id="cargo">
            </div>
            <div class="form-group">
              <label>Nivel</label>
              <select tabindex="3" class="form-control" id="nivel" name="nivel">
                  <option value="">Selecione um nivel</option>
                  <option value="1">Administrador</option>
                  <option value="3">Suporte</option>
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
          <form role="form" id="formCadastrarEdit" autocomplete="off">
          <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" name="nome" id="nomeEdit">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="email" id="emailEdit" autocomplete="off">
            </div>
            <div class="form-group">
              <label>Contato 1</label>
              <input type="text" class="form-control" name="contato1" id="contato1Edit">
            </div>
            <div class="form-group">
              <label>Contato 2</label>
              <input type="text" class="form-control" name="contato2" id="contato2Edit">
            </div>
            <div class="form-group">
              <label>Cargo</label>
              <input type="text" class="form-control" name="cargo" id="cargoEdit">
            </div>
            <div class="form-group">
              <label>Nivel</label>
              <select tabindex="3" class="form-control" id="nivelEdit" name="nivel">
                  <option value="">Selecione um nivel</option>
                  <option value="1">Administrador</option>
                  <option value="3">Suporte</option>
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
 <div id="moda_list_bank" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Visualizar Contas Bancárias</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrarAnda">
            <div class="boxs-body">
              <ul class="media-list feeds_widget m-0" id="listarContasBancarias">
                                  
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