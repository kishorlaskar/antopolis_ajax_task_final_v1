<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcat extends Model
{
    protected $fillable = ['category_id','subcategory_name','subcategory_description','Publication_status'];
}
