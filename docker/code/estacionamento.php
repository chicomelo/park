<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json');

require_once("sql.php");
require_once("estacionamentoDAO.php");
require_once("estacionamento.class.php");

$acao = $_GET['acao'];
switch ($acao){
    case 'buscar-carro':

        $placa_buscar = $_POST['placa_buscar'];

        $carros = new Carros();
        $carros->setplaca($placa_buscar);

        $carrosDAO = new CarrosDAO();
        $res_carros = $carrosDAO->buscar_carro_placa($carros->getplaca());

        foreach($res_carros as $linha) {
            $carros-> setcod_carro($linha['cod_carro']);
            $carros-> setplaca($linha['placa']);
            $carros-> setmodelo($linha['modelo']);
            $carros-> setcor($linha['cor']);
        }

        if($carros -> getcod_carro()){

            $tickets = new Tickets();

            $ticketsDAO = new TicketsDAO();
            $res_tickets = $ticketsDAO->buscar_info_carro($carros->getcod_carro());

            foreach($res_tickets as $linha) {
                $tickets-> setcod_ticket($linha['cod_ticket']);
                $tickets-> setcod_carro($linha['cod_carro']);
                $tickets-> setcod_vaga($linha['cod_vaga']);
                $tickets-> setdata_entrada($linha['data_entrada']);
                $tickets-> setdata_saida($linha['data_saida']);
                $tickets-> setvalor($linha['valor']);
            }


            # caso não tenha valor cadastrado, é pq o veículo só deu entrada
            if($tickets->getvalor()){
                # entrada
                # busca vagas disponíveis
                $vagasDAO = new VagasDAO();
                $vagas_ativas = $vagasDAO->buscar_vagas_disponiveis();

                $options = '';
                foreach($vagas_ativas as $vagas){
                    $options .= '<option value="'.$vagas['cod_vaga'].'">'.$vagas['cod_vaga'].'</option>';
                }

                echo json_encode(array("acao"=>1, "options" => $options));
            }else{
                # saída

                # busca vagas disponíveis
                $vagasDAO = new VagasDAO();
                $vagas_ativas = $vagasDAO->buscar_vagas_disponiveis();

                $options = '';
                foreach($vagas_ativas as $vagas){
                    if($vagas['cod_vaga'] == $tickets -> getcod_vaga()){
                        $options .= '<option value="'.$vagas['cod_vaga'].'" selected>'.$vagas['cod_vaga'].'</option>';
                    }else{
                        $options .= '<option value="'.$vagas['cod_vaga'].'">'.$vagas['cod_vaga'].'</option>';
                    }

                }
                echo json_encode(array("acao" => 2, "options" => $options, "cod_ticket" => $tickets->getcod_ticket(), "carro" =>  array("placa" => $carros->getplaca(), "modelo" => $carros->getmodelo(), "cor" => $carros->getcor())));
            }

        }else{
            echo json_encode(array("acao"=>0));
        }


    break;
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
        $res_carro_cod = $carrosDAO -> buscar_carro_placa($carros->getplaca());

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
