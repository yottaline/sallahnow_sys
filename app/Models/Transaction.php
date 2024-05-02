<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable =[
        'trans_id',
        'trans_method',
        'trans_amount',
        'trans_process',
        'trans_ref',
        'trans_create_by',
        'trans_tech'
    ];
    protected $casts = [
        'created_at'  => 'date:Y-m-d',
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $listId = null, $select = null)
    {
        $transactions = self::join('technicians', 'transactions.trans_tech', 'technicians.tech_id')
        ->limit($limit)->orderBy('transactions.trans_id', 'desc');

        if($listId) $transactions->where('trans_id', '<', $listId);

        if (isset($params['q']))
        {
            $transactions->where(function (Builder $query) use ($params) {
                $query->where('trans_amount', 'like', '%' . $params['q'] . '%')
                    ->orWhere('trans_method', $params['q'])
                    ->orWhere('tech_name', $params['q'])
                    ->orWhere('trans_ref', $params['q']);
            });
            unset($params['q']);
        }

        if ($id) $transactions->where('trans_id', $id);
        
        return $id ? $transactions->first() : $transactions->get();
    }

    public static function submit($params, $id)
    {
        if($id) return self::where('trans_id', $id)->update($params) ? $id : false;
        $status = self::create($params);
        return $status ? $status->id : false;
    }


    public function technician() {
        return $this->belongsTo(Technician::class);
    }
}