<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','brand_id','product_name','product_image','product_color,',
        'product_size','product_quantity','product_short_description','product_long_description','publication_status'


    ];
}
