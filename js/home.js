$(document).ready(function () {
  getCores()
  getCorSelect()
  getProdutos()
    
});
// Filtros // --------------------------------------------------------------------------------

//Máscara de Preço
$('input#filtro_prod_preco').on('keyup', function() {
  var atual = mascaraValor($(this).val());
  $('input#filtro_prod_preco').val("R$"+atual);
});

//Limpar Filtros
$("#btn_limpar_filtro").on("click", function (e) {
  e.preventDefault();
  getProdutos(); 
  resetForm()
})

//Filtrar pelo nome do produto
$("#filtro_prod_nome").on("blur", function (e) {
  e.preventDefault();

  let filtroNome = $("form#filtro_nome #filtro_prod_nome").val();
  
  if (filtroNome.trim() == ""){
    $("div#mensagem").show().html("Preencha o campo de filtro por nome").resetMessage();
    return;
  }
  $.ajax({
    url: "Class/home.php",
    type: "POST",
    data: {
      type:"filtroNome",
      filtro: filtroNome,
    },
    success: function (response) {
      console.log(response)
      if (response.error) {
        response = JSON.parse(response);
        $("div#mensagem").show().addClass("red").html(response.message).resetMessage();
      } else {
        $("#tbodyprodutos").html(response);
         resetForm()
      }
    },
    error: function () {
      $("div#mensagem").show().addClass("red").html("Ocorreu um erro durante a solicitação.").resetMessage();
    },
  });
})

//Filtrar pela Cor
$(document).on('change','#filtro_cores', function(e){
  e.preventDefault();

  let filtroCor = $(this).val();
  
  $.ajax({
    url: "Class/home.php",
    type: "POST",
    data: {
      type:"filtroCor",
      filtro: filtroCor,
    },
    success: function (response) {
      console.log(response)
      if (response.error) {
        response = JSON.parse(response);
        $("div#mensagem").show().addClass("red").html(response.message).resetMessage();
      } else {
        $("#tbodyprodutos").html(response);
         resetForm()
      }
    },
    error: function () {
      $("div#mensagem").show().addClass("red").html("Ocorreu um erro durante a solicitação.").resetMessage();
    },
  });
})


//Filtrar pela Preço do Produto
$(document).on('blur','#filtro_prod_preco', function(e){
  e.preventDefault();

  let filtroPreco = $(this).val().replace("R$","").replace(".","").replace(",",".");
  let filtroComparativo = $("#filtro_select_comparativo :selected").text()

  $.ajax({
    url: "Class/home.php",
    type: "POST",
    data: {
      type:"filtroPreco",
      filtro: filtroPreco,
      comparativo: filtroComparativo
    },
    success: function (response) {
      console.log(response)
      if (response.error) {
        response = JSON.parse(response);
        $("div#mensagem").show().addClass("red").html(response.message).resetMessage();
      } else {
        $("#tbodyprodutos").html(response);
         resetForm()
      }
    },
    error: function () {
      $("div#mensagem").show().addClass("red").html("Ocorreu um erro durante a solicitação.").resetMessage();
    },
  });
})

// Produtos // --------------------------------------------------------------------------------

//Máscara de Preço
$('input#preco_produto').on('keyup', function() {
  var atual = mascaraValor($(this).val());
  $('input#preco_produto').val("R$"+atual);
});

//Recupera a lista de cores para o select
function getCorSelect(){
  $.ajax({
      url: "Class/home.php",
      type: "POST",
      data: {
        type: "loadCorHome",
      },
      success: function (response) {
        if (response.error) {
          response = JSON.parse(response);
          $("div#mensagem").show().html(response.message).resetMessage();
        } else {
          $("#todas_cores").html(response);
          $("#filtro_cores").html(response);
        }
      },
      error: function () {
        $("div#mensagem").show().html("Ocorreu um erro durante a solicitação.").resetMessage();
      },
  });
}

//Inserir Produtos
$("#btn_criar_produto").on("click", function (e) {
  e.preventDefault();

  $("btn_criar_produto").hide();
  $(".c-loader").show();

  let produto = $("form#add_produtos #nome_produto").val();
  let money = $("form#add_produtos #preco_produto").val().replace("R$","").replace(".","").replace(",",".");
  let preco = money;
  let cor = $("form#add_produtos #todas_cores").val();
  
  if (cor.trim() == ""){
    $("div#mensagem").show().html("Selecione uma COR").resetMessage();
    $("btn_criar_produto").show();
    $(".c-loader").hide();
    return;
  }
  if (produto.trim() == ""){
    $("div#mensagem").show().html("Preencha o campo PRODUTO").resetMessage();
    $("btn_criar_produto").show();
    $(".c-loader").hide();
    return;
  }
  if (preco.trim() == ""){
    $("div#mensagem").show().html("Preencha o campo PREÇO").resetMessage();
    $("btn_criar_produto").show();
    $(".c-loader").hide();
    return;
  }
  $.ajax({
    url: "Class/home.php",
    type: "POST",
    data: {
      type:"addProduto",
      cor: cor,
      produto: produto,
      preco: preco,
    },
    success: function (response) {
      response = JSON.parse(response);
      $("btn_criar_produto").show();
      $(".c-loader").hide();
      if (response.error) {
        $("div#mensagem").show().addClass("red").html(response.message).resetMessage();
      } else {
        $("div#mensagem").show().addClass("green").html(response.message).resetMessage();
        resetForm();
        getProdutos()
      }
    },
    error: function () {
      $("btn_criar_produto").show();
      $(".c-loader").hide();
      $("div#mensagem").show().addClass("red").html("Ocorreu um erro durante a solicitação.").resetMessage();
    },
  });
})

//Carregar produto para ser atualizado
$(document).on("click",".prod-edit", function (e) {
  e.preventDefault();

  let id = $(this).data("id");
  getProdutoDetails(id);
  $("#atualiza_produto").show();
  $("#cria_produto").hide();
});

//Atualizar produto
$("#btn_atualizar_produto").on("click", function (e) {
  e.preventDefault();

  $("btn_atualizar_produto").hide();
  $("btn_atualizar_cancel").hide();
  $(".c-loader").show();

  let id = $("form#update_produtos #id_produp").val();
  let produto = $("form#update_produtos #nome_produtoup").val();
  let preco = $("form#update_produtos #preco_produtoup").val().replace("R$","").replace(".","").replace(",",".");

  if (produto.trim() == ""){
    $("div#mensagem").show().html("Preencha o campo PRODUTO").resetMessage();
    $("btn_atualizar_produto").hide();
    $("btn_atualizar_cancel").hide();
    $(".c-loader").show();
    return;
  }
  if (preco.trim() == ""){
    $("div#mensagem").show().html("Preencha o campo PREÇO").resetMessage();
    $("btn_atualizar_produto").hide();
    $("btn_atualizar_cancel").hide();
    $(".c-loader").show();
    return;
  }
  $.ajax({
    url: "Class/home.php",
    type: "POST",
    data: {
      type:"updateProduto",
      id: id,
      produto: produto,
      preco: preco,
    },
    success: function (response) {
      response = JSON.parse(response);
      $("btn_atualizar_produto").hide();
      $("btn_atualizar_cancel").hide();
      $(".c-loader").show();
      if (response.error) {
        $("div#mensagem").show().addClass("red").html(response.message).resetMessage();
      } else {
        $("div#mensagem").show().addClass("green").html(response.message).resetMessage();
        resetForm();
        getProdutos();
        $("#atualiza_produto").hide();
        $("#cria_produto").show();
      }
    },
    error: function () {
      $("btn_atualizar_produto").hide();
      $("btn_atualizar_cancel").hide();
      $(".c-loader").show();
      $("div#mensagem").show().addClass("red").html("Ocorreu um erro durante a solicitação.").resetMessage();
    },
  });
})

//Carrega produto para ser deletada
$(document).on("click",".prod-delete", function (e) {
  e.preventDefault();

  let id = $(this).data("id");
  getProdutoDetails(id);
  $("#msgdelete").show();
});

//Delete Cor
$(".iddelete").click(function () {
  let id = $(this).val();
  $.ajax({
    url: "Class/home.php",
    type: "POST",
    data: {
      type: "deleteProduto",
      id: id,
    },
    success: function (response) {
      response = JSON.parse(response);
      if (response.error) {
        $("div#mensagem").show().html(response.message).resetMessage();
        closemsgdelete() 
      } else {
        $("div#mensagem").show().addClass("green").html(response.message).resetMessage();
        getProdutos();
        closemsgdelete();
      }
    },
    error: function () {
      $("div#mensagem").show().html("Ocorreu um erro durante a solicitação.").resetMessage();
      closemsgdelete() 
    },
  });
});

//Lista todos os produtos
function getProdutos(){
  $.ajax({
      url: "Class/home.php",
      type: "POST",
      data: {
        type: "getProdutos",
      },
      success: function (response) {
        if (response.error) {
          response = JSON.parse(response);
          $("div#mensagem").show().html(response.message).resetMessage();
        } else {
          $("#tbodyprodutos").html(response);
        }
      },
      error: function () {
        $("div#mensagem").show().html("Ocorreu um erro durante a solicitação.").resetMessage();
      },
  });
}

function getProdutoDetails(id){
  $.ajax({
      url: "Class/home.php",
      type: "POST",
      data: {
        type: "getProdutoDetails",
        id: id,
      },
      success: function (response) {
        response = JSON.parse(response);
        if (response.error) {
          $("div#mensagem").show().html(response.message).resetMessage();
        } else {
          $("#id_produp").val(response.data.id_prod);
          $("#nome_produtoup").val(response.data.nome_prod);
          $("#preco_produtoup").val("R$ "+mascaraValor(response.data.preco));
          $("#cor_produtoup").val(response.data.nome_cor);
          $(".iddelete").val(response.data.id_prod);
          $("#nome_cor").html(response.data.nome_prod);
        }
      },
      error: function () {
        $("div#mensagem").show().html("Ocorreu um erro durante a solicitação.").resetMessage();
      },
  });
}

// Cores // --------------------------------------------------------------------------------

//Carrega cor para ser atualizada
$(document).on("click",".cor-edit", function (e) {
  e.preventDefault();

  let id = $(this).data("id");
  getCorDetails(id);
  $("#atualiza_cor").show();
  $("#cria_cor").hide();
});

//Atualiza Cor
$("#btn_atualizar_cor").on("click", function (e) {
  e.preventDefault();

  $("btn_atualizar_cor").hide();
  $("btn_atualizar_cancel").hide();
  $(".c-loader").show();

  let id = $("form#corupdate #id_corup").val();
  let cor = $("form#corupdate #corup").val();
  let desconto = $("form#corupdate #desc_corup").val();

  if (cor.trim() == ""){
    $("div#mensagem").show().html("Preencha o campo COR").resetMessage();
    $("btn_atualizar_cor").show();
    $("btn_atualizar_cancel").show();
    $(".c-loader").hide();
    return;
  }
  if (desconto.trim() == ""){
    $("div#mensagem").show().html("Preencha o campo DESCONTO").resetMessage();
    $("btn_atualizar_cor").show();
    $("btn_atualizar_cancel").show();
    $(".c-loader").hide();
    return;
  }
  if ($.isNumeric(desconto) == false){
    $("div#mensagem").show().html("Insira apenas números no campo desconto").resetMessage();
    $("btn_atualizar_cor").show();
    $("btn_atualizar_cancel").show();
    $(".c-loader").hide();
    return;
  }
  $.ajax({
    url: "Class/home.php",
    type: "POST",
    data: {
      type:"updateCor",
      id: id,
      cor: cor,
      desconto: desconto,
    },
    success: function (response) {
      response = JSON.parse(response);
      $("btn_atualizar_cor").show();
      $("btn_atualizar_cancel").show();
      $(".c-loader").hide();
      if (response.error) {
        $("div#mensagem").show().addClass("red").html(response.message).resetMessage();
      } else {
        $("div#mensagem").show().addClass("green").html(response.message).resetMessage();
        resetForm();
        getCores();
        $("#atualiza_cor").hide();
        $("#cria_cor").show();
      }
    },
    error: function () {
      $("btn_atualizar_cor").show();
      $("btn_atualizar_cancel").show();
      $(".c-loader").hide();
      $("div#mensagem").show().addClass("red").html("Ocorreu um erro durante a solicitação.").resetMessage();
    },
  });
})

//Inserir Cor
$("#btn_criar_cor").on("click", function (e) {
  e.preventDefault();

  $("btn_criar_cor").hide();
  $(".c-loader").show();

  let cor = $("form#cor #cor").val();
  let desconto = $("form#cor #desc_cor").val();

  if (cor.trim() == ""){
    $("div#mensagem").show().html("Preencha o campo COR").resetMessage();
    $("btn_criar_cor").show();
    $(".c-loader").hide();
    return;
  }
  if (desconto.trim() == ""){
    $("div#mensagem").show().html("Preencha o campo DESCONTO").resetMessage();
    $("btn_criar_cor").show();
    $(".c-loader").hide();
    return;
  }
  if ($.isNumeric(desconto) == false){
    $("div#mensagem").show().html("Insira apenas números no campo desconto").resetMessage();
    $("btn_criar_cor").show();
    $(".c-loader").hide();
    return;
  }
  $.ajax({
    url: "Class/home.php",
    type: "POST",
    data: {
      type:"addCor",
      cor: cor,
      desconto: desconto,
    },
    success: function (response) {
      response = JSON.parse(response);
      $("btn_criar_cor").show();
      $(".c-loader").hide();
      if (response.error) {
        $("div#mensagem").show().addClass("red").html(response.message).resetMessage();
      } else {
        $("div#mensagem").show().addClass("green").html(response.message).resetMessage();
        resetForm();
        getCores();
      }
    },
    error: function () {
      $("btn_criar_cor").show();
      $(".c-loader").hide();
      $("div#mensagem").show().addClass("red").html("Ocorreu um erro durante a solicitação.").resetMessage();
    },
  });
})

//Carrega Cor para ser deletada
$(document).on("click",".cor-delete", function (e) {
  e.preventDefault();

  let id = $(this).data("id");
  getCorDetails(id);
  $("#msgdelete").show();
});

//Delete Cor
$(".iddelete").click(function () {
  let id = $(this).val();
  $.ajax({
    url: "Class/home.php",
    type: "POST",
    data: {
      type: "deleteCor",
      id: id,
    },
    success: function (response) {
      response = JSON.parse(response);
      if (response.error) {
        $("div#mensagem").show().html(response.message).resetMessage();
        closemsgdelete() 
      } else {
        $("div#mensagem").show().addClass("green").html(response.message).resetMessage();
        getCores();
        closemsgdelete();

      }
    },
    error: function () {
      $("div#mensagem").show().html("Ocorreu um erro durante a solicitação.").resetMessage();
      closemsgdelete() 
    },
  });
});

//Lista todas as cores
function getCores(){
  $.ajax({
      url: "Class/home.php",
      type: "POST",
      data: {
        type: "getCores",
      },
      success: function (response) {
        if (response.error) {
          response = JSON.parse(response);
          $("div#mensagem").show().html(response.message).resetMessage();
        } else {
          $("#tbodycores").html(response);
          getCorSelect()
        }
      },
      error: function () {
        $("div#mensagem").show().html("Ocorreu um erro durante a solicitação.").resetMessage();
      },
  });
}

function getCorDetails(id){
  $.ajax({
      url: "Class/home.php",
      type: "POST",
      data: {
        type: "getCorDetails",
        id: id,
      },
      success: function (response) {
        response = JSON.parse(response);
        if (response.error) {
          $("div#mensagem").show().html(response.message).resetMessage();
        } else {
          $("#id_corup").val(response.data.id_cor);
          $("#corup").val(response.data.nome_cor);
          $("#desc_corup").val(response.data.desconto);
          $(".iddelete").val(response.data.id_cor);
          $("#nome_cor").html(response.data.nome_cor);
        }
      },
      error: function () {
        $("div#mensagem").show().html("Ocorreu um erro durante a solicitação.").resetMessage();
      },
  });
}

$(document).on("click", ".cancel-delete", function (e) {
  e.preventDefault();
  closemsgdelete()  
});  
$(document).on("click", "#btn_atualizar_cancel", function (e) {
  e.preventDefault();
  $("#atualiza_produto").hide();
  $("#cria_produto").show();  
  $("#atualiza_cor").hide();
  $("#cria_cor").show();  
});  
function closemsgdelete(){
  $("#msgdelete").hide();
};
