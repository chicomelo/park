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

    function buscar_carro_placa($placa){
        $sql = new Sql();

		$results = $sql->select("SELECT * FROM carros WHERE placa = :PLACA", array(":PLACA"=>$placa));

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

    function buscar_vagas_totais(){
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM vagas");
        return $results;
    }

    function atualizar($cod_vaga, $ativo){
        $sql = new Sql();

        $resultado = $sql -> query("UPDATE vagas
                                        SET ativo = :ATIVO
                                        WHERE cod_vaga = :COD_VAGA",
        array(":ATIVO"=>$ativo, ":COD_VAGA"=>$cod_vaga));
        return ($resultado);
    }
}

class TicketsDAO extends Sql{

    function inserir($cod_vaga, $cod_carro){
        $sql = new Sql();

        $resultado = $sql -> query("INSERT INTO tickets (cod_vaga, cod_carro, data_entrada)
                        VALUES (:COD_VAGA, :COD_CARRO, NOW())",
        array(":COD_VAGA"=>$cod_vaga, ":COD_CARRO"=>$cod_carro ));
        return ($resultado);
    }

    function registrar_saida($cod_ticket, $data_saida, $valor){
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

    function buscar_info_carro($cod_carro){
        $sql = new Sql();
		$results = $sql->select("SELECT * FROM tickets WHERE cod_carro = :COD_CARRO ORDER BY cod_ticket DESC LIMIT 1", array(":COD_CARRO"=>$cod_carro));
		return $results;
    }

    function buscar_info_cod($cod_ticket){
        $sql = new Sql();
		$results = $sql->select("SELECT * FROM tickets WHERE cod_ticket = :COD_TICKET", array(":COD_TICKET"=>$cod_ticket));
		return $results;
    }
}

?>
