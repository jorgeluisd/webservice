()=>{
	var seeAll = document.querySelector(".see-all");
	var consult = document.querySelector(".consult");
	var result = document.querySelector("#result");
	var body = document.querySelector("body");

	body.addEventListener("click",(e)=>{
		(e.target.name=="del")? seeAllProducts("products/"+e.target.id+"/destroy"):;
	});

	seeAll.addEventListener("click",()=>{seeAllProducts("products")} );

	consult.addEventListener("click",()=>{
		var productId = document.querySelector("#productId");
		var id = productId.value.trim();
		
		if (id) {
			if (isNaN(id)) {
				productId.value = "";
				return alert("Por favor inserte solo numeros");
			}
		}
		else{
			return alert("El campo id no puede estar vacio");
		}
		seeAllProducts("products/"+id);
	});

	function seeAllProducts(url) {

		var xhrProducts = new XMLHttpRequest();
		xhrProducts.open("GET", url);

		xhrProducts.addEventListener("progress",(e)=>{
			if (e.lengthComputable) {
				var porcentaje = (e.loaded*100)/e.total;
				var p = document.createElement("p");
				p.innerText = "Cargando " + porcentaje +"%";
				result.appendChild(p);
				console.log(p.innerText);
				if (porcentaje==100) {
					p.innerText = "";
				}
			}
			else{p.innerText = "Cargando... "}
		});
		
		xhrProducts.addEventListener("load",()=>{
			if (xhrProducts.status == 200) {
				var response = parseReponse(xhrProducts.response);
				console.log(response);
				renderData(response);			
			}	
		});
		xhrProducts.send();
	}

	function renderData(response) {
		var table = document.createElement("table");
		tableHeader(table);
		var i = 1;
		var row = ""; 
		var cell = "";
		
		result.innerHTML = "";

		response.forEach(function(data){
			row = table.insertRow(i); 

			cell = row.insertCell(0);
			cell.innerHTML = data.id;
			cell = row.insertCell(1);
			cell.innerHTML = data.name;
			cell = row.insertCell(2);
			cell.innerHTML = data.price;
			cell = row.insertCell(3);
			cell.innerHTML = data.date_created;
			cell = row.insertCell(4);
			
			button = document.createElement("input");
			button.type = "button"
			button.id = data.id;
			button.name = "del"
			button.value = "Del";
			
			cell.appendChild(button);
			i++;
		});
		result.appendChild(table);
	}

	function tableHeader(table){
		var header = table.createTHead();
		var row = header.insertRow(0);

		var cell = row.insertCell(0);
		cell.innerHTML = "<b>Id</b>";
		cell = row.insertCell(1);
		cell.innerHTML = "<b>Name</b>";
		cell = row.insertCell(2);
		cell.innerHTML = "<b>Price</b>";
		cell = row.insertCell(3);
		cell.innerHTML = "<b>Date Created</b>";
		cell = row.insertCell(4);
		cell.innerHTML = "<b>Action</b>";

	}

	function parseReponse(response){
		return (typeof response == "string")? JSON.parse(response) : response;
	}
};

