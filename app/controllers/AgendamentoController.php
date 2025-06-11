<?php

class AgendamentoController extends Controller
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

        //** LISTAR OS VEICULOS DO CLIENTE */

        //Buscar as ordens de serviço na API
        $urlVeiculos = BASE_API . "veiculo/" . $dadosToken['id'];

        //Reconhecimento da chave (Inicializa uma sessão cURL)
        $chVeiculos = curl_init($urlVeiculos);
        //Definir que o conteudo venha com string
        curl_setopt($chVeiculos, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chVeiculos, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        //Recebe os dados dessa solicitação
        $responseVeiculos = curl_exec($chVeiculos);
        //Obtém o código HTTP da resposta (200, 400, 401)
        $statusCodeVeiculos = curl_getinfo($chVeiculos, CURLINFO_HTTP_CODE);
        //Encerra a sessão cURL
        curl_close($chVeiculos);

        if ($statusCodeVeiculos != 200) {
            echo "Erro ao buscar as ordens de serviço na API.\n";
            echo "Código HTTP: $statusCodeVeiculos";
            exit;
        }

        //Separa os dados em 'campos'
        $veiculos = json_decode($responseVeiculos, true);



           //** LISTAR OS FUNCIONARIOS */

        //Buscar as ordens de serviço na API
        $urlFuncionarios = BASE_API . "listarFunc/";
        
        $chFuncionarios = curl_init($urlFuncionarios);
        curl_setopt($chFuncionarios, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chFuncionarios, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);
        $responseFuncionarios = curl_exec($chFuncionarios);
        $statusCodeFuncionarios = curl_getinfo($chFuncionarios, CURLINFO_HTTP_CODE);
        curl_close($chFuncionarios);

        if ($statusCodeFuncionarios != 200) {
            echo "Erro ao buscar as ordens de serviço na API.\n";
            echo "Código HTTP: $statusCodeFuncionarios";
            exit;
        }

        //Separa os dados em 'campos'
        $funcionarios = json_decode($responseFuncionarios, true);

        // AGENDAMENTO ANALIZANDO O MÉTODO POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = $_POST['data_agenda'];
            $hora = $_POST['hora_agenda'];
            $dataAgendamento = $data . '' . $hora;

            $dadosAgendamento = [
                'id_veiculo' => $_POST['id_veiculo'],
                'id_funcionario' => $_POST['id_funcionario'],
                'data_agendamento' => $dataAgendamento
            ];

            $urlAgendar = BASE_API . "criarAgendamento";
            $chAgenda = curl_init($urlAgendar);
            curl_setopt($chAgenda, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chAgenda, CURLOPT_POSTFIELDS, json_encode($dadosAgendamento));
            curl_setopt($chAgenda, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $_SESSION['token'],
                'Content-Type: application/json'
            ]);

            $resposta = curl_exec($chAgenda);
            $statusCodeAgenda = curl_getinfo($chAgenda, CURLINFO_HTTP_CODE);
            curl_close($chAgenda);

            if($statusCodeAgenda === 200){
                $_SESSION['msg_sucesso'] = 'Agendamento realizado com sucesso!';
                header("Location: " . BASE_URL . "index.php?url=agendamento");
                exit;
            } else{
                $_SESSION['msg_erro'] = "Erro ao agendar. Código: $statusCodeAgenda";
            }

        }

        $dados = array();
        $dados['titulo'] = 'KiOficina - Agendamento';
        $dados['veiculos'] = $veiculos;
        $dados['funcionarios'] = $funcionarios;

        $this->carregarViews('agendamento', $dados);
    }
}
