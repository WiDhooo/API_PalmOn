<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUmum extends Model
{
    protected $fillable = [
        'username',
        'password',
        'email',
        'no_telp',
        'profile_picture',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the full URL of the profile picture.
     *
     * @return string|null
     */
    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture ? asset($this->profile_picture) : null;
    }

    /**
     * Automatically hash the password when set.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
