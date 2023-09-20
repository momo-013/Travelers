<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Schedule;

class Itinerary extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'start_at',
        'finish_at',
        'user_id'
        ];
    
    
    public function get()
    {
        return $this->orderBy('created_at', 'DESC')->get();
    }
    
        
    public function schedules()
    {
       return $this->hasMany(Schedule::class);
    }
}
