<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="<?php echo SITE ?>assets/js/vendor/summernote/lang-br.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

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
  $('#tabela').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": false,
    "responsive": true,
    "autoWidth": false,
    "pageLength": 10,
    "ajax": {
        "url": "<?php echo AJAX; ?>propostas.php?acao=buscar&nivel=<?php echo $_SESSION['nivelSession']; ?>&idRef=<?php echo $_SESSION['idSession']; ?>",
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
      { "data": "servico" },
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
        tipo: { required: true},
        servico: { required: true},
        // proposta: { required: true},
        // observacoes: { required: true},
        // garantiaEquipamento: { required: true},
        // garantiaMaoObra: { required: true},
        // prazoEntrega: { required: true},
        // valorMaterial: { required: true},
        // valorMaoObra: { required: true},
        // valorAdicional: { required: true},
        // entrada: { required: true},
        // valorEntrada: { required: true},
        // saldo: { required: true},
        // status: { required: true},
      },
      messages: {
        tipo : { required: 'Preencha este campo'},
        servico : { required: 'Preencha este campo'},
        // proposta : { required: 'Preencha este campo'},
        // observacoes : { required: 'Preencha este campo'},
        // garantiaEquipamento : { required: 'Preencha este campo'},
        // garantiaMaoObra : { required: 'Preencha este campo'},
        // prazoEntrega : { required: 'Preencha este campo'},
        // valorMaterial : { required: 'Preencha este campo'},
        // valorMaoObra : { required: 'Preencha este campo'},
        // valorAdicional : { required: 'Preencha este campo'},
        // entrada : { required: 'Preencha este campo'},
        // valorEntrada : { required: 'Preencha este campo'},
        // saldo : { required: 'Preencha este campo'},
        // status : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var tipo = $("#tipo").val();
        var cliente = $("#cliente").val();
        var contato = $("#contato").val();
        var servico = $("#servico").val();
        var proposta = $("#proposta").val();
        var observacoes = $("#observacoes").val();
        var garantiaEquipamento = $("#garantiaEquipamento").val();
        var garantiaMaoObra = $("#garantiaMaoObra").val();
        var prazoEntrega = $("#prazoEntrega").val();
        var valorMaterial = $("#valorMaterial").val();
        var valorMaoObra = $("#valorMaoObra").val();
        var valorAdicional = $("#valorAdicional").val();
        var entrada = $("#entrada").val();
        var valorEntrada = $("#valorEntrada").val();
        var saldo = $("#saldo").val();
        var status = $("#status").val();
        var idRef = <?php echo $idRef; ?>;
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>propostas.php",
          data: {'acao':'cadastrar', 'cliente': cliente, 'servico': servico, 'proposta': proposta,'observacoes': observacoes, 'garantiaEquipamento': garantiaEquipamento, 'garantiaMaoObra': garantiaMaoObra, 'prazoEntrega': prazoEntrega, 'valorMaterial': valorMaterial, 'valorMaoObra': valorMaoObra, 'valorAdicional': valorAdicional, 'entrada': entrada, 'valorEntrada': valorEntrada, 'saldo': saldo,'status': status,'tipo': tipo,'contato': contato, 'idRef': idRef  },
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
        url : "<?php echo AJAX; ?>propostas.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#clienteEdit").val(data.cliente);
          $("#servicoEdit").summernote('code', data.servico);
          $("#propostaEdit").summernote('code', data.proposta);
          $("#observacoesEdit").summernote('code', data.observacoes);
          $("#garantiaEquipamentoEdit").val(data.garantiaEquipamento);
          $("#garantiaMaoObraEdit").val(data.garantiaMaoObra);
          $("#prazoEntregaEdit").val(data.prazoEntrega);
          $("#valorMaterialEdit").val(data.valorMaterial);
          $("#valorMaoObraEdit").val(data.valorMaoObra);
          $("#valorAdicionalEdit").val(data.valorAdicional);
          $("#entradaEdit").val(data.entrada);
          $("#valorEntradaEdit").val(data.valorEntrada);
          $("#saldoEdit").val(data.saldo);
          $("#statusEdit").val(data.status);
          $("#tipoEdit").val(data.tipo);
          $("#contatoEdit").val(data.contato);
          mudartipo(data.tipo);
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
        servico: { required: true},
        // proposta: { required: true},
        // observacoes: { required: true},
        // garantiaEquipamento: { required: true},
        // garantiaMaoObra: { required: true},
        // prazoEntrega: { required: true},
        // valorMaterial: { required: true},
        // valorMaoObra: { required: true},
        // valorAdicional: { required: true},
        // entrada: { required: true},
        // valorEntrada: { required: true},
        // saldo: { required: true},
        // status: { required: true},
      },
      messages: {
        tipo : { required: 'Preencha este campo'},
        servico : { required: 'Preencha este campo'},
        // proposta : { required: 'Preencha este campo'},
        // observacoes : { required: 'Preencha este campo'},
        // garantiaEquipamento : { required: 'Preencha este campo'},
        // garantiaMaoObra : { required: 'Preencha este campo'},
        // prazoEntrega : { required: 'Preencha este campo'},
        // valorMaterial : { required: 'Preencha este campo'},
        // valorMaoObra : { required: 'Preencha este campo'},
        // valorAdicional : { required: 'Preencha este campo'},
        // entrada : { required: 'Preencha este campo'},
        // valorEntrada : { required: 'Preencha este campo'},
        // saldo : { required: 'Preencha este campo'},
        // status : { required: 'Preencha este campo'},
      },
      submitHandler: function( form ){
        var tipo = $("#tipoEdit").val();
        var cliente = $("#clienteEdit").val();
        var contato = $("#contatoEdit").val();
        var servico = $("#servicoEdit").val();
        var proposta = $("#propostaEdit").val();
        var observacoes = $("#observacoesEdit").val();
        var garantiaEquipamento = $("#garantiaEquipamentoEdit").val();
        var garantiaMaoObra = $("#garantiaMaoObraEdit").val();
        var prazoEntrega = $("#prazoEntregaEdit").val();
        var valorMaterial = $("#valorMaterialEdit").val();
        var valorMaoObra = $("#valorMaoObraEdit").val();
        var valorAdicional = $("#valorAdicionalEdit").val();
        var entrada = $("#entradaEdit").val();
        var valorEntrada = $("#valorEntradaEdit").val();
        var saldo = $("#saldoEdit").val();
        var status = $("#statusEdit").val();
        var id = $("#idUsuario").val();
        $.ajax({
          type: "GET",
          url: "<?php echo AJAX; ?>propostas.php",
          data: {'acao':'editar', 'cliente': cliente, 'servico': servico, 'proposta': proposta,'observacoes': observacoes, 'garantiaEquipamento': garantiaEquipamento, 'garantiaMaoObra': garantiaMaoObra, 'prazoEntrega': prazoEntrega, 'valorMaterial': valorMaterial, 'valorMaoObra': valorMaoObra, 'valorAdicional': valorAdicional, 'entrada': entrada, 'valorEntrada': valorEntrada, 'saldo': saldo,'status': status,'tipo': tipo,'contato': contato,'id': id},
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
          url: "<?php echo AJAX; ?>propostas.php",
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
          url: "<?php echo AJAX; ?>propostas.php",
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
      var valorMaterial = $('#valorMaterial').val();
      var valorMaoObra = $('#valorMaoObra').val();
      var entrada = $('#entrada').val();
      if($(this).length >= 1){
        var valorTotal = parseFloat(valorMaterial) + parseFloat(valorMaoObra);
        var valorEntrada = (parseFloat(valorTotal) * (parseFloat(entrada)) / 100);
        $('#valorAdicional').val(valorTotal);
        $('#valorEntrada').val(valorEntrada);
      }else{
        $('#valorAdicional').html('');
      } 
    });

     $(".somaEdit").keyup(function(){ 
      var valorMaterial = $('#valorMaterialEdit').val();
      var valorMaoObra = $('#valorMaoObraEdit').val();
      var entrada = $('#entradaEdit').val();
      if($(this).length >= 1){
        var valorTotal = parseFloat(valorMaterial) + parseFloat(valorMaoObra);
        var valorEntrada = (parseFloat(valorTotal) * (parseFloat(entrada)) / 100);
        $('#valorAdicionalEdit').val(valorTotal);
        $('#valorEntradaEdit').val(valorEntrada);
      }else{
        $('#valorAdicionalEdit').html('');
      } 
    });

     $(document).on("click",".btnview",function(){
      var id_user = $(this).attr("id_user");
      var value = {
        id: id_user
      };
      $.ajax({
        url : "<?php echo AJAX; ?>propostas.php?acao=buscarDados",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $("#clienteView").html(data.clienteView);
          $("#servicoView").html(data.servico);
          $("#propostaView").html(data.proposta);
          $("#observacoesView").html(data.observacoes);
          $("#garantiaEquipamentoView").html(data.garantiaEquipamento);
          $("#garantiaMaoObraView").html(data.garantiaMaoObra);
          $("#prazoEntregaView").html(data.prazoEntrega);
          $("#valorMaterialView").html(data.valorMaterial);
          $("#valorMaoObraView").html(data.valorMaoObra);
          $("#valorAdicionalView").html(data.valorAdicional);
          $("#entradaView").html(data.entrada);
          $("#valorEntradaView").html(data.valorEntrada);
          $("#saldoView").html(data.saldo);
          $("#statusView").html(data.statusView);
          $('#btnImprimir').html('<a href="<?php echo SITE.'propostas/imprimirpdf/';?>'+data.id+'" class="btn btn-raised btn-default" target="_blank"><i class="fa fa-print"></i> PDF</a>');
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
      window.open("<?php echo SITE;?>propostas/imprimirpdf/"+id_user);
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

     // adicionar produtos
       // adicionar unser
    $(document).on("click",".btnaddproduto",function(){
      var id_user = $(this).attr("id_user");
      $("#moda_add_produtos").modal("show");
      $("#idProposta").val(id_user);
    });

    $(".add-row").click(function(){
        var variaveis = $('#produto').val().split('&'); 
        var idProduto = variaveis[0];
        var codigo = variaveis[1];
        var descricao = variaveis[2];
        var preco = variaveis[3];

        var markup = "<tr><td><input type='hidden' class='idProduto input2' name='idProduto' value='"+idProduto+"'><input type='checkbox' name='record'></td><td>"+codigo+"</td><td>"+descricao+"</td><td><input type='text' class='form-control quantidade'></td><td class='preco'>"+preco+"</td><td><input type='text' class='form-control valor' name='valorGanho' data-idProduto='"+idProduto+"'></td></tr>";
        $("table tbody").append(markup);
        $('.valor').maskMoney({thousands:'', decimal:'.'});

    });

    // Find and remove selected table rows
    $(".delete-row").click(function(){
        $("table tbody").find('input[name="record"]').each(function(){
          if($(this).is(":checked")){
            $(this).parents("tr").remove();
          }
        });
    });

    $('#formCadastrarProduto').validate({
      submitHandler: function( form ){

        console.log($('.input2').serializeArray());
        
        var id = $("#idProposta").val();
        var idRef = <?php echo $idRef; ?>;
      //   $.ajax({
      //     type: "GET",
      //     url: "<?php echo AJAX; ?>ordemservicos.php",
      //     data: {'acao':'adicionarAndamento',  'observacoesAnda': observacoesAnda,'dataAnda': dataAnda,'porcentagemAnda': porcentagemAnda, 'id': id, 'idRef': idRef},
      //     dataType: 'json',
      //     success: function(res) {
      //       if(res.status == 200){
      //        swal({   
      //           title: "Adicionado com Sucesso",  
      //           type: "success",   
      //           showConfirmButton: false,
      //            });
      //          window.setTimeout(function(){
      //              $('#formCadastrarAnda input').val(""); 
      //              swal.close();
      //               var table = $('#tabela').DataTable(); 
      //               table.ajax.reload( null, false );
      //               $("#moda_plus").modal("hide");
      //         } ,2500);
      //     }else{
      //       swal({   
      //           title: "Error",  
      //           type: "error",   
      //           showConfirmButton: false,
      //            });
      //          window.setTimeout(function(){
      //              swal.close();
      //         } ,2500);
      //     }
      // }
      //   });
        return false;
      }
    });
 }); 

 function mudartipo(tipo){
  var tipo = tipo;
  $('.esconder').addClass('hide');
  //$('.limpar').val('');
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
          <strong>Propostas</strong></h3>
      </div>
      <div class="boxs-body">
        <div class="mb20 col-sm-12 text-right">
          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar uma Proposta</button>
        </div>
        <table id="tabela" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th width="5%">Nº</th>
                <th>Cliente</th>
                <th>Serviço</th>
                <th>Status</th>
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
              <label>Tipo</label>
              <select tabindex="3" class="form-control" id="tipo" name="tipo">
                  <option value="">Selecione um Tipo</option>
                  <option value="1">Cliente</option>
                  <option value="2">Contato</option>
              </select>
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
              <label>Contatos</label>
              <select tabindex="3" class="form-control limpar" id="contato" name="contato">
                  <option value="">Selecione um Contato</option>
                  <?php while($contato = mysqli_fetch_object($classe->resultado[2])): ?>
                    <option value="<?php echo $contato->id; ?>"><?php echo $contato->nome." - ".$contato->contato1; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Serviço</label>
              <textarea class="summernote" id="servico" name="servico"></textarea>
            </div>
            <div class="form-group">
              <label>Detalhes da Proposta</label>
              <textarea class="summernote" id="proposta" name="proposta"></textarea>
            </div>
            <div class="form-group">
              <label>Observações</label>
              <textarea class="summernote" id="observacoes" name="observacoes"></textarea>
            </div>
            <div class="form-group">
                <label>Garantia Equipamento</label>
                <div class="input-group bootstrap-touchspin">
                    <input type="text" class="form-control" style="display: block;" id="garantiaEquipamento" name="garantiaEquipamento" value="12">
                    <span class="input-group-addon bootstrap-touchspin-prefix">meses</span>
                </div>
            </div>
            <div class="form-group">
                <label>Garantia Mão de Obra</label>
                <div class="input-group bootstrap-touchspin">
                    <input type="text" class="form-control" style="display: block;" id="garantiaMaoObra" name="garantiaMaoObra" value="3">
                    <span class="input-group-addon bootstrap-touchspin-prefix">meses</span>
                </div>
            </div>
             <div class="form-group">
                <label>Prazo de Entrega</label>
                <div class="input-group bootstrap-touchspin">
                    <input type="text" class="form-control" style="display: block;" id="prazoEntrega" name="prazoEntrega">
                    <span class="input-group-addon bootstrap-touchspin-prefix">dias</span>
                </div>
            </div>
            <div class="form-group">
                <label>Materiais e insumos</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control valor soma" style="display: block;" id="valorMaterial" name="valorMaterial">
                </div>
            </div>
            <div class="form-group">
                <label>Mão de obra especializada</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control valor soma" style="display: block;" id="valorMaoObra" name="valorMaoObra" value="0">
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
                <label>Condições de pagamento</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">Entrada de</span>
                    <input type="text" class="form-control soma" style="display: block;" id="entrada" name="entrada" value="30">
                    <span class="input-group-addon bootstrap-touchspin-prefix">% do valor, no ato da aprovação</span>
                </div>
            </div>
            <div class="form-group">
                <label>Valor da Entrada</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">Valor da entrada R$</span>
                    <input type="text" class="form-control" style="display: block;" id="valorEntrada" name="valorEntrada" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label>Condições de pagamento</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">Saldo</span>
                    <input type="text" class="form-control " style="display: block;" id="saldo" name="saldo" value="7">
                    <span class="input-group-addon bootstrap-touchspin-prefix">dias após o término</span>
                </div>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select tabindex="3" class="form-control" id="status" name="status">
                  <option value="">Selecione um Status</option>
                  <option value="1" selected>Em criação</option>
                  <option value="2">Enviada</option>
                  <option value="3">Aprovada</option>
                  <option value="4">Reprovada</option>
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
                  <option value="2">Contato</option>
              </select>
            </div>
            <div class="form-group hide esconder" id="espclienteEdit">
              <label>Cliente</label>
              <select tabindex="3" class="form-control limpar" id="clienteEdit" name="cliente">
                  <option value="">Selecione um Cliente</option>
                  <?php while($cliente = mysqli_fetch_object($classe->resultado[1])): ?>
                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nome; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
             <div class="form-group hide esconder" id="espfornecedorEdit">
              <label>Contatos</label>
              <select tabindex="3" class="form-control limpar" id="contatoEdit" name="contato">
                  <option value="">Selecione um Contato</option>
                  <?php while($contato = mysqli_fetch_object($classe->resultado[3])): ?>
                    <option value="<?php echo $contato->id; ?>"><?php echo $contato->nome." - ".$contato->contato1; ?></option>
                  <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Serviço</label>
              <textarea class="summernote" id="servicoEdit" name="servico"></textarea>
            </div>
            <div class="form-group">
              <label>Detalhes da Proposta</label>
              <textarea class="summernote" id="propostaEdit" name="proposta"></textarea>
            </div>
            <div class="form-group">
              <label>Observações</label>
              <textarea class="summernote" id="observacoesEdit" name="observacoes"></textarea>
            </div>
            <div class="form-group">
                <label>Garantia Equipamento</label>
                <div class="input-group bootstrap-touchspin">
                    <input type="text" class="form-control" style="display: block;" id="garantiaEquipamentoEdit" name="garantiaEquipamento" value="12">
                    <span class="input-group-addon bootstrap-touchspin-prefix">meses</span>
                </div>
            </div>
            <div class="form-group">
                <label>Garantia Mão de Obra</label>
                <div class="input-group bootstrap-touchspin">
                    <input type="text" class="form-control" style="display: block;" id="garantiaMaoObraEdit" name="garantiaMaoObra" value="3">
                    <span class="input-group-addon bootstrap-touchspin-prefix">meses</span>
                </div>
            </div>
             <div class="form-group">
                <label>Prazo de Entrega</label>
                <div class="input-group bootstrap-touchspin">
                    <input type="text" class="form-control" style="display: block;" id="prazoEntregaEdit" name="prazoEntrega">
                    <span class="input-group-addon bootstrap-touchspin-prefix">dias</span>
                </div>
            </div>
            <div class="form-group">
                <label>Materiais e insumos</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control valor somaEdit" style="display: block;" id="valorMaterialEdit" name="valorMaterial">
                </div>
            </div>
            <div class="form-group">
                <label>Mão de obra especializada</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">R$</span>
                    <input type="text" class="form-control valor somaEdit" style="display: block;" id="valorMaoObraEdit" name="valorMaoObra" value="0">
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
                <label>Condições de pagamento</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">Entrada de</span>
                    <input type="text" class="form-control somaEdit" style="display: block;" id="entradaEdit" name="entrada" value="30">
                    <span class="input-group-addon bootstrap-touchspin-prefix">% do valor, no ato da aprovação</span>
                </div>
            </div>
            <div class="form-group">
                <label>Valor da Entrada</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">Valor da entrada R$</span>
                    <input type="text" class="form-control" style="display: block;" id="valorEntradaEdit" name="valorEntrada" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label>Condições de pagamento</label>
                <div class="input-group bootstrap-touchspin">
                    <span class="input-group-addon bootstrap-touchspin-prefix">Saldo</span>
                    <input type="text" class="form-control " style="display: block;" id="saldoEdit" name="saldo" value="7">
                    <span class="input-group-addon bootstrap-touchspin-prefix">dias após o término</span>
                </div>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select tabindex="3" class="form-control" id="statusEdit" name="status">
                  <option value="">Selecione um Status</option>
                  <option value="1" selected>Em criação</option>
                  <option value="2">Enviada</option>
                  <option value="3">Aprovada</option>
                  <option value="4">Reprovada</option>
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
              <label>Impressões</label><br>
              <span id="btnImprimir"></span>
            </div>
          <div class="form-group">
              <label>Cliente</label>
              <p id="clienteView"></p>
            </div>
            <div class="form-group">
              <label>Serviço</label>
              <p id="servicoView"></p>
            </div>
            <div class="form-group">
              <label>Detalhes da Proposta</label>
              <p id="propostaView"></p>
            </div>
            <div class="form-group">
              <label>Observações</label>
              <p id="observacoesView"></p>
            </div>
            <div class="form-group">
                <label>Garantia Equipamento</label>
                <div class="input-group bootstrap-touchspin">
                    <span id="garantiaEquipamentoView"></span>
                    <span> meses</span>
                </div>
            </div>
            <div class="form-group">
                <label>Garantia Mão de Obra</label>
                <div class="input-group bootstrap-touchspin">
                    <spam id="garantiaMaoObraView"></spam>
                    <span> meses</span>
                </div>
            </div>
             <div class="form-group">
                <label>Prazo de Entrega</label>
                <div class="input-group bootstrap-touchspin">
                    <span id="prazoEntregaView"></span>
                    <span > dias</span>
                </div>
            </div>
            <div class="form-group">
                <label>Materiais e insumos</label>
                <div class="input-group bootstrap-touchspin">
                    <span>R$ </span>
                    <span id="valorMaterialView"></span>
                </div>
            </div>
            <div class="form-group">
                <label>Mão de obra especializada</label>
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
                <label>Condições de pagamento</label>
                <div class="input-group bootstrap-touchspin">
                    <span>Entrada de </span>
                    <span id="entradaView"></span>
                    <span > % do valor, no ato da aprovação</span>
                </div>
            </div>
            <div class="form-group">
                <label>Valor da Entrada</label>
                <div class="input-group bootstrap-touchspin">
                    <span>Valor da entrada R$ </span>
                    <span id="valorEntradaView">
                </div>
            </div>
            <div class="form-group">
                <label>Condições de pagamento</label>
                <div class="input-group bootstrap-touchspin">
                    <span>Saldo </span>
                    <span id="saldoView"></span>
                    <span > dias após o término</span>
                </div>
            </div>
            <div class="form-group">
              <label>Status</label>
              <p id="statusView"></p>
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

     <div id="moda_add_produtos" class="modal fade">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Adicionar Produtos</h4>
        </div>
        <!--modal header-->
        <div class="modal-body">
          <form role="form" id="formCadastrarProduto">
            <div class="form-group">
              <div class="input-group mb-10">
                  <select tabindex="3" class="form-control limpar" id="produto" name="produto">
                      <option value="">Selecione um Produto</option>
                      <?php while($produto = mysqli_fetch_object($classe->resultado[4])): ?>
                        <option value="<?php echo $produto->id."&".$produto->codigo."&".$produto->descricao."&".$produto->preco; ?>"><?php echo $produto->codigo." - ".$produto->descricao." - ".$produto->preco; ?></option>
                      <?php endwhile; ?>
                  </select>
                  <span class="input-group-btn">
                      <button class="btn btn-raised btn-success add-row" type="button">Adicionar<div class="ripple-container"></div></button>
                  </span>
              </div>
              <table class="table">
              <thead>
                <tr>
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Produto</th>
                    <th>Qnt.</th>
                    <th>Preco</th>
                    <th>Ganho</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              </table>
              <button type="button" class="btn btn-raised btn-primary btn-sm delete-row">Deletar produto</button>
            </div>
            <input type="hidden" name="idProposta" id="idProposta" value="">
        <div class="modal-footer">
          <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-raised btn-primary">Cadastrar</button>
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
