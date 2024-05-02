<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Subscriptions extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'sub_id',
        'sub_start',
        'sub_end',
        'sub_status',
        'sub_tech',
        'sub_pkg',
        'sub_points',
        'sub_cost',
        'sub_period',
        'sub_priv',
        'sub_register_by',
        'sub_register'
    ];

    public static function fetch($id = 0, $params = null ,$limit = null, $listId = null)
    {
        $subscriptions = self::join('technicians', 'subscriptions.sub_tech', '=', 'technicians.tech_id')
        ->orderBy('subscriptions.sub_register', 'desc')->limit($limit);

        if($listId) $subscriptions->where('sub_id', '<', $listId);


        if (isset($params['q']))
        {
            $subscriptions->where(function (Builder $query) use ($params) {
                $query->where('sub_points', 'like', '%' . $params['q'] . '%')
                    ->orWhere('tech_name', $params['q'])
                    ->orWhere('sub_pkg', $params['q']);
            });
            unset($params['q']);
        }

        if ($params) $subscriptions->where($params);

        if ($id) $subscriptions->where('sub_id', $id);

        return $id ? $subscriptions->first() : $subscriptions->get();
    }

    public static function submit($params, $id = null)
    {
        if ($id) return self::where('sub_id', $id)->update($params) ? $id : false;
        $status = self::create($params);
        return $status ? $status->id : false;
    }

    public static function parse($realTime, $time)
    {
        return Carbon::parse($realTime)->addMonth($time);
    }


    public static function changeStatus($id)
    {
        return self::where('sub_tech', $id)->update(['sub_status' => 0]);
    }

    public function technicians() {
        return $this->belongsToMany(Technician::class);
    }
}