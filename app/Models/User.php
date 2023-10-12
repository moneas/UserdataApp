<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Laravel\Passport\HasApiTokens;

class User extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'country_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

}
