<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'category_id');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id');
    }

    public function masterSla()
    {
        return $this->hasOne(MasterSla::class, 'category_id');
    }
}