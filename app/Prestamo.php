<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    public function cliente(){
        return $this->belongsTo(Cliente::class, "cliente_id");
    }
    public function cuotas(){
        return $this->hasMany('App\Cuota');
    }
    public function abonos(){
        return $this->hasMany('App\Abono');
    }
        //Query Scope

        public function scopeMonto($query, $monto)
        {
            if($monto)
                return $query->where('monto', 'LIKE', "%$monto%");
        } 
}

