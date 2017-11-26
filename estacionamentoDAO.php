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
    function inserir($carros){
        $sql = new Sql();

		$resultado = $sql -> query("INSERT INTO carros (placa, modelo, cor)
										VALUES (:PLACA, :MODELO, :COR)",
		array(":PLACA"=>$carros->getplaca(), ":MODELO"=>$carros->getmodelo() ,":COR"=>$carros->getcor()));
		return ($resultado);
    }

    function buscar_carro_placa($carros){
        $sql = new Sql();

		$results = $sql->select("SELECT * FROM carros WHERE placa = :PLACA", array(":PLACA"=>$carros->getplaca()));

        return $results;
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
    function deletar($cod_carro){
        $sql = new Sql();

        $resultado = $sql -> query("DELETE FROM carros WHERE cod_carro = :COD_CARRO",
        array(":COD_CARRO"=>$cod_carro));
        return ($resultado);
    }
}

class VagasDAO extends Sql{

    function buscar_vagas_disponiveis(){
        $sql = new Sql();
		$results = $sql->select("SELECT * FROM vagas WHERE ativo = 1");
		return $results;
    }

    function atualizar($vagas){
        $sql = new Sql();

        $resultado = $sql -> query("UPDATE vagas
                                        SET ativo = :ATIVO
                                        WHERE cod_vaga = :COD_VAGA",
        array(":ATIVO"=>$vagas->getativo(), ":COD_VAGA"=>$vagas->getcod_vaga()));
        return ($resultado);
    }
}

class TicketsDAO extends Sql{
    function inserir($tickets){
        $sql = new Sql();

        $resultado = $sql -> query("INSERT INTO tickets (cod_vaga, cod_carro, data_chegada)
                        VALUES (:COD_VAGA, :COD_CARRO, NOW())",
        array(":COD_VAGA"=>$tickets->getcod_vaga(), ":COD_CARRO"=>$tickets->getcod_carro() ));
        return ($resultado);
    }
    function atualizar($data_saida, $valor, $cod_ticket){
        $sql = new Sql();

        $resultado = $sql -> query("UPDATE tickets
                                        SET data_saida = :DATA_SAIDA,
                                        valor = :VALOR
                                        WHERE cod_ticket = :COD_TICKET",
        array(":DATA_SAIDA"=>$data_saida, ":VALOR"=>$valor, ":COD_TICKET"=>$cod_ticket));
        return ($resultado);
    }
    function deletar($cod_ticket){
        $sql = new Sql();

        $resultado = $sql -> query("DELETE FROM tickets WHERE cod_ticket = :COD_TICKET",
        array(":COD_TICKET"=>$cod_ticket));
        return ($resultado);
    }
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
