
Date.prototype.sumar = function(year, month, day, meses) {
	f = new Date(year, month, day);
	f.setMonth(f.getMonth() + meses);
	return f;
  }
  
function fechaProxCuotaC() {
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
fechaProxCuotaC();