<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMovimiento extends Model
{
    use HasFactory;
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
