<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OrderDetail extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_detail';   

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['food_id', 'order_id', 'amount', 'price', 'total', 'notes'];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders', 'order_id');
    } 
    
    
}
