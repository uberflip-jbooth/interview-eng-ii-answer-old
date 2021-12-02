<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\University;

class WebPage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'university_id',
        'url',
    ];

    /**
     * Define that a web page belongs to a university
     */
    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
