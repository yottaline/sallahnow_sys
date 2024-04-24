<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PointTranaction extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'points_count',
        'points_src',
        'points_target',
        'points_process',
        'points_tech',
        'points_register'
    ];

    protected $casts = 
    [
        'created_at'  => 'date:Y-m-d',
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $listId = null)
    {
        $points = self::join('technicians', 'point_tranactions.points_tech', '=', 'technicians.tech_id')
        ->orderByDesc('points_register', 'desc')->limit($limit);

        if($listId) $points->where('points_id', '<', $listId);

        if (isset($params['q']))
        {
            $points->where(function (Builder $query) use ($params) {
                $query->where('points.points_register', 'like', '%' . $params['q'] . '%')
                    ->orWhere('points.points_count', $params['q'])
                    ->orWhere('technicians.tech_name', $params['q']);
            });
            unset($params['q']);
        }

        return $id ? $points->first() : $points->get();
    }

    public static function submit($params, $id)
    {
        if($id) return self::where('points_id', $id)->update($params) ? $id : false;
        $status = self::create($params);
        return $status ? $status->id : false;
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

}