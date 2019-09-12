
    calcularNuevaCuota();
    //Metodo para mostrar en el input de tipo tex, el id del cliente que se ha seleccionado por la etiqueta html Select

     function seleccion(){
		var seleccion = document.getElementById("cliente");
		var idCliente = seleccion.options[seleccion.selectedIndex].value;
		document.getElementById("idCliente").value = idCliente;
	}

	function calcularNuevaCuota() {
        var cuota = eval(document.getElementById("cuota").value);	
		var monto = eval(document.getElementById("monto").value);
		var interes = eval(document.getElementById("interes").value);

		var calcuInteres = interes/100;        	
        
        var nuevoSaldo = monto - cuota;

        var nuevaCuota = nuevoSaldo * calcuInteres;

        document.getElementById('nuevoSaldo').value = parseFloat(Math.round(nuevoSaldo * 100) / 100).toFixed(2);
		document.getElementById('nuevaCuota').value = parseFloat(Math.round(nuevaCuota * 100) / 100).toFixed(2);
		
	}
	  