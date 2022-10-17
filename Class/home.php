<?php
    include_once('connect.php');

    Class Home{
        private $con = null;
        public function __construct($conexao){
            $this->con = $conexao;
        }

        public function send(){
            if (empty($_POST) || $this->con == null) {
                $output['error'] = true;
                $output['message'] = "Sem post ou conexão";
                return;
            }
            switch(true){
                case(isset($_POST["type"]) && $_POST["type"] === "filtroNome" && isset($_POST["filtro"]));
                echo $this->filtroNome($_POST["filtro"]);
                break;
             
                case(isset($_POST["type"]) && $_POST["type"] === "filtroCor" && isset($_POST["filtro"]));
                echo $this->filtroCor($_POST["filtro"]);
                break;                
             
                case(isset($_POST["type"]) && $_POST["type"] === "filtroPreco" && isset($_POST["filtro"]));
                echo $this->filtroPreco($_POST["filtro"]);
                break;
                
                case(isset($_POST["type"]) && $_POST["type"] === "addProduto" && isset($_POST["produto"]));
                echo $this->addProduto();
                break;
                
                case(isset($_POST["type"]) && $_POST["type"] === "getProdutos");
                echo $this->getProdutos();
                break;
               
                case(isset($_POST["type"]) && $_POST["type"] === "getProdutoDetails" && isset($_POST["id"]));
                echo $this->getProdutoDetails($_POST["id"]);
                break;

                case(isset($_POST["type"]) && $_POST["type"] === "updateProduto");
                echo $this->updateProduto();
                break;

                case(isset($_POST["type"]) && $_POST["type"] === "deleteProduto" && isset($_POST["id"]));
                echo $this->deleteProduto($_POST["id"]);
                break;

                case(isset($_POST["type"]) && $_POST["type"] === "loadCorHome");
                echo $this->loadCorHome();
                break;

                case(isset($_POST["type"]) && $_POST["type"] === "addCor" && isset($_POST["cor"]));
                echo $this->addCor();
                break;
            
                case(isset($_POST["type"]) && $_POST["type"] === "updateCor");
                echo $this->updateCor();
                break;
                
                case(isset($_POST["type"]) && $_POST["type"] === "deleteCor" && isset($_POST["id"]));
                echo $this->deleteCor($_POST["id"]);
                break;
  
                case(isset($_POST["type"]) && $_POST["type"] === "getCores");
                echo $this->getCores();
                break;
              
                case(isset($_POST["type"]) && $_POST["type"] === "getCorDetails" && isset($_POST["id"]));
                echo $this->getCorDetails($_POST["id"]);
                break; 
            }
        }

        public function filtroNome($filtro){
            $conexao = $this->con;
            $output = array('error' => false);

            $filtro = $_POST['filtro']."%";

            try{
                $sql = $conexao->prepare('SELECT id_prod, nome_prod, preco, nome_cor, desconto FROM  produtos p JOIN cores c ON p.id_cor = c.id_cor WHERE nome_prod LIKE :filtro_nome  ORDER BY nome_prod ASC');
                $sql->bindParam(':filtro_nome', $filtro);
                $sql->execute();
                $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
                foreach ($produtos as $produto) {
                    ?>
                    <tr>
                        <td class="align-middle"><?php echo $produto['nome_prod']; ?></td>
                        <td class="align-middle"><?php echo $produto['nome_cor']; ?></td>
                        <td class="align-middle">R$ <?php echo number_format($produto['preco'],2,",","."); ?></td>
                        <td class="align-middle">R$
                            <?php
                            if ($produto['nome_cor'] == "vermelho" && $produto['preco'] > 50  ) {
                                 $preco_desconto = $produto['preco'] - ($produto['preco'] * ($produto['desconto']+5) / 100);
                                 echo number_format($preco_desconto,2,",",".");
                            } else {
                                $preco_desconto = $produto['preco'] - ($produto['preco'] * $produto['desconto'] / 100);
                                echo number_format($preco_desconto,2,",",".");
                            }
                             ?>
                            </td>
                        <td>
                            <button class="btn prod-edit btn-sm" data-id="<?php echo $produto['id_prod']; ?>"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn prod-delete btn-sm" data-id="<?php echo $produto['id_prod']; ?>"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <?php 
                }
            }
            catch(PDOException $e){
                $output['error'] = true;
                $output['message'] = $e->getMessage();
                echo json_encode($output);
            }
        }
        
        public function filtroCor($filtro){
            $conexao = $this->con;
            $output = array('error' => false);

            $filtro = $_POST['filtro'];

            try{
                $sql = $conexao->prepare('SELECT id_prod, nome_prod, preco, nome_cor, desconto FROM  produtos p JOIN cores c ON p.id_cor = c.id_cor WHERE p.id_cor = :id_cor ORDER BY nome_prod ASC');
                $sql->bindParam(':id_cor', $filtro);
                $sql->execute();
                $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
                foreach ($produtos as $produto) {
                    ?>
                    <tr>
                        <td class="align-middle"><?php echo $produto['nome_prod']; ?></td>
                        <td class="align-middle"><?php echo $produto['nome_cor']; ?></td>
                        <td class="align-middle">R$ <?php echo number_format($produto['preco'],2,",","."); ?></td>
                        <td class="align-middle">R$
                            <?php
                            if ($produto['nome_cor'] == "vermelho" && $produto['preco'] > 50  ) {
                                 $preco_desconto = $produto['preco'] - ($produto['preco'] * ($produto['desconto']+5) / 100);
                                 echo number_format($preco_desconto,2,",",".");
                            } else {
                                $preco_desconto = $produto['preco'] - ($produto['preco'] * $produto['desconto'] / 100);
                                echo number_format($preco_desconto,2,",",".");
                            }
                             ?>
                            </td>
                        <td>
                            <button class="btn prod-edit btn-sm" data-id="<?php echo $produto['id_prod']; ?>"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn prod-delete btn-sm" data-id="<?php echo $produto['id_prod']; ?>"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <?php 
                }
            }
            catch(PDOException $e){
                $output['error'] = true;
                $output['message'] = $e->getMessage();
                echo json_encode($output);
            }
        }

        public function filtroPreco($filtro){
            $conexao = $this->con;
            $output = array('error' => false);

            $filtro = $_POST['filtro'];
            $comparativo = $_POST['comparativo'];
                
            try{
                if ($comparativo == 'Igual') {
                    $sql = $conexao->prepare('SELECT id_prod, nome_prod, preco, nome_cor, desconto FROM  produtos p JOIN cores c ON p.id_cor = c.id_cor WHERE preco = :preco ORDER BY nome_prod ASC');
                    $sql->bindParam(':preco', $filtro);
                    $sql->execute();
                    $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
                } elseif ($comparativo == 'Maior') {
                    $sql = $conexao->prepare('SELECT id_prod, nome_prod, preco, nome_cor, desconto FROM  produtos p JOIN cores c ON p.id_cor = c.id_cor WHERE preco > :preco ORDER BY nome_prod ASC');
                    $sql->bindParam(':preco', $filtro);
                    $sql->execute();
                    $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
                }  elseif ($comparativo == 'Menor') {
                    $sql = $conexao->prepare('SELECT id_prod, nome_prod, preco, nome_cor, desconto FROM  produtos p JOIN cores c ON p.id_cor = c.id_cor WHERE preco < :preco ORDER BY nome_prod ASC');
                    $sql->bindParam(':preco', $filtro);
                    $sql->execute();
                    $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
                }
                foreach ($produtos as $produto) {
                    ?>
                    <tr>
                        <td class="align-middle"><?php echo $produto['nome_prod']; ?></td>
                        <td class="align-middle"><?php echo $produto['nome_cor']; ?></td>
                        <td class="align-middle">R$ <?php echo number_format($produto['preco'],2,",","."); ?></td>
                        <td class="align-middle">R$
                            <?php
                            if ($produto['nome_cor'] == "vermelho" && $produto['preco'] > 50  ) {
                                 $preco_desconto = $produto['preco'] - ($produto['preco'] * ($produto['desconto']+5) / 100);
                                 echo number_format($preco_desconto,2,",",".");
                            } else {
                                $preco_desconto = $produto['preco'] - ($produto['preco'] * $produto['desconto'] / 100);
                                echo number_format($preco_desconto,2,",",".");
                            }
                             ?>
                            </td>
                        <td>
                            <button class="btn prod-edit btn-sm" data-id="<?php echo $produto['id_prod']; ?>"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn prod-delete btn-sm" data-id="<?php echo $produto['id_prod']; ?>"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <?php 
                }
            }
            catch(PDOException $e){
                $output['error'] = true;
                $output['message'] = $e->getMessage();
                echo json_encode($output);
            }
        }


        public function addProduto(){
            $conexao = $this->con;
            $output = array('error' => false);

            $cor = $_POST['cor'];
            $produto = $_POST['produto'];
            $preco = $_POST['preco'];

            try {
                $stmt = $conexao->prepare("INSERT INTO produtos (nome_prod, preco, id_cor) VALUES (:nome_prod, :preco, :id_cor)");
                if ($stmt->execute(array(':nome_prod' => $produto , ':preco' => $preco, 'id_cor'=> $cor ))){
                    $output['message'] = 'Produto inserido com sucesso!';
                } else {
                    //Erro caso tenha algum problema em inserir o usuário no banco
                    $output['error'] = true;
                    $output['message'] = 'Houve um erro com a inclusão deste produto';
                } 
           } catch (PDOException $e) {
                //Mensagem de erro
                $output['error'] = true;
                $output['message'] = 'Erro interno tente novamente mais tarde.';
           }
            echo json_encode($output);        
        }

        public function getProdutos(){
            $conexao = $this->con;
            $output = array('error' => false);

            try{
                $sql = $conexao->prepare('SELECT id_prod, nome_prod, preco, nome_cor, desconto FROM  produtos p JOIN cores c ON p.id_cor = c.id_cor  ORDER BY nome_prod ASC');
                $sql->execute();
                $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
                foreach ($produtos as $produto) {
                    ?>
                    <tr>
                        <td class="align-middle"><?php echo $produto['nome_prod']; ?></td>
                        <td class="align-middle"><?php echo $produto['nome_cor']; ?></td>
                        <td class="align-middle">R$ <?php echo number_format($produto['preco'],2,",","."); ?></td>
                        <td class="align-middle">R$
                            <?php
                            if ($produto['nome_cor'] == "vermelho" && $produto['preco'] > 50  ) {
                                 $preco_desconto = $produto['preco'] - ($produto['preco'] * ($produto['desconto']+5) / 100);
                                 echo number_format($preco_desconto,2,",",".");
                            } else {
                                $preco_desconto = $produto['preco'] - ($produto['preco'] * $produto['desconto'] / 100);
                                echo number_format($preco_desconto,2,",",".");
                            }
                             ?>
                            </td>
                        <td>
                            <button class="btn prod-edit btn-sm" data-id="<?php echo $produto['id_prod']; ?>"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn prod-delete btn-sm" data-id="<?php echo $produto['id_prod']; ?>"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <?php 
                }
            }
            catch(PDOException $e){
                $output['error'] = true;
                $output['message'] = $e->getMessage();
                echo json_encode($output);
            }
        }
        

        public function getProdutoDetails($id){
            $conexao = $this->con;
            $output = array('error' => false);

             try{
                $id = $_POST['id'];
                $stmt = $conexao->prepare("SELECT id_prod, nome_prod, preco, nome_cor, desconto FROM  produtos p JOIN cores c ON p.id_cor = c.id_cor  WHERE id_prod = :id_prod");
                $stmt->bindParam(':id_prod', $id);
                $stmt->execute();
                $output['data'] = $stmt->fetch();
            }
            catch(PDOException $e){
                $output['error'] = true;
                $output['message'] = $e->getMessage();
            }
            echo json_encode($output);
        }

        public function updateProduto(){
            $conexao = $this->con;
            $output = array('error' => false);

            $id = $_POST['id'];
            $produto = $_POST['produto'];
            $preco = $_POST['preco'];

            try {             
                $stmt = $conexao->prepare("UPDATE produtos SET nome_prod = :nome_prod, preco = :preco WHERE id_prod = :id_prod");
                $stmt->bindParam(':id_prod', $id);
                $stmt->bindParam(':nome_prod', $produto);
                $stmt->bindParam(':preco', $preco);

                if ($stmt->execute()) {                   
                    $output['message'] = 'Atualização realizada com sucesso!';
                }    
            } catch (PDOException $e) {
               //Erro caso tenha algum problema em atualizar a cor no banco
                $output['error'] = true;
                $output['message'] = 'Houve um erro com a atualização deste produto';
            }
            echo json_encode($output);              
        }

         public function deleteProduto($id){
            $conexao = $this->con;
            $output = array('error' => false);

            $id = $_POST["id"];
            $stmt = $conexao->prepare("DELETE FROM produtos WHERE id_prod = :id_prod LIMIT 1");
            $stmt->bindParam(':id_prod', $id);
            if ($stmt->execute()) {
                $output['error'] = false;
                $output['message'] = "Exclusão efetuada com sucesso!";
            } else {
                $output['error'] = true;
                $output['message'] = "Não conseguimos deletar esse produto.";               
            }
            echo json_encode($output);
        }

        public function loadCorHome(){
            $conexao = $this->con;
            $output = array('error' => false);

             try{
                $sql = $conexao->prepare('SELECT * FROM cores ORDER BY nome_cor ASC');
                $sql->execute();
                $cores = $sql->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <option selected="selected">Escolha uma cor</option>    
                    <?php foreach ($cores as $cor):?>
                    <option value="<?php echo $cor['id_cor']; ?>"><?php echo $cor['nome_cor']; ?></option>
                    <?php endforeach;?>                
                    <?php 
            }
            catch(PDOException $e){
                $output['error'] = true;
                $output['message'] = $e->getMessage();
                echo json_encode($output);
            }
        }


        public function addCor(){
            $conexao = $this->con;
            $output = array('error' => false);

            $cor = strtolower($_POST['cor']);
            $desconto = intval($_POST['desconto']);

            //Verifica se já existe a cor
            $stmt = $conexao->prepare("SELECT nome_cor FROM cores WHERE nome_cor = :nome_cor");
            $stmt->bindParam(':nome_cor', $cor);
            $stmt->execute();
            $userCor['data'] = $stmt->fetch();

            if (!$userCor['data']) {

                $stmt = $conexao->prepare("INSERT INTO cores (nome_cor, desconto) VALUES (:nome_cor, :desconto)");
                if ($stmt->execute(array(':nome_cor' => $cor , ':desconto' => $desconto))){            
                    $output['message'] = 'Cor inserida com sucesso!';    
                } else {
                    //Erro caso tenha algum problema em inserir a cor no banco
                    $output['error'] = true;
                    $output['message'] = 'Houve um erro com a inclusão desta cor';
                } 
            } else {
                //Mensagem de sucesso
                $output['error'] = true;
                $output['message'] = 'Cor já cadastrada.';
            }
            echo json_encode($output);              
        }

        public function updateCor(){
            $conexao = $this->con;
            $output = array('error' => false);

            $id = $_POST['id'];
            $cor = $_POST['cor'];
            $desconto = $_POST['desconto'];

            try {             
                $stmt = $conexao->prepare("UPDATE cores SET nome_cor = :nome_cor, desconto = :desconto WHERE id_cor = :id_cor");
                $stmt->bindParam(':id_cor', $id);
                $stmt->bindParam(':nome_cor', $cor);
                $stmt->bindParam(':desconto', $desconto);

                if ($stmt->execute()) {                   
                    $output['message'] = 'Atualização realizada com sucesso!';
                }    
            } catch (PDOException $e) {
               //Erro caso tenha algum problema em atualizar a cor no banco
                $output['error'] = true;
                $output['message'] = 'Houve um erro com a atualização desta cor';
            }
            echo json_encode($output);              
        }

          public function deleteCor($id){
            $conexao = $this->con;
            $output = array('error' => false);

            $id = $_POST["id"];
            $stmt = $conexao->prepare("DELETE FROM cores WHERE id_cor = :id_cor LIMIT 1");
            $stmt->bindParam(':id_cor', $id);
            if ($stmt->execute()) {
                $output['error'] = false;
                $output['message'] = "Exclusão efetuada com sucesso!";
            } else {
                $output['error'] = true;
                $output['message'] = "Não conseguimos deletar essa cor.";               
            }
            echo json_encode($output);
        }

        public function getCores(){
            $conexao = $this->con;
            $output = array('error' => false);

            try{
                $sql = $conexao->prepare('SELECT * FROM cores ORDER BY nome_cor ASC');
                $sql->execute();
                $cores = $sql->fetchAll(PDO::FETCH_ASSOC);
                foreach ($cores as $cor) {
                    ?>
                    <tr>
                        <td class="align-middle"><?php echo $cor['nome_cor']; ?></td>
                        <td class="align-middle"><?php echo $cor['desconto']; ?>%</td>
                        <td>
                            <button class="btn cor-edit btn-sm" data-id="<?php echo $cor['id_cor']; ?>"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn cor-delete btn-sm" data-id="<?php echo $cor['id_cor']; ?>"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <?php 
                }
            }
            catch(PDOException $e){
                $output['error'] = true;
                $output['message'] = $e->getMessage();
                echo json_encode($output);
            }
        }

         public function getCorDetails($id){
            $conexao = $this->con;
            $output = array('error' => false);

             try{
                $id = $_POST['id'];
                $stmt = $conexao->prepare("SELECT * FROM cores WHERE id_cor = :id_cor");
                $stmt->bindParam(':id_cor', $id);
                $stmt->execute();
                $output['data'] = $stmt->fetch();
            }
            catch(PDOException $e){
                $output['error'] = true;
                $output['message'] = $e->getMessage();
            }
            echo json_encode($output);
        }




    };

    $conexao = new connDB();
    $classe = new Home($conexao->open());
    $classe->send();


 

?>