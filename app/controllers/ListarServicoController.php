<?php

class ListarServicoController extends Controller
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

        //Buscar as ordens de serviço na API
        $url = BASE_API . "servicoExecutadoPorCliente/" . $dadosToken['id'];

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
        $ordemServico = json_decode($response, true);

        //Garante que seja um array de serviços válidos
        $servicos = [];

        // Se for um array de múltiplos serviços (cada um com status_ordem, etc.)
        if (is_array($ordemServico) && isset($ordemServico[0]) && is_array($ordemServico[0])) {
            $servicos = $ordemServico;
        }

        $dados = array();
        $dados['titulo'] = 'KiOficina - Listar Serviço';

        $dados['servicos'] = $servicos;

        $this->carregarViews('listar_servicos', $dados);
    }
}
