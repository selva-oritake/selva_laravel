<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'id', 'member_id', 'product_id', 'evaluation', 'comment', 'created_at',
    ];
}
