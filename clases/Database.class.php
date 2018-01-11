<?php 

	namespace clases{

		use \PDO;

		class Database{

			const HOST = "localhost";
			const NAME = "testclases";
			const USER = "root";
			const PASS = "";

			private $cnx_string;

			public function __construct(){
				$this->cnx_string = "mysql:host=".self::HOST."; dbname=".self::NAME;
			}

			public function conect(){
				return new PDO($this->cnx_string, self::USER, self::PASS);
			}

		}


	}

 ?>