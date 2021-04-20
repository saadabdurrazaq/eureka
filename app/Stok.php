<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stok extends Model
{
    use SoftDeletes; //trash user 

    protected $guard_name = 'web';

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'jumlah_barang', 'product_photo'
    ];

    protected $table = "stok";
    protected $primaryKey = "id";
}
