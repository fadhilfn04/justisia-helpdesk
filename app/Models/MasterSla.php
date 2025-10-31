<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSla extends Model
{
    use HasFactory;

    protected $table = 'master_sla';
    protected $fillable = ['prioritas', 'category_id'];

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }
}