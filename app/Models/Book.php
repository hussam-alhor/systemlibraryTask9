<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
    protected $fillable = [
        'title',
        'genre',
        'avilable',
    ];
}



