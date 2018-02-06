<?php
//criação da classe modelo
class Carros{
	//definição das colunas existentes na tabela do banco de dados
	private $cod_carro;
	private $placa;
	private $modelo;
	private $cor;

	public function getcod_carro(){
		return $this->cod_carro;
	}

	public function setcod_carro($cod_carro){
		$this->cod_carro = $cod_carro;
	}

	public function getplaca(){
		return $this->placa;
	}

	public function setplaca($placa){
		$this->placa = $placa;
	}

	public function getmodelo(){
		return $this->modelo;
	}

	public function setmodelo($modelo){
		$this->modelo = $modelo;
	}

	public function getcor(){
		return $this->cor;
	}

	public function setcor($cor){
		$this->cor = $cor;
	}

	//formatando a apresentação do objeto - método __toString()
	public function __toString(){
		return
				"cod_carro: ".$this->getcod_carro().
				"<br> placa: ".$this->getplaca().
				"<br> modelo: ".$this->getmodelo().
				"<br> cor: ".$this->getcor();
	}
}


class Vagas{
	//defini��o das colunas existentes na tabela do banco de dados
	private $cod_vaga;
	private $numero;
	private $ativo;

	public function getcod_vaga(){
		return $this->cod_vaga;
	}

	public function setcod_vaga($cod_vaga){
		$this->cod_vaga = $cod_vaga;
	}

	public function getnumero(){
		return $this->numero;
	}

	public function setnumero($numero){
		$this->numero = $numero;
	}

	public function getativo(){
		return $this->ativo;
	}

	public function setativo($ativo){
		$this->ativo = $ativo;
	}

	//formatando a apresentação do objeto - método __toString()
	public function __toString(){
		return
				"cod_vaga: ".$this->getcod_vaga().
				"<br> numero: ".$this->getnumero().
				"<br> ativo: ".$this->getativo();
	}
}


class Tickets{
	//defini��o das colunas existentes na tabela do banco de dados
	private $cod_ticket;
    private $cod_vaga;
    private $cod_carro;
	private $data_entrada;
	private $data_saida;
    private $valor;

	public function getcod_ticket(){
		return $this->cod_ticket;
	}

	public function setcod_ticket($cod_ticket){
		$this->cod_ticket = $cod_ticket;
	}

	public function getcod_vaga(){
		return $this->cod_vaga;
	}

	public function setcod_vaga($cod_vaga){
		$this->cod_vaga = $cod_vaga;
	}

    public function getcod_carro(){
        return $this->cod_carro;
    }

    public function setcod_carro($cod_carro){
        $this->cod_carro = $cod_carro;
    }

	public function getdata_entrada(){
		return $this->data_entrada;
	}

	public function setdata_entrada($data_entrada){
		$this->data_entrada = $data_entrada;
	}

	public function getdata_saida(){
		return $this->data_saida;
	}

	public function setdata_saida($data_saida){
		$this->data_saida = $data_saida;
	}

	public function getvalor(){
		return $this->valor;
	}

	public function setvalor($valor){
		$this->valor = $valor;
	}

	//formatando a apresentação do objeto - método __toString()
	public function __toString(){
		return
				"cod_ticket: ".$this->getcod_ticket().
				"<br> cod_vaga: ".$this->getcod_vaga().
                "<br> cod_carro: ".$this->getcod_carro().
                "<br> data_entrada: ".$this->getdata_entrada().
                "<br> data_saida: ".$this->getdata_saida().
				"<br> valor: ".$this->getvalor();
	}
}

?>
