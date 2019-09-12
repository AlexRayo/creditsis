<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    #protected $table = 'cuotas';
    #protected $idPrestamo = 'id_prestamo';

        public function prestamo(){
        #return $this->belongsTo(Cliente::class, "id_cliente");
        return $this->belongsTo(Prestamo::class, "prestamo_id");
    } 
}
