<?php

//
// index.js:
// pesquisarCarro();
// novoTicket();
// mostrarVaga();
//
// -> controller.php
//
// class estacionamento()
//
// -> DAO
// class vagas()
// class carros()
// class ticket()
//
// sql.php
//
//
// view: index.php
// controller: estacionamento.php
// model: estacionamentoDAO.php


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
