<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo',
        'proveedor',
        'responsable', // Responsable
        'fecha', // Fecha del movimiento
        'observacion', // Observación
    ];

    // Relaciones
    public function detalles()
    {
        return $this->hasMany(DetalleMovimiento::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable'); // Relación con el usuario responsable
    }
}
