<!-- arquivos -->
<script src="<?php echo SITE; ?>assets/js/vendor/filestyle/bootstrap-filestyle.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="<?php echo SITE ?>assets/js/vendor/summernote/lang-br.js"></script> 
<!-- fim -->
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

    var maskcpfcnpj = function (val) {

      return val.replace(/\D/g, '').length > 14 ? '000.000.000-000' : '00.000.000/0000-00';

    },

    optionscpfcnpj = { onKeyPress: function(val, e, field, optionscpfcnpj) {

            field.mask(maskcpfcnpj.apply({}, arguments), optionscpfcnpj);

        }

    };

    // mascara cpf cnpj

    // var maskcpfcnpj = {

    //   onKeyPress : function(cpfcnpj, e, field, options) {

    //     var masks = ['000.000.000-000', '00.000.000/0000-00'];

    //     var mask = (cpfcnpj.length > 14) ? masks[1] : masks[0];

    //      $('#cpfcnpj').mask(mask, maskcpfcnpj);

    //      $('#cpfcnpjEdit').mask(mask, maskcpfcnpj);

    //   }

    // };



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

			  "url": "<?php echo AJAX; ?>clientes.php?acao=buscar",

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

          url: "<?php echo AJAX; ?>clientes.php",

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

        url : "<?php echo AJAX; ?>clientes.php?acao=buscarDados",

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

          url: "<?php echo AJAX; ?>clientes.php",

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

          url: "<?php echo AJAX; ?>clientes.php",

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

          url: "<?php echo AJAX; ?>clientes.php",

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

        url : "<?php echo AJAX; ?>clientes.php?acao=buscarDados",

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

          //$("#idUsuario").html(data.id);

          $("#moda_view").modal('show');

        },

        error: function(jqXHR, textStatus, errorThrown)

        {

          swal("Error!", textStatus, "error");

        }

      });

    });



     // $("#estado").change(function(){

     //    var estado = $("#estado").val();

     //    $.getJSON("<?php echo AJAX; ?>clientes.php?acao=buscarCidades", {estado: estado}, function(retorno){

     //      var items = [];

     //      $.each(retorno, function(conta, valor) {

     //        items.push('<option value="' + valor.nome + '">' + valor.nome + '</option>');

     //      });

     //      $('#cidade').html('<optgroup label="Cidades disponíveis">'+items.join('')+'</optgroup>');

     //    });



     //  });



     // $("#estadoEdit").change(function(){

     //    var estado = $("#estadoEdit").val();

     //    $.getJSON("<?php echo AJAX; ?>clientes.php?acao=buscarCidades", {estado: estado}, function(retorno){

     //      var items = [];

     //      $.each(retorno, function(conta, valor) {

     //        items.push('<option value="' + valor.nome + '">' + valor.nome + '</option>');

     //      });

     //      $('#cidadeEdit').html('<optgroup label="Cidades disponíveis">'+items.join('')+'</optgroup>');

     //    });



     //  });



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



 });  

</script>

<!--=====================================

=            Section comment            =

======================================-->



<!-- include summernote css/js -->

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">

<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

<script src="<?php echo SITE ?>assets/js/vendor/summernote/lang-br.js"></script> 

<script type="text/javascript">

$(document).ready( function () {



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



      // adicionar unser

    $(document).on("click","#btnadddados",function(){

        $("#modal_add_dados").modal("show");

    });



     $('#formCadastrarDados').validate({

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

        var nome = $("#nomeDados").val();

        var equipamento = $("#equipamentoDados").val();

        var cliente = $("#clienteDados").val();

        var serial = $("#serialDados").val();

        var portainicio = $("#portainicioDados").val();

        var portafim = $("#portafimDados").val();

        var senharemoto = $("#senharemotoDados").val();

        var usuario = $("#usuarioDados").val();

        var senha = $("#senhaDados").val();

        var responsavel = $("#responsavelDados").val();

        var observacoes = $("#observacoesDados").val();

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

                   $('#formCadastrarDados input').val(""); 

                   swal.close();

                    var table = $('#tabela').DataTable(); 

                    table.ajax.reload( null, false );

                    var tableDados = $('#tabelaDados').DataTable(); 

                    tableDados.ajax.reload( null, false );

                    $("#modal_add_dados").modal("hide");

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

    $(document).on("click",".btneditdados",function(){



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

          $("#nomeDadosEdit").val(data.nome);

          $("#equipamentoDadosEdit").val(data.equipamento);

          $("#clienteDadosEdit").val(data.cliente);

          $("#serialDadosEdit").val(data.serial);

          $("#portainicioDadosEdit").val(data.portainicio);

          $("#portafimDadosEdit").val(data.portafim);

          $("#senharemotoDadosEdit").val(data.senharemoto);

          $("#usuarioDadosEdit").val(data.usuario);

          $("#senhaDadosEdit").val(data.senha);

          $("#observacoesDadosEdit").summernote('code', data.observacoes);

          $("#responsavelDadosEdit").val(data.responsavel);

          $("#idUsuarioDados").val(data.id);

          $("#moda_edit_dados").modal('show');

        },

        error: function(jqXHR, textStatus, errorThrown)

        {

          swal("Error!", textStatus, "error");

        }

      });

    });



    $('#formCadastrarDadosEdit').validate({

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

        var nome = $("#nomeDadosEdit").val();

        var equipamento = $("#equipamentoDadosEdit").val();

        var cliente = $("#clienteDadosEdit").val();

        var serial = $("#serialDadosEdit").val();

        var portainicio = $("#portainicioDadosEdit").val();

        var portafim = $("#portafimDadosEdit").val();

        var senharemoto = $("#senharemotoDadosEdit").val();

        var usuario = $("#usuarioDadosEdit").val();

        var senha = $("#senhaDadosEdit").val();

        var observacoes = $("#observacoesDadosEdit").val();

        var responsavel = $("#responsavelDadosEdit").val();

        var id = $("#idUsuarioDados").val();

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

                   $('#formCadastrarDadosEdit input').val(""); 

                   swal.close();

                    var table = $('#tabela').DataTable(); 

                    table.ajax.reload( null, false );

                    var tableDados = $('#tabelaDados').DataTable(); 

                    tableDados.ajax.reload( null, false );

                    $("#moda_edit_dados").modal("hide");

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

     $(document).on( "click",".btndeldados", function() {

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

                    var tableDados = $('#tabelaDados').DataTable(); 

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

     // ativar usuarios

     $(document).on( "click",".btnativardados", function() {

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

                    var tableDados = $('#tabelaDados').DataTable(); 

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



      //abrir modal pra edição

    $(document).on("click",".btnviewdados",function(){

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

          $("#nomeDadosView").html(data.nome);

          $("#equipamentoDadosView").html(data.equipamentoView);

          $("#clienteDadosView").html(data.clienteView);

          $("#serialDadosView").html(data.serial);

          $("#portainicioDadosView").html(data.portainicio);

          $("#portafimDadosView").html(data.portafim);

          $("#senharemotoDadosView").html(data.senharemoto);

          $("#usuarioDadosView").html(data.usuario);

          $("#senhaDadosView").html(data.senha);

          $("#observacoesDadosView").html(data.observacoes);

          $("#responsavelDadosView").html(data.responsavelView);

          //$("#idUsuario").val(data.id);

          $("#moda_view_dados").modal('show');

        },

        error: function(jqXHR, textStatus, errorThrown)

        {

          swal("Error!", textStatus, "error");

        }

      });

    });



    $(document).on("click",".btnlistdados",function(){

      var id_user = $(this).attr("id_user");

      buscarDadosCliente(id_user);

    });

    $(document).on("click",".btnobs",function(){
      var id_user = $(this).attr("id_user");
      buscarObs(id_user);
    });

    $(document).on("click","#altObs",function(){
      var id_user = $("#idUsuarioObs").val();
      var observacao = $('#observacao').val();
      var value = {
        id: id_user,
        obs: observacao
      };
      $.ajax({
        url : "<?php echo AJAX; ?>clientes.php?acao=altObs",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          if(data.status == 200){
             swal({   
                title: "Alterado com Sucesso",  
                type: "success",   
                showConfirmButton: false,
                 });
               window.setTimeout(function(){ 
                   swal.close();
                   $("#modal_obs").modal("hide");
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
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });
    });

 }); 


//carregar observacoes cliente
function buscarObs(id){
  var id_user = id;
      var value = {
        id: id_user
      };
      $.ajax({
        url : "<?php echo AJAX; ?>clientes.php?acao=buscarObs",
        type: "GET",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          $('#observacao').summernote('code', data.observacoes);
          $("#idUsuarioObs").val(data.id);
          $("#modal_obs").modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal("Error!", textStatus, "error");
        }
      });
}


// função carregar dados tecnicos cliente

 function buscarDadosCliente(id) {

  var idCliente = id;

  $('#tabelaDados').DataTable({

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

        "url": "<?php echo AJAX; ?>dadostecnicos.php?acao=buscar&idCliente="+idCliente,

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

  //funcao pra carregar arquivos
  $("#moda_view_dados_tabela").modal('show');

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
          url: "<?php echo AJAX; ?>clientes.php",
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
        "url": "<?php echo AJAX; ?>clientes.php?acao=buscarArquivos&idCliente="+idCliente,
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



<!--====  End of Section comment  ====-->



<section id="content">

  <div class="page col-md-12">   

    <section class="boxs">

      <div class="boxs-header">

        <h3 class="custom-font hb-cyan">

          <strong>Clientes</strong></h3>

      </div>

      <div class="boxs-body">

        <div class="mb20 col-sm-12 text-right">

          <button type="submit" class="btn btn-raised  btn-success " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Adicionar Cliente</button>

          <button type="submit" class="btn btn-raised  btn-primary " id="btnadddados" name="btnadddados"><i class="fa fa-plus"></i> Adicionar Dados Técnicos</button>

        </div>

        <table id="tabela" class="table table-striped table-bordered table-hover">

            <thead>

              <tr class="tableheader">

                
                <th>ID</th>
                
                <th>Nome</th>

                <th>Endereço</th>

                <th width="19%">Ações</th>

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



    <!-- modal view -->

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

    <!-- fim modal view -->

</div>

<!--=====================================

=            Section comment            =

======================================-->

    <div id="moda_view_dados_tabela" class="modal fade">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">×</button>

          <h4 class="modal-title">Visualizar</h4>

        </div>

        <!--modal header-->

        <div class="modal-body">

          <table id="tabelaDados" class="table table-striped table-bordered table-hover">

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

        <div class="modal-footer">

          <button type="button" class="btn btn-raised btn-default" data-dismiss="modal">Fechar</button>

        </div>

        </div>

          <!--modal footer-->

        </div>

        <!--modal-content-->

      </div>

    <!--form-kantor-modal-->

<div id="modal_add_dados" class="modal fade">

    <div class="modal-dialog modal-md">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">×</button>

          <h4 class="modal-title">Adicionar Dados Tecnicos</h4>

        </div>

        <!--modal header-->

        <div class="modal-body">

          <form role="form" id="formCadastrarDados">

            <div class="form-group">

              <label>Equipamento</label>

              <select tabindex="3" class="form-control" id="equipamentoDados" name="equipamento">

                  <option value="">Selecione um equipamento</option>

                  <?php while($equipamento = mysqli_fetch_object($classe->resultado[0])): ?>

                    <option value="<?php echo $equipamento->id; ?>"><?php echo $equipamento->descricao; ?></option>

                  <?php endwhile; ?>

              </select>

            </div>

            <div class="form-group">

              <label>Local</label>

              <input type="text" class="form-control" name="nome" id="nomeDados">

            </div>

            <div class="form-group">

              <label>Cliente</label>

              <select tabindex="3" class="form-control" id="clienteDados" name="cliente">

                  <option value="">Selecione um Cliente</option>

                  <?php while($cliente = mysqli_fetch_object($classe->resultado[1])): ?>

                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nome; ?></option>

                  <?php endwhile; ?>

              </select>

            </div>

            <div class="form-group">

              <label>Serial / MAC / IP</label>

              <input type="text" class="form-control" name="serial" id="serialDados">

            </div>

            <div class="form-group">

              <label>Porta http inicio</label>

              <input type="text" class="form-control" name="portainicio" id="portainicioDados">

            </div>

            <div class="form-group">

              <label>Porta http fim</label>

              <input type="text" class="form-control" name="portafim" id="portafimDados">

            </div>

            <div class="form-group">

              <label>Senha acesso remoto</label>

              <input type="text" class="form-control" name="senharemoto" id="senharemotoDados">

            </div>

            <div class="form-group">

              <label>Usuário</label>

              <input type="text" class="form-control" name="usuario" id="usuarioDados">

            </div>

            <div class="form-group">

              <label>Senha</label>

              <input type="text" class="form-control" name="senha" id="senhaDados">

            </div>

            <div class="form-group">

              <label>Responsável</label>

              <select tabindex="3" class="form-control" id="responsavelDados" name="responsavel">

                  <option value="">Selecione um Responsavel</option>

                  <?php while($responsavel = mysqli_fetch_object($classe->resultado[2])): ?>

                    <option value="<?php echo $responsavel->id; ?>"><?php echo $responsavel->nome; ?></option>

                  <?php endwhile; ?>

              </select>

            </div>

            <div class="form-group">

              <label>Observações</label>

              <textarea name="observacoes" id="observacoesDados" class="form-control summernote" rows="3"></textarea>

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





    <div id="moda_edit_dados" class="modal fade">

    <div class="modal-dialog modal-md">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">×</button>

          <h4 class="modal-title">Editar Dados Tecnicos</h4>

        </div>

        <!--modal header-->

        <div class="modal-body">

          <form role="form" id="formCadastrarDadosEdit">

          <div class="form-group">

              <label>Equipamento</label>

              <select tabindex="3" class="form-control" id="equipamentoDadosEdit" name="equipamento">

                  <option value="">Selecione um equipamento</option>

                  <?php while($equipamentoEdit = mysqli_fetch_object($classe->resultado[3])): ?>

                    <option value="<?php echo $equipamentoEdit->id; ?>"><?php echo $equipamentoEdit->marcamodelo; ?></option>

                  <?php endwhile; ?>

              </select>

            </div>

            <div class="form-group">

              <label>Local</label>

              <input type="text" class="form-control" name="nome" id="nomeDadosEdit">

            </div>

            <div class="form-group">

              <label>Cliente</label>

              <select tabindex="3" class="form-control" id="clienteDadosEdit" name="cliente">

                  <option value="">Selecione um Cliente</option>

                  <?php while($clienteEdit = mysqli_fetch_object($classe->resultado[4])): ?>

                    <option value="<?php echo $clienteEdit->id; ?>"><?php echo $clienteEdit->nome; ?></option>

                  <?php endwhile; ?>

              </select>

            </div>

            <div class="form-group">

              <label>Serial / MAC / IP</label>

              <input type="text" class="form-control" name="serial" id="serialDadosEdit">

            </div>

            <div class="form-group">

              <label>Porta http inicio</label>

              <input type="text" class="form-control" name="portainicio" id="portainicioDadosEdit">

            </div>

            <div class="form-group">

              <label>Porta http fim</label>

              <input type="text" class="form-control" name="portafim" id="portafimDadosEdit">

            </div>

            <div class="form-group">

              <label>Senha acesso remoto</label>

              <input type="text" class="form-control" name="senharemoto" id="senharemotoDadosEdit">

            </div>

            <div class="form-group">

              <label>Usuário</label>

              <input type="text" class="form-control" name="usuario" id="usuarioDadosEdit">

            </div>

            <div class="form-group">

              <label>Senha</label>

              <input type="text" class="form-control" name="senha" id="senhaDadosEdit">

            </div>

            <div class="form-group">

              <label>Responsável</label>

              <select tabindex="3" class="form-control" id="responsavelDadosEdit" name="responsavel">

                  <option value="">Selecione um Responsavel</option>

                  <?php while($responsavelEdit = mysqli_fetch_object($classe->resultado[5])): ?>

                    <option value="<?php echo $responsavelEdit->id; ?>"><?php echo $responsavelEdit->nome; ?></option>

                  <?php endwhile; ?>

              </select>

            </div>

            <div class="form-group">

              <label>Observações</label>

              <textarea name="observacoes" id="observacoesDadosEdit" class="form-control summernote" rows="3"></textarea>

            </div>

         <input type="hidden" name="idUsuario" id="idUsuarioDados" value="">

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



     <div id="moda_view_dados" class="modal fade">

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

              <p id="equipamentoDadosView"></p>

            </div>

            <div class="form-group">

              <label>Local</label>

              <p id="nomeDadosView"></p>

            </div>

            <div class="form-group">

              <label>Cliente</label>

              <p id="clienteDadosView"></p>

            </div>

            <div class="form-group">

              <label>Serial / MAC / IP</label>

              <p id="serialDadosView"></p>

            </div>

            <div class="form-group">

              <label>Porta http inicio</label>

              <p id="portainicioDadosView"></p>

            </div>

            <div class="form-group">

              <label>Porta http fim</label>

              <p id="portafimDadosView"></p>

            </div>

            <div class="form-group">

              <label>Senha acesso remoto</label>

              <p id="senharemotoDadosView"></p>

            </div>

            <div class="form-group">

              <label>Usuário</label>

              <p id="usuarioDadosView"></p>

            </div>

            <div class="form-group">

              <label>Senha</label>

              <p id="senhaDadosView"></p>

            </div>

            <div class="form-group">

              <label>Responsável</label>

              <p id="responsavelDadosView"></p>

            </div>

            <div class="form-group">

              <label>Observações</label>

              <p id="observacoesDadosView"></p>

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

<!--====  End of Section comment  ====-->

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
          <input type="hidden" name="acao" id="acao" value="arquivoCliente">
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

<div id="modal_obs" class="modal fade">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Adicionar Observação</h4>
      </div>
      <!--modal header-->
      <div class="modal-body">
        <form role="form" id="formCadastrarObservacao" action="">
          <div class="form-group">
            <label>Observação</label>
            <textarea class="summernote" id="observacao" name="observacao"></textarea>
          </div>
          <input type="hidden" name="idUsuarioObs" id="idUsuarioObs" value="">
          <div class="modal-footer">
            <button type="button" class="btn btn-raised  btn-default" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-raised  btn-primary" id="altObs">Cadastrar</button>
          </div>
         </form>
      </div>
        <!--modal footer-->
      </div>
      <!--modal-content-->
    </div>
    <!--modal-dialog modal-lg-->
  </div>