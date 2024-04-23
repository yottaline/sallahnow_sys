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
        $centers = self::join('technicians', 'center_owner', '=', 'tech_id')
        ->orderBy('center_create', 'desc')->limit($limit);

        if($listId) $centers->where('center_id', '<', $listId);
        
        if (isset($params['q']))
        {
            $centers->where(function (Builder $query) use ($params) {
                $query->where('center_name', 'like', '%' . $params['q'] . '%')
                    ->orWhere('center_mobile', $params['q'])
                    ->orWhere('center_email', $params['q']);
            });
            unset($params['q']);
        }
        
        if ($params) $centers->where($params);

        return $id ? $centers->first() : $centers->get();
    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('center_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
    

    public function location() {
        return $this->belongsTo(Location::class);
    }
}