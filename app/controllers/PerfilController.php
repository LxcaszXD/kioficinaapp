<?php

class PerfilController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        $dadosToken = TokenHelper::validar($_SESSION['token']);

        if (!$dadosToken) {
            session_destroy();
            unset($_SESSION['token']);
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }

        //ATUALIZAÇÃO DO CLIENTE 
        //Analisar se o form foi enviado 
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $dadosAtualizados = [
                'nome_cliente' => $_POST['nome'],
                'email_cliente' => $_POST['email'],
                'telefone_cliente' => $_POST['telefone'],
                'endereco_cliente' => $_POST['endereco'],
                'bairro_cliente' => $_POST['bairro'],
                'cidade_cliente' => $_POST['cidade'],
                'id_uf' => $_POST['id_uf']
            ];
        
            if (!empty($_POST['senha'])){
                $dadosAtualizados['senha_cliente'] = $_POST['senha'];
            }

            //Chamar a API atualizarCliente
            $urlAtualizar = BASE_API . "atualizarCliente/".$dadosToken['id'];
            $chAtualizar = curl_init($urlAtualizar);
            curl_setopt($chAtualizar, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chAtualizar, CURLOPT_CUSTOMREQUEST, "PATCH");
            curl_setopt($chAtualizar, CURLOPT_POSTFIELDS, json_encode($dadosAtualizados));
            curl_setopt($chAtualizar, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer' . $_SESSION['token'],
                'Content_Type: application/json'
            ]);

            $resposta = curl_exec($chAtualizar);
            $statusCodeAtualizar = curl_getinfo($chAtualizar, CURLINFO_HTTP_CODE);
            curl_close($chAtualizar);

            if ($statusCodeAtualizar === 200){
                $_SESSION['msg_sucesso'] = 'Perfil atualizado com sucesso!';
                header("Location: " . BASE_URL . "index.php?url=perfil");
                exit;
            } else{
                $_SESSION['msg_erro'] = "Erro ao atualizar o perfil! Código: $statusCodeAtualizar";
            }
        }

        //Buscar os clientes na API
        $url = BASE_API . "cliente/" . $dadosToken['id'];

        //Reconhecimento da chave (Inicializa uma sessão cURL)
        $ch = curl_init($url);
        //Definir que o conteudo venha com string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        //Recebe os dados dessa solicitação
        $response = curl_exec($ch);
        //Obtém o código HTTP da resposta (200, 400, 401)
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //Encerra a sessão cURL
        curl_close($ch);

        if ($statusCode != 200) {
            echo "Erro ao buscar as ordens de serviço na API.\n";
            echo "Código HTTP: $statusCode";
            exit;
        }

        //Separa os dados em 'campos'
        $cliente = json_decode($response, true);

        //Fazer a busca da lista de estados
        $urlEstados = BASE_API . "listarEstados";
        $chEstados = curl_init($urlEstados);
        curl_setopt($chEstados, CURLOPT_RETURNTRANSFER, true);
        $responseEstados = curl_exec($chEstados);
        $statusCodeEstados = curl_getinfo($chEstados, CURLINFO_HTTP_CODE);
        curl_close($chEstados);

        $estados = ($statusCodeEstados == 200) ? json_decode($responseEstados, true) : [];


        $dados = array();
        $dados['titulo'] = 'KiOficina - Perfil';

        $dados['cliente'] = $cliente;
        $dados['estados'] = $estados;

        $this->carregarViews('perfil', $dados);
    }
}
