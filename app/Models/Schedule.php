<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The attributes excluded from the model's JSON form.
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
        'shift_id', 'worker_id', 'date'
    ];

    /**
     * Relation to shift to whom a schedule belongs
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Relation to worker who owns the schedule
     */
    public function workers()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}
