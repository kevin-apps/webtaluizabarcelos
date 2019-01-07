<?php

require __DIR__ . './vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Funcionario {

    private $objFuncionario;
    private $serviceAccount;
    private $firebase;
    private $database;

    public function __construct() {
        $this->serviceAccount = ServiceAccount::fromJsonFile(
                        __DIR__ . './secret/appta-luizabarcelos-24de935ad1a9.json');
        $this->firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->withDatabaseUri('https://appta-luizabarcelos.firebaseio.com')
                ->create();
    }
}
