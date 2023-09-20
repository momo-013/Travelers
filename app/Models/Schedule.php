<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Itinerary;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'itinerary_id',
        'date',
        'start_at',
        'finish_at',
        'title',
        ];
        
    
    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}
