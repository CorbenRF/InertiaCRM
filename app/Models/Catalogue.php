<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Catalogue extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $fillable = ['name'];

    public function entries()
    {
        return $this->belongsToMany(Entry::class);
    }
}
