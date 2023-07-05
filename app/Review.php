<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id', 'member_id', 'product_id', 'evaluation', 'comment', 'created_at',
    ];
}
