<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DriverAreaNew extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'driver_area_new';

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    protected $fillable = [      
      'driver_id',
      'area_id',
    ];

    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'area_id');
    }
}	