<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'file_path',
        'thumbnail',
        'singer_id'
    ];

    public function singer()
    {
        return $this->belongsTo(Singer::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
