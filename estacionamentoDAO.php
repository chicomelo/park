<?php
require_once ("sql.php");

class CarrosDAO extends Sql {
    function inserir();
    function atualizar();
    function deletar();
}

class VagasDAO extends Sql{
    function inserir();
    function atualizar();
    function deletar();
}

class TicketsDAO extends Sql{
    function inserir();
    function atualizar();
    function deletar();
    function buscarInfoCarro($placa,$modelo=null){
        # array com as informações do carro
        /*
        id carro, modelo carro

        */
    }
}


?>
