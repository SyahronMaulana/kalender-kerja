<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name','code','color','description','is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }
    public function schedules() { return $this->hasMany(Schedule::class); }
}
