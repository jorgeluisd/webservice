<?php 

	require 'clases.inc.php';
	use \clases\Product;
	$products = new Product;

	$buffer_param = $_GET["param"];
	$param = explode("/", $buffer_param);

	header("Content-Type:application/json");
	$method = $_SERVER["REQUEST_METHOD"];
	switch ($method){
		case 'POST':

			break;
		case 'GET':
			$cant = count($param);
			if ($cant>1) {
				$id = $param[1];
				if (isset($param[2]) && $param[2]=='destroy') {
					$products->destroy($id);
					echo json_encode($products->getAllProducts());
				}else{
					echo json_encode($products->getProduct($id));
				}
			} elseif ($param[0]=='products') {
				echo json_encode($products->getAllProducts());
			} 
			else{
				echo "No se reconoce la ruta";
			}
			break;
		default:
			header("HTTP/1.1 405 Method Not Allowed");
			break;
	}

?>