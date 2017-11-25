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

                        <div class="cadastrar-carro">
                            <p>Nenhum veículo encontrado</p>
                            <input type="button" value="Cadastrar" id="btn-iniciar-cadastro" class="btn btn-success">
                        </div>

                        <!-- <table class="table">
                            <tr>
                                <th>Modelo</th>
                                <th>Cor</th>
                                <th>Ação</th>
                            </tr>
                            <tr>
                                <td>Gol</td>
                                <td>Vermelho</td>
                                <td><input type="button" value="Entrada" class="btn btn-success"></td>
                            </tr>
                            <tr>
                                <td>Gol</td>
                                <td>Vermelho</td>
                                <td><input type="button" value="Saída" class="btn btn-warning"></td>
                            </tr>
                        </table> -->
                    </div>

                    <script>

                    $(function(){
                        $('#btn-buscar').on('click', function() {
                            var placa_buscar = $('#placa-buscar').val();

                            if(placa_buscar){
                                var $this = $(this);
                                var resultado = $('.resultado');
                                $this.button('loading');
                                setTimeout(function() {
                                    $this.button('reset');
                                    resultado.slideDown();
                                }, 1000);
                            }else{
                                alert('Digite a placa do carro')
                            }
                        });
                        $('#btn-iniciar-cadastro').on('click', function() {
                            var resultado = $('.resultado');
                            var form_cadastro = $('#form_cadastrar');
                            var placa_buscar = $('#placa-buscar').val();
                            setTimeout(function() {
                                resultado.html('');
                                resultado.append(form_cadastro);
                                $('#placa-cadastro').attr('value',placa_buscar)
                                form_cadastro.fadeIn();
                            }, 100);
                        });
                        $('#btn-cadastrar').on('click', function() {
                            var placa_cadastrar = $('#placa-cadastrar').val();
                            var modelo_cadastrar = $('#modelo-cadastrar').val();
                            var cor_cadastrar = $('#cor-cadastrar').val();

                            if((placa_cadastrar != '') && (modelo_cadastrar != '') && (cor_cadastrar != '')){

                                var resultado = $('.resultado');
                                var form_cadastrar = $('#form_cadastrar').serialize();
                                var url = "estacionamento.php?acao=cadastrar-carro";

                                $.post( url, form_cadastrar , function(){})
                                .done(function(response) {
                                    resultado.html(response);
                                    resultado.slideDown();
                                })
                                .fail(function() {
                                });

                            }else{
                                alert("Preencha todos os campos");
                            }


                        });
                    });

                    </script>

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
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="cor">Cor</label>
                                    <input type="text" name="cor" class="form-control" id="cor-cadastrar" placeholder="Cor" value="">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label>&nbsp;</label><br>
                                <input type="button" name="btn-cadastrar" value="Cadastrar" id="btn-cadastrar" class="btn btn-success">
                            </div>
                        </div>
                    </form>

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
