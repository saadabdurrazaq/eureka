<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes; //trash user 

    protected $guard_name = 'web';

    public function category()
    {
        return $this->belongsToMany('App\Category');
    }

    public function stok()
    {
        // one product has one stok relationship 
        return $this->hasOne('App\Stok', 'product_id', 'id'); // id refer to stok relationship.id 
    }

    public function image()
    {
        // one product has many images (group of images)
        return $this->hasMany('App\Image'); // id refer to image.id
    }

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'product_code'
    ];

    protected $table = "products";
    protected $primaryKey = "id";
}
