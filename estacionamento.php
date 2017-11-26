<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');

require_once("sql.php");
require_once("estacionamentoDAO.php");
require_once("estacionamento.class.php");

$acao = $_GET['acao'];

switch ($acao){
    case 'buscar-vagas-disponiveis':

        # busca vagas disponíveis
        $vagasDAO = new VagasDAO();
        $vagas_ativas = $vagasDAO->buscar_vagas_disponiveis();

        $options = '';
        foreach($vagas_ativas as $vagas){
            $options .= '<option value="'.$vagas['cod_vaga'].'">'.$vagas['cod_vaga'].'</option>';
        }

        echo json_encode($options);

    break;
    case 'cadastrar-carro':

        # setando objetos
        $vagas = new Vagas();
        $vagas->setcod_vaga($_POST['vaga']);
        $vagas->setativo('0');

        $carros = new Carros();
        $carros->setplaca($_POST['placa']);
        $carros->setmodelo($_POST['modelo']);
        $carros->setcor($_POST['cor']);

        # atualiza a vaga para indisponivel
        $vagasDAO = new VagasDAO();
        $res_vaga = $vagasDAO-> atualizar($vagas);

        # insere carro no banco
        $carrosDAO = new CarrosDAO();
        $res_carro = $carrosDAO-> inserir($carros);

        # busca carro cadastrado a fim de obter o codigo do carro para cadastrar a entrada no estacionamento
        $res_carro_cod = $carrosDAO -> buscar_carro_placa($carros);

        foreach($res_carro_cod as $linha) {
            $carros-> setcod_carro($linha['cod_carro']);
            $carros-> setplaca($linha['placa']);
            $carros-> setmodelo($linha['modelo']);
            $carros-> setcor($linha['cor']);
        }

        # dá entrada do carro na vaga
        $tickets = new Tickets();
        $tickets->setcod_vaga($vagas->getcod_vaga());
        $tickets->setcod_carro($carros->getcod_carro());
        $tickets->setdata_entrada(date('m/d/Y h:i:s'));
        $ticketsDAO = new TicketsDAO();
        $res_ticket = $ticketsDAO -> inserir($tickets);

        echo json_encode($res_ticket);

    break;
    case 'entrada-carro':

    echo "entrada";

    break;
    }


?>
