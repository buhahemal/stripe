<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $dateFormat = 'U';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'profileimg',
        'birthdate',
        'currentaddress',
        'permenentaddress'
    ];

    protected $hidden = [
        'pivot'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birthdate' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    /**
     * Add a mutator to ensure convert date to unixtimestamp
     */
    public function setbirthdateAttribute($dateOfBirth)
    {
        $this->attributes['birthdate'] = strtotime($dateOfBirth);
    }

    /**
     * Add a mutator to ensure convert date to unixtimestamp
     */
    public function getprofileimgAttribute($value)
    {
        return asset('public/profileimages/'.$value);
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'user_has_roles','userid','roleid')->select(['rolename','roleid'])->withTimestamps();
    }
}
