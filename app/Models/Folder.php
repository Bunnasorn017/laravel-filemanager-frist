<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function getFullPathAttribute()
    {
        $path = $this->name;
        $parent = $this->parent;

        while ($parent) {
            $path = $parent->name . '/' . $path;
            $parent = $parent->parent;
        }

        return $path;
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
}