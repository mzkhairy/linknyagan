<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pageSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_description',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
