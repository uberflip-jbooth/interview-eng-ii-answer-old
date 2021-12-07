<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\University;

class Domain extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'university_id',
        'domain_name',
    ];

    /**
     * Define that a domain belongs to a university
     */
    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
