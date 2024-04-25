<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Support_ticket extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'ticket_id',
        'ticket_code',
        'ticket_brand',
        'ticket_model',
        'ticket_category',
        'ticket_cost',
        'ticket_context',
        'ticket_status',
        'ticket_tech',
        'ticket_create'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastID = null)
    {
        $supportTickets = self::join('brands', 'support_tickets.ticket_brand', '=', 'brands.brand_id')
        ->join('models', 'support_tickets.ticket_model', '=', 'models.model_id')
        ->join('support_categories', 'support_tickets.ticket_category', '=', 'support_categories.category_id')
        ->join('technicians', 'support_tickets.ticket_tech', '=', 'technicians.tech_id')
        ->limit($limit)->orderByDesc('ticket_create');

        if($lastID) $supportTickets->where('ticket_id', '<', $lastID);

        if (isset($params['q']))
        {
            $supportTickets->where(function (Builder $query) use ($params) {
                $query->where('support_tickets.ticket_code', 'like', '%' . $params['q'] . '%')
                    ->orWhere('models.model_name', $params['q'])
                    ->orWhere('technicians.tech_name', $params['q']);
            });
            unset($params['q']);
        }

        if ($params) $supportTickets->where($params);

        if ($id) $supportTickets->where('ticket_id', $id);

        return $id ? $supportTickets->first() : $supportTickets->get();
    }

    public static function submit($param, $id)
   {
    if ($id) return self::where('ticket_id', $id)->update($param) ? $id : false;
    $status = self::create($param);
    return $status ? $status->ticket_id : false;
   }

    public function brand() {
        return $this->belongsTo(Brand::class, 'ticket_brand', 'ticket_id');
    }

    public function model() {
        return $this->belongsTo(Model::class, 'ticket_model', 'ticket_id');
    }

    public function supportCategory() {
        return $this->belongsTo(Support_category::class, 'ticket_category', 'ticket_id');
    }

    public function technician() {
        return $this->belongsTo(Technician::class, 'ticket_tech', 'ticket_id');
    }

    public function supportReplie() {
        return $this->hasMany(Support_replie::class);
    }

    public function supportAttachment() {
        return $this->hasMany(Support_attachment::class);
    }

}