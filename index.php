<?php
require __DIR__ . './vendor/autoload.php';

require_once "classes/Funcoes.class.php";
$objFc = new Funcoes();

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// This assumes that you have placed the Firebase credentials in the same directory
// as this PHP file.
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . './secret/appta-luizabarcelos-24de935ad1a9.json');

$firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        // The following line is optional if the project id in your credentials file
        // is identical to the subdomain of your Firebase project. If you need it,
        // make sure to replace the URL with the URL of your project.
        ->withDatabaseUri('https://appta-luizabarcelos.firebaseio.com')
        ->create();

$database = $firebase->getDatabase();
$values = $database->getReference()->getChild('almoco')->getValue();
?>


<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Criando Relatório em PDF</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Nome:</th>
                    <th>Data:</th>
                    <th>Hora:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($values as $rstMn) {
                    foreach ($rstMn as $indice => $valor) {
                        foreach ($rstMn as $rstAt) {
                            ?>
                            <tr>
                                <td><?= $rstAt['name'] ?></td>
                                <td><?= $rstAt['date'] ?></td>
                                <td><?= $rstAt['time'] ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
        </table>
    </body>
</html>



