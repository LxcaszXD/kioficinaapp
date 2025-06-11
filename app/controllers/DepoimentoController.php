<?php

class DepoimentoController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['token'])) {
            header("Location" . BASE_URL . "index.php?url=login");
            exit;
        }

        $dados = array();
        $dados['titulo'] = 'KiOficina - Depoimento';

        $this->carregarViews('depoimentos', $dados);
    }

    public function enviarDepoimento()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }
        $descricao = $_POST['descricao'] ?? '';
        $nota = $_POST['nota'] ?? '';
        //Analisar preenchimento da descrição e da nota
        if (empty($descricao) || empty($nota)) {
            echo 'Preencha todos os campos';
            return;
        }

        $postData = [
            'descricao_depoimento' => $descricao,
            'nota_depoimento' => $nota
        ];

        $url = BASE_API . "NovoDepoimento";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $resposta = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode == 200) {
            $response = json_decode($resposta, true);
            if ($response['sucesso']) {
                header("Location: " . BASE_URL . "index.php?url=menu");
                exit;
            }
        } else {
            header("Location: " . BASE_URL . "index.php?url=login");
            exit;
        }
    }
}
