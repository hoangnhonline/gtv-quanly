<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RestaurantImg extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restaurant_img';   

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
    protected $fillable = [
                    'restaurant_id', 
                    'image_url', 
                    'display_order',                    
                    'type',
                    'status'
                ];
    
}