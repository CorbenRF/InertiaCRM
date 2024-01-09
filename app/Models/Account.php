<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
