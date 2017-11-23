<!DOCTYPE html>
<html>
<head>
    <title>Estacionamento</title>
    <meta charset="utf-8">
    <link href="estilo.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

</head>
<body>
    <div class="container">

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
