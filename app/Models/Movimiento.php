<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'responsable');
    }
    public function detalles()
    {
        return $this->hasMany(DetalleMovimiento::class);
    }
}
