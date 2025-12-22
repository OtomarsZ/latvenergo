<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Atļaujam Laravelam ierakstīt šos laukus datubāzē
    protected $fillable = ['name', 'price', 'quantity'];
}