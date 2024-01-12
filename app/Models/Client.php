<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entry;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Client extends Model
{
    use HasFactory;

    // protected $attributes = [
    //     'client_name_id' => 1,
    // ];

    public $timestamps = FALSE;
    protected $fillable = ['name'];

    public function entries()
    {
        return $this->belongsToMany(Entry::class, 'client_name_id', 'id');
    }
}
