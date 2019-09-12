
var monto = eval(document.getElementById("monto").value);
var saldoAnterior = eval(document.getElementById("saldoAnterior").value);
document.getElementById("abonado").value=monto - saldoAnterior;

calcularCuotaMensual();
seleccion();



	 //Metodo para mostrar en el input de tipo tex, el id del cliente que se ha seleccionado por la etiqueta html Select
	 function seleccion(){
		var seleccion = document.getElementById("cliente");
		var idCliente = seleccion.options[seleccion.selectedIndex].value;
		document.getElementById("idCliente").value = idCliente;
	}

	function calcularCuotaMensual() {
	var monto = eval(document.getElementById("monto").value);
	var interes = eval(document.getElementById("interes").value);
	var abonado = eval(document.getElementById("abonado").value);
	//var num_cuotas = eval(document.getElementById("num_cuotas").value);
	//var totalCancelar = eval(document.getElementById("totalCancelar").value);

	var calcuInteres = interes/100;
	//var bruto = monto/num_cuotas;
	var interesNeto = monto * calcuInteres;	

	//var valorcuota = bruto + interesNeto;
	//var totalCancelar = valorcuota * num_cuotas;	
	var nuevoSaldo = monto - abonado;
	document.getElementById('valor_cuota').value = parseFloat(Math.round(interesNeto * 100) / 100).toFixed(2);
	document.getElementById('nuevoSaldo').value = parseFloat(Math.round(nuevoSaldo * 100) / 100).toFixed(2);
	//document.getElementById("totalCancelar").value= parseFloat(Math.round(totalCancelar * 100) / 100).toFixed(2);	
}

Date.prototype.sumar = function(year, month, day, meses) {
	f = new Date(year, month, day);
	f.setMonth(f.getMonth() + meses);
	return f;
  }
/*El nombre de la funcion para cambiar la fecha debe tener un nombre diferente al unsado en nuevoPrestamo, de lo contrario no funcionara*/  
function fechaCuotaEditPrestamo() {
	var year = new Date(document.getElementById("fecha_inicio").value).getFullYear();
	var month = new Date(document.getElementById("fecha_inicio").value).getMonth() + 1;
	var day = new Date(document.getElementById("fecha_inicio").value).getDate() + 1;
	
	var f = new Date();
	var meses = 0;	

	//Se toma la fecha actual y se le suma la cantidad de dias del prestamo 
	
	var fecha = f.sumar(year, month, day, meses);
	//Recupero el valor del dia-mes-año de la finalizacion del prestamo
	var mes = fecha.getMonth() + 1; //El mes se maneja [0-11]
	var dia = fecha.getDate();
	var anio = fecha.getFullYear();

	//String con la fecha de finalizacion con formato MM/DD/YYYY
	var fecha_fin = anio + "-" + mes + "-" + dia;

	document.getElementById("fecha_fin").value=fecha_fin ;
}
