<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: text/html; charset=utf-8');

require_once("sql.php");
require_once("estacionamentoDAO.php");
require_once("estacionamento.class.php");

$acao = $_GET['acao'];

switch ($acao){
    case 'cadastrar-carro':

        $carros = new Carros();
        $carros->setplaca($_POST['placa']);
        $carros->setmodelo($_POST['modelo']);
        $carros->setcor($_POST['cor']);

        $carrosDAO = new CarrosDAO();
        $resultado = $carrosDAO-> inserir($carros->getplaca(), $carros->getmodelo(), $carros->getcor());

        $vagasDAO = new VagasDAO();
        $vagas_ativas = $vagasDAO->buscar_vagas_ativas();

        $options = '';
        foreach($vagas_ativas as $vagas){
            $options .= '<option value="'.$vagas['cod_vaga'].'">'.$vagas['numero'].'</option>';
        }


        if($resultado){

            $html = '<table class="table">
                <tr>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Cor</th>
                    <th>Vaga</th>
                    <th>Ação</th>
                </tr>
                <tr>
                    <td>'.$carros->getplaca().'</td>
                    <td>'.$carros->getmodelo().'</td>
                    <td>'.$carros->getcor().'</td>
                    <td>
                    <select class="form-control ">
                        '.$options.'
                    </select>
                    </td>
                    <td><input type="button" value="Entrada" class="btn btn-success"></td>
                </tr>
            </table>';

            echo $html;

        }else{
            echo "ERRO";
        }

    break;
    }

?>
