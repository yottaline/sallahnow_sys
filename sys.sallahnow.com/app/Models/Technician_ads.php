<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Technician_ads extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'ads_id',
        'ads_title',
        'ads_photo',
        'ads_body',
        'ads_url',
        'ads_start',
        'ads_end',
        'ads_create_user',
        'ads_create_time'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
   {
        $ads = self::join('users', 'technician_ads.ads_create_user', '=', 'users.id')
                ->orderByDesc('ads_create_time')->limit($limit);

        if ($lastId) $ads->where('ads_id', '<', $lastId);

        if (isset($params['q']))
        {
            $ads->where(function (Builder $query) use ($params) {
                $query->where('user_name', 'like', '%' . $params['q'] . '%')
                    ->orWhere('ads_body', 'like', '%' . $params['q'] . '%')
                    ->orWhere('ads_title', 'like', '%' . $params['q'] . '%');
            });
            unset($params['q']);
        }

        if ($params) $ads->where($params);

        if ($id) $ads->where('ads_id', $id);

        return $id ? $ads->first() : $ads->get();
   }

   public static function submit($param, $id)
   {
    if ($id) return self::where('ads_id', $id)->update($param) ? $id : false;
    $status = self::create($param);
    return $status ? $status->id : false;
   }

    public function user() {
        return $this->belongsTo(User::class, 'ads_create_user', 'ads_id');
    }
}