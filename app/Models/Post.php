<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Prefecture;

class Post extends Model
{
    use HasFactory;
    
    public function user()
    {
         return $this->belongsTo(User::class);
    }
    
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }
}
