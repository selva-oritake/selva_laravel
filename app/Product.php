<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id', 'member_id', 'product_category_id', 'product_subcategory_id', 'name', 'image_1', 'image_2', 'image_3', 'image_4', 'product_content', 'email', 'created_at',
    ];
}
