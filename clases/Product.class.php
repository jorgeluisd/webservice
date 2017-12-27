<?php 

	namespace clases{

		use \PDO;
		use \clases;

		class Product{

			public function __construct(){
				$db = new Database();
				$this->cnx = $db->conect();
			}

			public function getFileProducts($file=null){

				if ($file) {
					$productsJSON = file_get_contents($file);
					if ($productsJSON) {
						$products = json_decode($productsJSON);
						$this->insertProducts($products);
					}
				}
				else{
					echo "Archivo invalido";
				}
			}

			public function insertProducts($products){

				$query = "";
				foreach ($products as $arreglo) {
					$query = "INSERT INTO products (id,name,price) VALUES(:id,:name,:price)";

					$statemant = $this->cnx->prepare($query);

					$statemant->bindParam(":id", $arreglo->id, PDO::PARAM_INT);
					$statemant->bindParam(":name", $arreglo->name, PDO::PARAM_STR);
					$statemant->bindParam(":price", $arreglo->price, PDO::PARAM_STR);

					if( $statemant->execute() ){
						echo "<ul>";
						echo "<li> <strong>".$arreglo->name."</strong> INSERTADO CORRECTAMENTE </li>";
						echo "</ul>";
					}
					
				}
			}

			public function getAllProducts(){
				$query = "SELECT id, name, price, date_created 
						  FROM products 
				          WHERE status = 1 
				         ";

				$statemant = $this->cnx->prepare($query);
				if ( $statemant->execute() ) {
					return $statemant->fetchAll(PDO::FETCH_ASSOC);
				}
				else{
					echo "error en la consulta";
				}				
			}

			public function getProduct($id){
				$query = "SELECT id, name, price, date_created 
						  FROM products 
				          WHERE id = :id AND status = 1 
				         ";

				$statemant = $this->cnx->prepare($query);
				$statemant->bindValue(":id", $id, PDO::PARAM_INT);
				if ( $statemant->execute() ) {
					return $statemant->fetchAll(PDO::FETCH_ASSOC);
				}
				else{
					echo "error en la consulta";
				}				
			}

			public function destroy($id){
				$query = "UPDATE products
						  SET status = -1  
				          WHERE id = :id 
				         ";

				$statemant = $this->cnx->prepare($query);
				$statemant->bindValue(":id", $id, PDO::PARAM_INT);
				if ( $statemant->execute() ) {
					return true;
				}
				else{
					echo "error en la consulta";
				}				
			}

		}


	}

 ?>