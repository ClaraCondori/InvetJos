<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio_vent',
        'precio_comp',
        'cantidad',
    ];

    // Relación "pertenece a" con el modelo Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    } 
    public function detalle()
    {
        return $this->hasMany(DetalleMovimiento::class, 'producto_id');
    }   
}
