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

                $options = '';
                        $options .= '<option value="'.$tickets->getcod_vaga().'">'.$tickets->getcod_vaga().'</option>';

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

        $ticketsDAO = new TicketsDAO();
        $res_ticket = $ticketsDAO -> inserir($tickets);

        echo json_encode($res_ticket);

        break;
    case 'entrada-carro':

    echo "entrada";

        break;
    case 'saida-carro':

        $cod_ticket = $_POST['cod_ticket'];
        $cod_vaga = $_POST['cod_vaga'];
        $data_saida = date('Y-m-d h:i:s');
        $valor_total = 0;

        $data_saida = '2017-11-27 21:30:52';

        $ticketsDAO = new TicketsDAO();
        $tickets_res = $ticketsDAO->buscar_info_cod($cod_ticket);
        $tickets_res = $tickets_res[0];

        $tickets = new Tickets();
        $tickets-> setcod_ticket($tickets_res['cod_ticket']);
        $tickets-> setcod_carro($tickets_res['cod_carro']);
        $tickets-> setcod_vaga($tickets_res['cod_vaga']);
        $tickets-> setdata_entrada($tickets_res['data_entrada']);
        $tickets-> setdata_saida($data_saida);

        $inicio = strtotime($tickets->getdata_entrada());
        $fim = strtotime($tickets->getdata_saida());
        $intervalo = ($fim - $inicio)/60;
        $horas = $intervalo / 60;

        if ($intervalo > 120){
            $preco = 3.0;
            $valor_total = round($preco * ($horas -2), 2);
            $valor_total += 5;
        }elseif($intervalo > 60){
            $preco = 2.5;
            $valor_total = 5.0;
        }else{
            $preco = 3.5;
            $valor_total = 3.5;
        }

        $tickets-> setvalor($valor_total);

        echo json_encode($valor_total);
        exit();


        $res_tickets = $ticketsDAO -> registrar_saida($tickets -> getcod_ticket(), $tickets-> getdata_saida(), $tickets-> getvalor());

        $vagasDAO = new VagasDAO();
        $res_vagas = $vagasDAO -> liberar_vaga($cod_vaga);

        break;
}


?>
