<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    public function prestamo(){
        #return $this->belongsTo(Cliente::class, "id_cliente");
        return $this->belongsTo(Prestamo::class, "prestamo_id");
}
}