<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BookingBk extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'booking_bk_2';

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 
                            'phone', 
                            'facebook', 
                            'email',
                            'hotel_book',
                            'book_date',
                            'checkin',
                            'checkout',
                            'use_date',
                            'address',
                            'infants',                           
                            'last_address', 
                            'adults', 
                            'childs', 
                            'total_price',
                            'extra_fee', 
                            'discount', 
                            'type', 
                            'price_adult',
                            'price_adult_original', 
                            'meals', 
                            'price_child',
                            'price_child_original',
                            'total_price_adult',
                            'total_price_child',
                            'tien_coc',
                            'ngay_coc',
                            'status',
                            'con_lai',
                            'notes',
                            'user_id',
                            'hoa_hong_cty',
                            'hoa_hong_sales',
                            'extra_fee_notes',
                            'hotel_id',
                            'call_status',
                            'pickup_status',
                            'hdv_id',
                            'hdv_notes',
                            'mail_hotel',
                            'mail_customer',
                            'booking_code',
                            'notes_hotel',
                            'danh_sach',
                            'don_bay',
                            'tien_bay',
                            'tour_id',
                            'tour_type',
                            'tour_cate',
                            'export',
                            'phone_1',
                            'nguoi_thu_coc', // 1 sales , 2 cty
                            'nguoi_thu_tien', // 1 sales , 2 cty, 3 dieu hanh
                            'ctv_id',
                            'city_id',
                            'ko_cap_treo',
                            'location_id',
                            'tien_thuc_thu',
                            'dieuhanh_id',
                            'time_pickup',
                            'location_id_2',
                            'level',
                            'cap_nl',
                            'cap_te',
                            'driver_id',
                            'cano_id',
                            'meals_te',
                            'camera_id',
                            'partner_id',
                            'hoa_hong_chup',
                            'customer_pay_status',
                            'ptt_pay_status',
                            'price_net',    
                            'phone_sales',
                            'price_old',
                            'price_cable_adult',
                            'price_cable_child',
                            'is_grandworld',
                            'is_rachvem',
                            'grandworld_date',
                            'check_unc',
                            'created_user',
                            'updated_user',
                            'user_id_manage',
                            'mu_di_bo',
                            'hdv_thu',
                            'no_pickup',
                            'ptt_tong_tien_phong',
                            'ptt_tong_phu_thu',
                            'ptt_tong_tien_goc',
                            'ptt_pay_date',
                            'ptt_tien_coc',
                            'ptt_ngay_coc'
                            ];
    public static function getList($params = []){
        $query = self::where('status', 1);
        if( isset($params['cate_id']) && $params['cate_id'] ){
            $query->where('cate_id', $params['cate_id']);
        } 
        if( isset($params['parent_id']) && $params['parent_id'] ){
            $query->where('parent_id', $params['parent_id']);
        }        
        if( isset($params['is_hot']) && $params['is_hot'] ){
            $query->where('is_hot', $params['is_hot']);
        }
        if( isset($params['except']) && $params['except'] ){
            $query->where('id', '<>',  $params['except']);
        }        
        $query->orderBy('id', 'desc');
        if(isset($params['limit']) && $params['limit']){
            return $query->limit($params['limit'])->get();
        }
        if(isset($params['pagination']) && $params['pagination']){
            return $query->paginate($params['pagination']);
        }                
    }
    public static function getListTag($id){
        $query = TagObjects::where(['object_id' => $id, 'tag_objects.type' => 2])
            ->join('tag', 'w-tag.id', '=', 'tag_objects.tag_id')            
            ->get();
        return $query;
    }
    public function customers()
    {
        return $this->hasMany('App\Models\BookingCustomer', 'booking_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function ctv()
    {
        return $this->belongsTo('App\Models\Ctv', 'ctv_id');
    }
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }
    public function location2()
    {
        return $this->belongsTo('App\Models\Location', 'location_id_2');
    }
    public function carCate()
    {
        return $this->belongsTo('App\Models\CarCate', 'tour_id');
    }
    public function hdv()
    {
        return $this->belongsTo('App\User', 'hdv_id');
    }
    public function cano()
    {
        return $this->belongsTo('App\Models\Partner', 'cano_id');
    }
     public function updatedUser()
    {
        return $this->belongsTo('App\Models\WAccount', 'updated_user');
    }
    public function cate()
    {
        return $this->belongsTo('App\Models\WArticlesCate', 'cate_id');
    }
    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotels', 'hotel_id');
    }
    public function hotelBook()
    {
        return $this->belongsTo('App\Models\Partner', 'hotel_book', 'id');
    }
    public function driver()
    {
        return $this->belongsTo('App\Models\Drivers', 'driver_id');
    }
    public function partner()
    {
        return $this->belongsTo('App\Models\Partner', 'driver_id');
    }
    public function rooms()
    {
        return $this->hasMany('App\Models\BookingRooms', 'booking_id');
    }
    public function tickets()
    {
        return $this->hasMany('App\Models\Tickets', 'booking_id');
    }
    public function payment()
    {
        return $this->hasMany('App\Models\BookingPayment', 'booking_id');
    }
    public function bill()
    {
        return $this->hasMany('App\Models\BookingBill', 'booking_id');
    }
    public function parentCate()
    {
        return $this->belongsTo('App\Models\WCateParent', 'parent_id');
    }
    public function partnerTour()
    {
        return $this->belongsTo('App\Models\Partner', 'partner_id');
    }
}
