<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_password',
        'user_mobile',
        'user_active',
        'user_group',
        'user_create'
    ];

    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $users = self::join('user_groups', 'users.user_group', '=', 'user_groups.ugroup_id')
        ->orderBy('users.user_create', 'desc')->limit($limit);

        if($lastId) $users->where('id', '<', $lastId);

        if (isset($params['q']))
        {
            $users->where(function (Builder $query) use ($params) {
                $query->where('user_name', 'like', '%' . $params['q'] . '%')
                    ->orWhere('user_mobile', $params['q'])
                    ->orWhere('user_email', $params['q']);
            });
            unset($params['q']);
        }

        if($params) $users->where($params);

        if ($id) $users->where('id', $id);

        return $id ? $users->first() : $users->get();

    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }

    public function technicians() {
        return $this->hasMany(Technician::class);
    }

    public function role() {
        return $this->belongsTo(User_group::class, 'user_group', 'ugroup_id');
    }

    public function brands () {
        return $this->hasMany(Brand::class);
    }
    public function models () {
        return $this->hasMany(Models::class);
    }

    public function suggestions() {
        return $this->hasMany(Compatibilities_suggestions::class);
    }

    public function comments() {
        return $this->hasMany(Post_Comment::class);
    }

    public function supportReplie() {
        return $this->hasMany(Support_replie::class);
    }

}
