<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['division_id','title','description','schedule_date','start_time','end_time','location','pic','status','created_by'];
    protected function casts(): array { return ['schedule_date' => 'date']; }
    public function division() { return $this->belongsTo(Division::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
