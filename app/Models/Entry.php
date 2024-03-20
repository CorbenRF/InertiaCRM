<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Entry;
use App\Models\Department;
use App\Models\Client;
use App\Models\Curator;
use App\Models\Inspector;
use App\Models\Status;
use App\Models\Subvendor;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; // owenIt audit history plugin initialization for entry model
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Entry extends Model implements Auditable // owenIt audit history plugin initialization for entry model
{
    use \OwenIt\Auditing\Auditable; // owenIt audit history plugin initialization for entry model
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
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function clients(): HasOne
    {
        return $this->hasOne(Client::class, 'id', 'client_name_id');
    }

    public function curators(): HasOne
    {
        return $this->hasOne(Curator::class, 'id', 'curator_id');
    }

    public function inspectors(): HasOne
    {
        return $this->hasOne(Inspector::class, 'id', 'inspector_id');
    }

    public function statuses(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function vendors(): HasOne
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_name_id');
    }

    public function subvendors(): HasOne
    {
        return $this->hasOne(Subvendor::class, 'id', 'subvendor_name_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['searchClientEntryNum'] ?? null, function ($query, $search) {
            error_log($search);
            $query->where('client_entry_num', 'like', '%'.$search.'%');
        });
    }

}
