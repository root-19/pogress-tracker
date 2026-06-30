<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'status',
        'module_id',
    ];
    
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
