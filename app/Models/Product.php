<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property false|mixed $active
 * @method static where(string $string, true $true)
 */
class Product extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $timestamps = true;
    protected $fillable = ['name', 'amount', 'value', 'active'];
}
