<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rols'; // Especifica el nombre de la tabla
    protected $fillable = ['nombre']; // Campos que se pueden asignar masivamente

    public function Users()
    {
        return $this->hasMany(User::class);
    }
}