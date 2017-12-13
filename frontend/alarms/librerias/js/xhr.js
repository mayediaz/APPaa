// Instancia un nuevo objeto XMLHttpRequest

function obtenerXHR(url, containerid, cargar){

	var req = false;
	if (XMLHttpRequest){ // Firefox, Safari, etc.
		req = new XMLHttpRequest();
	}
	else{
		if (ActiveXObject){ // Internet Explorer
			// Definimos un vector con las distintas posibilidades
			var vectorVersiones = ["MSXML2.XMLHttp.5.0", "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0", "MSXML2.XMLHttp", "Microsoft.XMLHttp"];

			// Lo recorremos e intentamos instanciar cada uno
			for(var i=0 ; i<vectorVersiones.length ; i++){
				try{
					req = new ActiveXObject(vectorVersiones[i]);
					return req;
				} catch (e){}
			}
		}
		return req;
	}

	var capa_contenedora = document.getElementById(cargar);

	req.open('GET', url, true);
	req.onreadystatechange=function(){
		if(req.readyState == 4){
			// La petición terminó
			document.getElementById(containerid).style.opacity="1.00";
			if(req.status == 200){
				capa_contenedora.innerHTML = '';
				mostrarTexto(req, containerid);
			}
		}
		else{
			document.getElementById(containerid).style.opacity="0.10";
			capa_contenedora.innerHTML = '<img src="../recursos/img/ajax-loader(3).gif" border=0 height=15 width=190 >';
		}
	}
	req.send(null);
}

function mostrarTexto(req, containerid){
	document.getElementById(containerid).innerHTML=req.responseText;
}

function obtenerXHRImagen(url, containerid, cargar, imagen){

	var req = false;
	if (XMLHttpRequest){ // Firefox, Safari, etc.
		req = new XMLHttpRequest();
	}
	else{
		if (ActiveXObject){ // Internet Explorer
			// Definimos un vector con las distintas posibilidades
			var vectorVersiones = ["MSXML2.XMLHttp.5.0", "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0", "MSXML2.XMLHttp", "Microsoft.XMLHttp"];

			// Lo recorremos e intentamos instanciar cada uno
			for(var i=0 ; i<vectorVersiones.length ; i++){
				try{
					req = new ActiveXObject(vectorVersiones[i]);
					return req;
				} catch (e){}
			}
		}
		return req;
	}

	var capa_contenedora = document.getElementById(cargar);

	req.open('GET', url, true);
	req.onreadystatechange=function(){
		if(req.readyState == 4){
			// La petición terminó
			//document.getElementById(containerid).style.opacity="1.00";
			if(req.status == 200){
				capa_contenedora.innerHTML = '';
				mostrarTexto(req, containerid);
			}
		}
		else{
			//document.getElementById(containerid).style.opacity="0.10";
			capa_contenedora.innerHTML = '<img src="../recursos/imagenes/'+imagen+'">';
		}
	}
	req.send(null);
}

function formato_numero(numero, decimales, separador_decimal, separador_miles){ // v2007-08-06
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }
    if(decimales!==undefined){
        numero=numero.toFixed(decimales);	// Redondeamos
    }
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ","); // Convertimos el punto en separador_decimal
    if(separador_miles){
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})"); // Añadimos los separadores de miles
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }
    return numero;
}