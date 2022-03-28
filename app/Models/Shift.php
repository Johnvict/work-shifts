<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    /**
     * The table should not include timestamp.
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'starts_at', 'closes_at'
    ];

    /**
     * Get schedules that belongs to worker
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'worker_id');
    }
}
