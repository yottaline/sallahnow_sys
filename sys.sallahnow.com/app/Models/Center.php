<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Center extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'center_id',
        'center_owner',
        'center_name',
        'center_logo',
        'center_cr',
        'center_email',
        'center_mobile',
        'center_tel',
        'center_whatsapp',
        'center_tax',
        'center_country',
        'center_state',
        'center_city',
        'center_area',
        'center_address',
        'center_rate',
        'center_create_by',
        'center_modify',
        'center_modify_by',
        'center_create'
    ];


    public static function fetch($id = 0, $params = null, $limit = null, $listId = null)
    {
        $centers = self::join('technicians', 'centers.center_owner', '=', 'technicians.tech_id')
        ->orderBy('centers.center_create', 'desc')->limit($limit);

        if (isset($params['q']))
        {
            $centers->where(function (Builder $query) use ($params) {
                $query->where('centers.center_name', 'like', '%' . $params['q'] . '%')
                    ->orWhere('centers.center_mobile', $params['q'])
                    ->orWhere('centers.center_email', $params['q']);
            });
            unset($params['q']);
        }
        
        if($listId) $centers->where('tech_id', '<', $listId);

        return $id ? $centers->first() : $centers->get();
    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('center_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
    
    public static function towCondition($elOneCondition, $op, $elTowCondition, $oneCondition,  $opt, $towCondition)
    {
        $centers = self::where($elOneCondition,  $op, $elTowCondition)->where($oneCondition,  $opt, $towCondition);
        return $centers->first();
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }
}