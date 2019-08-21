<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script type="text/javascript">
$(document).ready( function () {
  
  $('.valor').maskMoney({thousands:'', decimal:'.'});

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
        "url": "<?php echo AJAX; ?>produtos.php?acao=buscar",
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
      { "data": "codigo" },
      { "data": "descricao" },
      { "data": "marcamodelo" },
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
        codigo : { required: true},
        marca : { required: true},
        descricao : { required: true},
        valorProduto: { required: true }
      },
      messages: {
        codigo : { required: 'Preencha este campo' },
        marca : { required: 'Preencha este campo' },
        descricao : { required: 'Preencha este campo' },
        valorProduto : { required: 'Preencha este campo' },
      },
      submitHandler: function( form ){
        var codigo = $("#codigo").val();
        var marca = $("#marca").val();
        var descricao = $("#descricao").val();
        var valorProduto = $('#valorProduto').val();
        var idRef = <?php echo $idRef; ?>;
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>produtos.php",
          data: {'acao':'cadastrar', 'codigo': codigo, 'marca': marca, 'descricao': descricao, 'valorProduto': valorProduto ,'idRef':idRef},
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
        url : "<?php echo AJAX; ?>produtos.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#codigoEdit").val(data.codigo);
          $("#marcaEdit").val(data.marcamodelo);
          $("#descricaoEdit").val(data.descricao);
          $('#valorProdutoEdit').val(data.preco);
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
        codigo : { required: true},
        marca : { required: true},
        descricao : { required: true},
        valorProduto: { required: true }
      },
      messages: {
        codigo : { required: 'Preencha este campo' },
        marca : { required: 'Preencha este campo' },
        descricao : { required: 'Preencha este campo' },
        valorProduto : { required: 'Preencha este campo' },
      },
      submitHandler: function( form ){
        var codigo = $("#codigoEdit").val();
        var marca = $("#marcaEdit").val();
        var descricao = $("#descricaoEdit").val();
        var valorProduto = $("#valorProdutoEdit").val();
        var id = $("#idUsuario").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>produtos.php",
          data: {'acao':'editar', 'codigo': codigo, 'marca': marca, 'descricao': descricao, 'valorProduto': valorProduto, 'id': id},
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
          url: "<?php echo AJAX; ?>produtos.php",
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
          url: "<?php echo AJAX; ?>produtos.php",
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
        url : "<?php echo AJAX; ?>produtos.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#codigoView").html(data.codigo);
          $("#marcaView").html(data.marcamodelo);
          $("#descricaoView").html(data.descricao);
          $("#valorProdutoView").html('R$ '+data.preco);
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
          <strong>Produtos</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="mb20 col-sm-12 text-right">
          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar Produto</button>
        </div>
        <table id="tabela" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th width="7%">Cod</th>
                <th>Descrição</th>
                <th>Marca / Modelo</th>
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
              <label>Codigo</label>
              <input type="text" class="form-control" name="codigo" id="codigo">
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <textarea name="descricao" id="descricao" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label>Marca / Modelo</label>
              <input type="text" class="form-control" name="marca" id="marca">
            </div>
            <div class="form-group">
              <label>Valor Produto</label>
              <div class="input-group bootstrap-touchspin">
                  <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                  <input type="text" class="form-control valor" style="display: block;" id="valorProduto" name="valorProduto">
              </div>
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
              <label>Codigo</label>
              <input type="text" class="form-control" name="codigo" id="codigoEdit">
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <textarea name="descricao" id="descricaoEdit" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label>Marca / Modelo</label>
              <input type="text" class="form-control" name="marca" id="marcaEdit">
            </div>
            <div class="form-group">
              <label>Valor Produto</label>
              <div class="input-group bootstrap-touchspin">
                  <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                  <input type="text" class="form-control valor" style="display: block;" id="valorProdutoEdit" name="valorProduto">
              </div>
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
              <label>Codigo</label>
              <p id="codigoView"></p>
            </div>
            <div class="form-group">
              <label>Descrição</label>
              <p id="descricaoView"></p>
            </div>
            <div class="form-group">
              <label>Marca / Modelo</label>
              <p id="marcaView"></p>
            </div>
            <div class="form-group">
              <label>Valor Produto</label>
              <p id="valorProdutoView"></p>
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
