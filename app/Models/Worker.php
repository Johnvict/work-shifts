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
        return $this->hasMany(Schedule::class, 'worker_id');
    }
}
