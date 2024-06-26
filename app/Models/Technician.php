<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Technician extends Authenticatable implements JWTSubject
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'tech_id';

    protected $fillable = [
        'tech_id',
        'tech_center',
        'tech_name',
        'tech_code',
        'tech_email',
        'tech_email_verefied',
        'tech_mobile',
        'tech_mobile_verefied',
        'tech_tel',
        'tech_password',
        'tech_identification',
        'tech_birth',
        'tech_country',
        'tech_state',
        'tech_city',
        'tech_area',
        'tech_rate',
        'tech_pkg',
        'tech_points',
        'tech_address',
        'tech_bio',
        'tech_notes',
        'devise_token',
        'tech_blocked',
        'tech_login',
        'tech_modify',
        'tech_credit',
        'tech_register_by',
        'tech_modify_by',
        'tech_register'
    ];

    public static function fetch($id = 0, $params = null ,$limit = null, $listId = null, $select = null)
    {
        $technicians = self::orderBy('tech_register', 'desc')->limit($limit);

        if($listId) $technicians->where('tech_id', '<', $listId);

        if (isset($params['q']))
        {
            $technicians->where(function (Builder $query) use ($params) {
                $query->where('tech_name', 'like', '%' . $params['q'] . '%')
                    ->orWhere('tech_mobile', $params['q'])
                    ->orWhere('tech_email', $params['q']);
            });
            unset($params['q']);
        }

        if($params) $technicians->where($params);

        return $id ? $technicians->first() : $technicians->get();
    }

    public static function submit($param, $id = null)
    {
        if ($id) return self::where('tech_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->tech_id : false;
    }

    protected $casts = [
        'password' => 'hashed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'tech_register_by');
    }

    public function suggestions()
    {
        return $this->hasMany(Compatibilities_suggestions::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscriptions::class);
    }

    public function points()
    {
        return $this->hasMany(PointTranaction::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function likes()
    {
        return $this->hasMany(Post_Like::class, 'like_tech', 'tech_id');
    }

    public function comments()
    {
        return $this->hasMany(Post_Comment::class);
    }

    public function post_views()
    {
        return $this->hasMany(Post_View::class);
    }

    public function members()
    {
        return $this->hasMany(Chat_Room_Members::class);
    }

    public function messages()
    {
        return $this->hasMany(Chat_Room_Message::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(Support_ticket::class);
    }

    public function supportReplie()
    {
        return $this->hasMany(Support_replie::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ['tech_id'];
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}