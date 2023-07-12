<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSubcategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'product_category_id', 'name', 'created_at',
    ];
}
