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
    // mascara cpf cnpj
     var maskcpfcnpj = function (val) {
      return val.replace(/\D/g, '').length > 14 ? '000.000.000-000' : '00.000.000/0000-00';
    },
    optionscpfcnpj = { onKeyPress: function(val, e, field, optionscpfcnpj) {
            field.mask(maskcpfcnpj.apply({}, arguments), optionscpfcnpj);
        }
    };

    $('#cpfcnpj').mask(maskcpfcnpj, optionscpfcnpj);
    $('#contato1').mask(maskBehavior, options);
    $('#contato2').mask(maskBehavior, options);
    $('#cep').mask('99999-999');

    $('#contato1Edit').mask(maskBehavior, options);
    $('#contato2Edit').mask(maskBehavior, options);
    $('#cepEdit').mask('99999-999');
    $('#cpfcnpjEdit').mask(maskcpfcnpj, optionscpfcnpj);

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
        "url": "<?php echo AJAX; ?>fornecedores.php?acao=buscar",
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
      { "data": "endereco" },
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
        razao: { required: true},
        cpfcnpj: { required: true},
        contato1: { required: true},
        cep: { required: true},
        logadouro: { required: true},
        numero: { required: true},
        bairro: { required: true},
        cidade: { required: true},
        estado: { required: true}
      },
      messages: {
        nome : { required: 'Preencha este campo' },
        razao: { required: 'Preencha este campo' },
        cpfcnpj: { required: 'Preencha este campo' },
        contato1: { required: 'Preencha este campo' },
        cep: { required: 'Preencha este campo' },
        logadouro: { required: 'Preencha este campo' },
        numero: { required: 'Preencha este campo' },
        bairro: { required: 'Preencha este campo' },
        cidade: { required: 'Preencha este campo' },
        estado: { required: 'Preencha este campo' }
      },
      submitHandler: function( form ){
        var nome = $("#nome").val();
        var razao = $("#razao").val();
        var cpfcnpj = $("#cpfcnpj").val();
        var contato1 = $("#contato1").val();
        var contato2 = $("#contato2").val();
        var cep = $("#cep").val();
        var logadouro = $("#logadouro").val();
        var numero = $("#numero").val();
        var bairro = $("#bairro").val();
        var cidade = $("#cidade").val();
        var estado = $("#estado").val();
        var complemento = $("#complemento").val();
        var idRef = <?php echo $idRef; ?>;
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>fornecedores.php",
          data: {'acao':'cadastrar', 'nome': nome, 'razao': razao, 'cpfcnpj': cpfcnpj,'contato1': contato1,'contato2': contato2,'cep': cep,'logadouro': logadouro,'numero': numero,'bairro': bairro,'cidade': cidade,'estado': estado, 'complemento': complemento,'idRef':idRef},
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
        url : "<?php echo AJAX; ?>fornecedores.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#nomeEdit").val(data.nome);
          $("#razaoEdit").val(data.razao);
          $("#cpfcnpjEdit").val(data.cpfcnpj);
          $("#contato1Edit").val(data.contato1);
          $("#contato2Edit").val(data.contato2);
          $("#cepEdit").val(data.cep);
          $("#logadouroEdit").val(data.logadouro);
          $("#numeroEdit").val(data.numero);
          $("#bairroEdit").val(data.bairro);
          $("#cidadeEdit").val(data.cidade);
          $("#estadoEdit").val(data.estado);
          $("#complementoEdit").val(data.complemento);
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
        razao: { required: true},
        cpfcnpj: { required: true},
        contato1: { required: true},
        cep: { required: true},
        logadouro: { required: true},
        numero: { required: true},
        bairro: { required: true},
        cidade: { required: true},
        estado: { required: true}
      },
      messages: {
        nome : { required: 'Preencha este campo' },
        razao: { required: 'Preencha este campo' },
        cpfcnpj: { required: 'Preencha este campo' },
        contato1: { required: 'Preencha este campo' },
        cep: { required: 'Preencha este campo' },
        logadouro: { required: 'Preencha este campo' },
        numero: { required: 'Preencha este campo' },
        bairro: { required: 'Preencha este campo' },
        cidade: { required: 'Preencha este campo' },
        estado: { required: 'Preencha este campo' }
      },
      submitHandler: function( form ){
        var nome = $("#nomeEdit").val();
        var razao = $("#razaoEdit").val();
        var cpfcnpj = $("#cpfcnpjEdit").val();
        var contato1 = $("#contato1Edit").val();
        var contato2 = $("#contato2Edit").val();
        var cep = $("#cepEdit").val();
        var logadouro = $("#logadouroEdit").val();
        var numero = $("#numeroEdit").val();
        var bairro = $("#bairroEdit").val();
        var cidade = $("#cidadeEdit").val();
        var estado = $("#estadoEdit").val();
        var complemento = $("#complementoEdit").val();
        var id = $("#idUsuario").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>fornecedores.php",
          data: {'acao':'editar', 'nome': nome, 'razao': razao, 'cpfcnpj': cpfcnpj,'contato1': contato1,'contato2': contato2,'cep': cep,'logadouro': logadouro,'numero': numero,'bairro': bairro,'cidade': cidade,'estado': estado, 'complemento': complemento,'id': id},
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
          url: "<?php echo AJAX; ?>fornecedores.php",
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
          url: "<?php echo AJAX; ?>fornecedores.php",
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
        url : "<?php echo AJAX; ?>fornecedores.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#nomeView").html(data.nome);
          $("#razaoView").html(data.razao);
          $("#cpfcnpjView").html(data.cpfcnpj);
          $("#contato1View").html(data.contato1);
          $("#contato2View").html(data.contato2);
          $("#cepView").html(data.cep);
          $("#logadouroView").html(data.logadouro);
          $("#numeroView").html(data.numero);
          $("#bairroView").html(data.bairro);
          $("#cidadeView").html(data.cidade);
          $("#estadoView").html(data.estado);
          $("#complementoView").html(data.complemento);
          //$("#idUsuario").val(data.id);
          $("#moda_view").modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });
    });

     $(document).on('click', '#verificarcep',function() {
            var cep = $('#cep').val().replace(/[^\d]+/g,'');
            if(cep.length == 8){
            $(".carregandoCEP").fadeIn("slow");
              $.ajax({
                      type: "GET",
                      url: 'https://viacep.com.br/ws/'+cep+'/json/',
                      dataType: 'json',
                      success: function(dados) {
                        $(".carregandoCEP").fadeOut("fast");
                        if(dados.erro == true){
                          alert("CEP Não encontrado!");
                          $('#cep').val('');
                        }else{
                          $('#logadouro').val(dados.logradouro);
                          $('#bairro').val(dados.bairro);
                          $("#cidade" ).val(dados.localidade);
                          $("#estado" ).val(dados.uf); 
                        }
                          
                      }
              }); 
          }else{
            alert("CEP Invalido!");
              $('#cep').val('');
          }
    });

     $(document).on('click', '#verificarcepEdit',function() {
            var cep = $('#cepEdit').val().replace(/[^\d]+/g,'');
            if(cep.length == 8){
              $.ajax({
                      type: "GET",
                      url: 'https://viacep.com.br/ws/'+cep+'/json/',
                      dataType: 'json',
                      success: function(dados) {
                        if(dados.erro == true){
                          alert("CEP Não encontrado!");
                          $('#cep').val('');
                        }else{
                          $('#logadouroEdit').val(dados.logradouro);
                          $('#bairroEdit').val(dados.bairro);
                          $("#cidadeEdit" ).val(dados.localidade);
                          $("#estadoEdit" ).val(dados.uf); 
                        }
                          
                      }
              }); 
          }else{
            alert("CEP Invalido!");
              $('#cepEdit').val('');
          }
    });

     $(document).on("click",".btnviewbank",function(){
      var id_user = $(this).attr("id_user");
      var value = {
        id: id_user
      };
      $.ajax({
        url : "<?php echo AJAX; ?>fornecedores.php?acao=buscarContasBancarias",
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
          <strong>Fornecedores</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="mb20 col-sm-12 text-right">
          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar Fornecedor</button>
        </div>
        <table id="tabela" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th>Nome</th>
                <th>Endereço</th>
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
              <label>Nome</label>
              <input type="text" class="form-control" name="nome" id="nome">
            </div>
            <div class="form-group">
              <label>Razão Social</label>
              <input type="text" class="form-control" name="razao" id="razao">
            </div>
            <div class="form-group">
              <label>CPF/CNPJ</label>
              <input type="text" class="form-control" name="cpfcnpj" id="cpfcnpj">
            </div>
            <div class="form-group">
              <label>Telefone 1</label>
              <input type="text" class="form-control" name="contato1" id="contato1">
            </div>
            <div class="form-group">
              <label>Telefone 2</label>
              <input type="text" class="form-control" name="contato2" id="contato2">
            </div>
            <div class="form-group">
              <label>CEP</label>
              <div class="input-group">
                <input type="text" class="form-control" id="cep" name="cep">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" id="verificarcep">Buscar<div class="ripple-container"></div></button>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label>Logadouro</label>
              <input type="text" class="form-control" name="logadouro" id="logadouro" >
            </div>
            <div class="form-group">
              <label>Número</label>
              <input type="text" class="form-control" name="numero" id="numero">
            </div>
            <div class="form-group">
              <label>Complemento</label>
              <input type="text" class="form-control" name="complemento" id="complemento">
            </div>
            <div class="form-group">
              <label>Bairro</label>
              <input type="text" class="form-control" name="bairro" id="bairro" >
            </div>
            <div class="form-group">
              <label>Estado</label>
              <input type="text" name="estado" id="estado" class="form-control" >
            </div>
            <div class="form-group">
              <label>Cidade</label>
              <input type="text" name="cidade" id="cidade" class="form-control" >
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
              <label>Nome</label>
              <input type="text" class="form-control" name="nome" id="nomeEdit">
            </div>
            <div class="form-group">
              <label>Razão Social</label>
              <input type="text" class="form-control" name="razao" id="razaoEdit">
            </div>
            <div class="form-group">
              <label>CPF/CNPJ</label>
              <input type="text" class="form-control" name="cpfcnpj" id="cpfcnpjEdit">
            </div>
            <div class="form-group">
              <label>Telefone 1</label>
              <input type="text" class="form-control" name="contato1" id="contato1Edit">
            </div>
            <div class="form-group">
              <label>Telefone 2</label>
              <input type="text" class="form-control" name="contato2" id="contato2Edit">
            </div>
            <div class="form-group">
              <label>CEP</label>
              <div class="input-group">
                <input type="text" class="form-control" id="cepEdit" name="cep">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" id="verificarcepEdit">Buscar<div class="ripple-container"></div></button>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label>Logadouro</label>
              <input type="text" class="form-control" name="logadouro" id="logadouroEdit" >
            </div>
            <div class="form-group">
              <label>Número</label>
              <input type="text" class="form-control" name="numero" id="numeroEdit">
            </div>
            <div class="form-group">
              <label>Complemento</label>
              <input type="text" class="form-control" name="complemento" id="complementoEdit">
            </div>
            <div class="form-group">
              <label>Bairro</label>
              <input type="text" class="form-control" name="bairro" id="bairroEdit" >
            </div>
            <div class="form-group">
              <label>Estado</label>
              <input type="text" name="estado" id="estadoEdit" class="form-control" >
            </div>
            <div class="form-group">
              <label>Cidade</label>
              <input type="text" name="cidade" id="cidadeEdit" class="form-control" >
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
              <label>Nome</label>
              <p id="nomeView"></p>
            </div>
            <div class="form-group">
              <label>Razão Social</label>
              <p id="razaoView"></p>
            </div>
            <div class="form-group">
              <label>CPF/CNPJ</label>
              <p id="cpfcnpjView"></p>
            </div>
            <div class="form-group">
              <label>Telefone 1</label>
              <p id="contato1View"></p>
            </div>
            <div class="form-group">
              <label>Telefone 2</label>
              <p id="contato2View"></p>
            </div>
            <div class="form-group">
              <label>CEP</label>
              <p id="cepView"></p>
            </div>
            <div class="form-group">
              <label>Logadouro</label>
              <p id="logadouroView"></p>
            </div>
            <div class="form-group">
              <label>Número</label>
              <p id="numeroView"></p>
            </div>
            <div class="form-group">
              <label>Complemento</label>
              <p id="complementoView"></p>
            </div>
            <div class="form-group">
              <label>Bairro</label>
              <p id="bairroView"></p>
            </div>
            <div class="form-group">
              <label>Cidade</label>
              <p id="cidadeView"></p>
            </div>
            <div class="form-group">
              <label>Estado</label>
              <p id="estadoView"></p>
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