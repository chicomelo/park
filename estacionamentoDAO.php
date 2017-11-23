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
    function inserir($placa, $modelo, $cor){
        $sql = new Sql();

		$resultado = $sql -> query("INSERT INTO carros (placa, modelo, cor)
										VALUES (:PLACA, :MODELO, :COR)",
		array(":PLACA"=>$placa, ":MODELO"=>$modelo ,":COR"=>$cor));
		return ($resultado);
    }
    function atualizar($cod_carro, $placa, $modelo, $cor){
        $sql = new Sql();

        $resultado = $sql -> query("UPDATE carros
                                        SET placa = :PLACA,
                                        modelo = :MODELO,
                                        cor = :COR
                                        WHERE cod_carro = :COD_CARRO",
        array(":PLACA"=>$placa, ":MODELO"=>$modelo, ":COR"=>$cor, ":COD_CARRO"=>$cod_carro));
        return ($resultado);
    }
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
    function buscarInfoCarro($placa){

        $sql = new Sql();

        $query = "SELECT * FROM carros WHERE placa = $placa ";

		$results = $sql->select("SELECT * FROM carros WHERE placa = :PLACA", array(":PLACA"=>$placa));
		return $results;

        # array com as informações do carro
        /*
        id carro, modelo carro

        */
    }
}

?>
