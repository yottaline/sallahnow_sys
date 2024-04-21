<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Compatibilities_suggestions extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'sugg_status',
        'sugg_points',
        'sugg_act_note',
        'sugg_act_time',
        'sugg_category',
        'sugg_tech',
        'sugg_act_by'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $listId = null)
    {
        $suggestions = self::join('technicians', 'compatibilities_suggestions.sugg_tech', '=', 'technicians.tech_id')
        ->join('users', 'compatibilities_suggestions.sugg_act_by', '=', 'users.id')
        ->join('compatibility_categories', 'compatibilities_suggestions.sugg_category', '=', 'compatibility_categories.category_id')
        ->orderBy('sugg_act_time', 'desc')->limit($limit);

        if (isset($params['q']))
        {
            $suggestions->where(function (Builder $query) use ($params) {
                $query->where('centers.sugg_points', 'like', '%' . $params['q'] . '%')
                    ->orWhere('compatibility_categories.category_name', $params['q']);
            });
            unset($params['q']);
        }
        
        if($listId) $suggestions->where('sugg_id', '<', $listId);

        return $id ? $suggestions->first() : $suggestions->get();
    }

    public function category() {
        return $this->belongsTo(Compatibility_categorie::class, 'sugg_category' , 'category_id');
    }

    public function technician() {
        return $this->belongsTo(Technician::class, 'sugg_tech', 'tech_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'sugg_act_by');
    }

    public function models() {
        return $this->belongsToMany(Models::class, 'compatibilities_suggestions_models','comp_sug_id');
    }

}