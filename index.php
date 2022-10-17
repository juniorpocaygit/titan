<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste Titan</title>
    <link href="css/estilo.css" rel="stylesheet" media="All">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Anek+Telugu:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/funcoes.js"></script>
  </head>
  <body>
    <div id="mensagem"></div>
    <div id="msgdelete">
        <p><small>Certeza que deseja excluir:</small></p>
        <h4 id="nome_cor" class="mb-4"></h4>
        <div class="buttons-delete">
            <button class="confirm-delete bred iddelete">Confirmar</button>
            <button class="cancel-delete">Cancelar</button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div id="cria_produto" class="forms">
                        <h3>Inserir produto</h3>
                        <form id="add_produtos">
                            <div class="row inputs">
                                <div class="col-md-5">
                                    <input type="text" name="nome_produto" id="nome_produto" placeholder="Nome do produto">
                                </div>
                                <div class="col-md-3">
                                <input type="text" name="preco_produto" id="preco_produto" placeholder="Preço">
                                </div>
                                <div class="col-md-4">
                                    <select id="todas_cores"></select>
                                </div>
                            </div>
                            <div class="buttons">
                                <button id="btn_criar_produto" class="bgreen">Inserir</button>
                            </div>
                        </form>
                    </div>
                    <div id="atualiza_produto" class="forms">
                        <h3>Atualizar produto</h3>
                        <form id="update_produtos">
                            <div class="row inputs">
                                <div class="col-md-5">
                                    <input type="hidden" id="id_produp">
                                    <input type="text" name="nome_produtoup" id="nome_produtoup" placeholder="Nome do produto">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="preco_produtoup" id="preco_produtoup" placeholder="Preço">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="cor_produtoup" id="cor_produtoup" disabled>
                                </div>
                            </div>
                            <div class="buttons">
                                <button id="btn_atualizar_produto" class="bblue">Atualizar</button>
                                <button id="btn_atualizar_cancel" class="bgray">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-5 ">
                    <div id="cria_cor"class="forms">
                        <h3>Inserir cor</h3>
                        <form id="cor">
                            <div class="row inputs">
                                <div class="col-md-6">
                                    <input type="text" name="cor" id="cor" placeholder="Cor">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="desc_cor" id="desc_cor" placeholder="Desconto">
                                </div>
                            </div>
                            <div class="buttons">
                                <button id="btn_criar_cor" class="bgreen">Inserir</button>
                            </div>
                        </form>
                    </div>
                    <div id="atualiza_cor"class="forms">
                        <h3>Atualizar cor</h3>
                        <form id="corupdate">
                            <div class="row inputs">
                                <div class="col-md-6">
                                    <input type="hidden" name="id_corup" id="id_corup">
                                    <input type="text" name="corup" id="corup" placeholder="Cor">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="desc_corup" id="desc_corup" placeholder="Desconto">
                                </div>
                            </div>
                            <div class="buttons">
                                <button id="btn_atualizar_cor" class="bblue">Atualizar</button>
                                <button id="btn_atualizar_cancel" class="bgray">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-7">
                    <div class="block">
                        <h3 class="mt-2 ml-3 bold">Produtos</h3>
                        <div class="filtros_header mt-4">
                            <div class="barrafiltro"></div>
                            <div class="titulo_filtros">
                                <p><small>Filtros</small></p>
                            </div>
                        </div>
                         <div class="filtros">
                            <div class="row">
                                <div class="col-md-7">
                                    <form id="filtro_nome">
                                        <input type="text" name="filtro_prod_nome" id="filtro_prod_nome" placeholder="Filtrar produto pelo nome">
                                    </form>
                                </div>
                                <div class="col-md-5">
                                    <form id="filtro_cor">
                                        <select id="filtro_cores"></select>
                                    </form>
                                </div>
                                <div class="col-md-7">
                                    <form id="filtro_preco">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select id="filtro_select_comparativo">
                                                    <option selected="selected" value="1">Maior</option>    
                                                    <option value="2">Menor</option>   
                                                    <option value="3">Igual</option>   
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="filtro_prod_preco" id="filtro_prod_preco" placeholder="Preço">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-5 limpar_filtro">
                                    <button id="btn_limpar_filtro" class="bblue">Limpar filtros</button>
                                </div>
                            </div>
                        </div>
                         <div class="barrafiltro mt-3 mb-3"></div>
                        <table class="table table-hover">
                            <thead align="center">
                                <tr>
                                    <td>Produto</td>
                                    <td>Cor</td>
                                    <td>Preço</td>
                                    <td>Preço Desc.</td>
                                    <td>Ações</td>
                                </tr>
                            </thead>
                            <tbody align="center" id="tbodyprodutos"></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="block">
                        <h3 class="mt-2 ml-3 bold">Cores</h3>
                        <table class="table table-hover">
                            <thead align="center">
                                <tr>
                                    <td>Nome</td>
                                    <td>Desconto</td>
                                    <td>Ações</td>
                                </tr>
                            </thead>
                            <tbody align="center" id="tbodycores"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/home.js"></script>
  </body>
</html>