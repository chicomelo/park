<!DOCTYPE html>
<html>
<head>
    <title>Estacionamento</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <script src="assets/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <link href="assets/estilo.css" type="text/css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="conteudo">

                    <div class="row">
                        <div class="col-md-5">
                            <div class="logo">
                                <img src="assets/img/logo.png" alt="Panda Ticket" width="190" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <p class="bem-vindo">Seja bem-vindo ao Panda Ticket, seu sistema para controlar entrada e saída dos carros do seu estacionamento!
                        </div>
                    </div>

                    <form name="busca_carro" method="post" action="" class="inline">
                        <h3>Digite a placa do carro</h3>
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="text" name="placa" id="placa-buscar" placeholder="XXX-YYYY" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info" id="btn-buscar" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Buscando">Buscar</button>
                            </div>
                        </div>
                    </form>

                    <div class="resultado">
                    </div>

                    <div class='cadastrar-carro'>
                        <p>Nenhum veículo encontrado</p>
                        <input type='button' value='Cadastrar' id='btn-iniciar-cadastro' class='btn btn-success'>
                    </div>

                    <div class='msg-sucesso'>
                        <center><i class="fa fa-check" aria-hidden="true"></i> Carro cadastrado com sucesso!</center>
                    </div>


                    <form action="" method="post" name="form_cadastrar" id="form_cadastrar">
                        <h4>Cadastrar carro</h4>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="placa">Placa</label>
                                    <input type="text" name="placa" class="form-control" id="placa-cadastrar" placeholder="Placa" value="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input type="text" name="modelo" class="form-control" id="modelo-cadastrar" placeholder="Modelo" value="">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="cor">Cor</label>
                                    <input type="text" name="cor" class="form-control" id="cor-cadastrar" placeholder="Cor" value="">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="cor">Vaga</label>
                                    <select class="form-control" name="vaga" id="vaga-cadastrar">
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <label>&nbsp;</label><br>
                                <button type="button" class="btn btn-success" id="btn-cadastrar" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Cadastrando">Cadastrar</button>
                            </div>
                        </div>
                    </form>

                    <form action="" method="post" name="form_entrada_saida" id="form_entrada_saida">
                        <h4>Gerenciar carro</h4>

                        <table class="table">
                            <tr>
                                <th>Placa</th>
                                <th>Modelo</th>
                                <th>Cor</th>
                                <th>Vaga</th>
                                <th>Ação</th>
                            </tr>
                            <tr>
                                <td class="placa_carro"></td>
                                <td class="modelo_carro"></td>
                                <td class="cor_carro"></td>
                                <td>
                                <select class="form-control" name="vaga-carro" id="vaga-carro">
                                </select>
                                </td>
                                <td>
                                <button type="button" class="btn btn-success" id="btn-entrada" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando" data-cod_carro="">Entrada</button>
                                <button type="button" class="btn btn-warning" id="btn-saida" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando" data-cod_carro="">Saída</button>
                            </tr>
                        </table>
                    </form>

                    <div class="tab-pagamento">
                        <table class="table">
                            <tr>
                                <td>Entrada:</td>
                                <td class="data-entrada"></td>
                                <td>Saída:</td>
                                <td class="data-saida"></td>
                                <td>Permanência:</td>
                                <td class="permanencia"></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>Valor total:</td>
                                <td class="valor-total"></td>
                            </tr>
                        </table>
                    </div>

                    <script type="text/javascript">

                        $(function(){

                            var cadastrar_carro = $('.cadastrar-carro');
                            var form_es = $('#form_entrada_saida');
                            var btn_entrada = $('#btn-entrada');
                            var btn_saida = $("#btn-saida");
                            var msg_sucesso = $(".msg-sucesso");
                            var tab_pagamento = $(".tab-pagamento");

                            $('#btn-buscar').on('click', function() {
                                cadastrar_carro.hide();
                                form_es.hide();
                                btn_entrada.hide();
                                btn_saida.hide();

                                var placa_buscar = $('#placa-buscar').val();

                                if(placa_buscar){
                                    var $this = $(this);
                                    $this.button('loading');

                                    var url = "estacionamento.php?acao=buscar-carro";

                                    $.post( url, {placa_buscar: placa_buscar}, function(){})
                                    .done(function(response) {

                                        //var res = $.parseJSON(response);
                                        //console.log(response);
                                        setTimeout(function() {
                                            if(response['acao'] == 0){
                                                // cacso precise cadastrar o carro
                                                cadastrar_carro.fadeIn();
                                            }else if(response['acao'] == 1){
                                                // caso esteja fazendo entrada
                                                alert("abre entrada");
                                            }else if(response['acao'] == 2){
                                                // Caso esteja saindo
                                                form_es.fadeIn();
                                                btn_saida.fadeIn()
                                                $("#vaga-carro").append(response['options']);
                                                $("#vaga-carro").attr('disabled', 'disabled');
                                                btn_saida.attr('data-cod-ticket', response['cod_ticket']);

                                                //popula a tabela
                                                $('.placa_carro').html(response['carro']['placa']);
                                                $('.modelo_carro').html(response['carro']['modelo']);
                                                $('.cor_carro').html(response['carro']['cor']);
                                            }
                                            $this.button('reset');
                                        }, 1000);
                                    })
                                    .fail(function() {
                                    });

                                }else{
                                    alert('Digite a placa do carro')
                                }
                            });

                            $('#btn-iniciar-cadastro').on('click', function() {
                                cadastrar_carro.hide();
                                var $this = $(this);
                                var placa_buscar = $('#placa-buscar').val();
                                var resultado = $('.resultado');
                                var form_cadastrar = $('#form_cadastrar');
                                $this.button('loading');
                                var url = "estacionamento.php?acao=buscar-vagas-disponiveis";

                                $.post( url, '', function(){})
                                .done(function(response) {
                                    resultado.html('');
                                    resultado.fadeOut();
                                    form_cadastrar.fadeIn();
                                    $('#placa-cadastrar').attr('value',placa_buscar);
                                    $('#vaga-cadastrar').append(response);
                                    setTimeout(function() {
                                        $this.button('reset');
                                    }, 1000);
                                })
                                .fail(function() {
                                });
                            });

                            $('#btn-cadastrar').on('click', function() {
                                var $this = $(this);
                                var placa_cadastrar = $('#placa-cadastrar').val();
                                var modelo_cadastrar = $('#modelo-cadastrar').val();
                                var cor_cadastrar = $('#cor-cadastrar').val();

                                if((placa_cadastrar != '') && (modelo_cadastrar != '') && (cor_cadastrar != '')){
                                    $this.button('loading');

                                    var form_cadastrar = $('#form_cadastrar');
                                    var url = "estacionamento.php?acao=cadastrar-carro";

                                    $.post( url, form_cadastrar.serialize(), function(){})
                                    .done(function(response) {
                                        console.log(response);
                                        setTimeout(function() {
                                            form_cadastrar[0].reset();
                                            form_cadastrar.hide();
                                            $this.button('reset');
                                            msg_sucesso.fadeIn();
                                            setTimeout(function(){
                                                msg_sucesso.fadeOut('slow');
                                            }, 5000)
                                        }, 1000);
                                    })
                                    .fail(function() {
                                    });

                                }else{
                                    alert("Preencha todos os campos");
                                }
                            });

                            $('#btn-entrada').on('click', function() {
                                alert('oi');
                                var $this = $(this);
                                var carro = $this.attr('data-cod_carro');
                                var vaga = $('#vaga-entrada option:selected').val();
                                var resultado = $('.resultado');

                                $this.button('loading');

                                var url = "estacionamento.php?acao=entrada-carro";

                                $.post( url, { cod_carro: carro, cod_vaga: vaga } , function(){})
                                .done(function(response) {
                                    resultado.html(response);
                                    resultado.slideDown();
                                    setTimeout(function() {
                                        $this.button('reset');
                                    }, 1000);
                                })
                                .fail(function() {
                                });
                            });
                            $('#btn-saida').on('click', function() {
                                cadastrar_carro.hide();
                                btn_entrada.hide();

                                btn_saida.button('loading');

                                var ticket = $(this).attr('data-cod-ticket');
                                var vaga = $('#vaga-carro option:selected').val();

                                var url = "estacionamento.php?acao=saida-carro";

                                $.post( url, { cod_ticket: ticket, cod_vaga: vaga } , function(){})
                                .done(function(response) {
                                    console.log(response);
                                    setTimeout(function() {
                                        form_es.hide();
                                        $('.data-entrada').html(response['data_entrada']);
                                        $('.data-saida').html(response['data_saida']);
                                        $('.permanencia').html(response['permanencia']);
                                        $('.valor-total').html(response['valor_total']);

                                        tab_pagamento.fadeIn();
                                        btn_saida.button('reset');
                                    }, 1000);
                                })
                                .fail(function() {
                                });

                                /*
                                var $this = $(this);
                                var carro = $this.attr('data-cod_carro');
                                var vaga = $('#vaga-entrada option:selected').val();
                                var resultado = $('.resultado');

                                $this.button('loading');


                                $.post( url, { cod_carro: carro, cod_vaga: vaga } , function(){})
                                .done(function(response) {
                                    resultado.html(response);
                                    resultado.slideDown();
                                    setTimeout(function() {
                                        $this.button('reset');
                                    }, 1000);
                                })
                                .fail(function() {
                                });
                                */
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="conteudo" style="height:100%;">
                    <h3>Vagas Disponíveis</h3>
                    <div class="vagas">
                        <?php
                        for($i=0; $i<80; $i++){
                            if($i % 8 == 0){
                                ?>
                                <div class="clearfix"></div>
                                <?php
                            }
                            ?>
                            <div class="vaga"></div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
</html>


<?php
//
// $servername = "localhost";
// $username = "root";
// $password = "vertrigo";
// $dbname = "estacionamento";
//
// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
//
// for($i = 0; $i<80; $i++){
// $sql = "INSERT INTO vagas (numero, ativo) VALUES ($i+1, '1')";
// if ($conn->query($sql) === TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }
// }
//
// $conn->close();
?>
