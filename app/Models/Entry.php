<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Entry extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $fillable = ['client_entry_num', 'date_received', 'date_startby', 'date_actual_start', 'date_end', 'department_id',
    'client_name_id', 'vendor_name_id', 'subvendor_name_id', 'status_id', 'curator_id', 'inspector_id', 'comments', 'inspection_lvl'
];

// Clear entries cache upon modifying an entry
protected static function boot()
{
    parent::boot();


    static::saving(function() {
        Cache::forget('entries');
    });
}

public function departments(): HasOne
    {
        return $this->hasOne(Department::class);
    }

}
