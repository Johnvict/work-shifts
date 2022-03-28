<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Worker extends Model
{
    use HasFactory;

    /**
     * The attributes excluded from the model returned details.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'designation'
    ];

    /**
     * Relation to schedules a worker owns
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class)->with('shift');
    }

    /**
     *  Work Shifts which a user is assigned
     *
     * @return Illuminate\Database\Eloquent\Concerns\HasRelationships::belongsToMany
     */
    public function shifts()
    {
        return $this->belongsToMany(
            Shift::class,   // Target model
            "schedules",    // Pivot Table name
            "worker_id",    // Foreign key on schedules table...
            "shift_id",     // Foreign key on schedules table...
            "id",           // Local key on worker table...
            "id"            // Local key on shifts table...
        )
        ->with('schedules')
        ->groupBy('shifts.type');
    }
}
