<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property false|mixed $active
 */
class Product extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $timestamps = true;
    protected $fillable = ['id', 'name', 'size', 'color', 'amount', 'value', 'active'];
}
