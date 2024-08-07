<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'amount', 'project_id', "count"
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
