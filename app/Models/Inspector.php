<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entry;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspector extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $fillable = ['name'];

    public function entries()
    {
        return $this->belongsToMany(Entry::class, 'inspector_id', 'id');
    }
}
