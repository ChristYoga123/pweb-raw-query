<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function VenueCategory()
    {
        return $this->belongsTo(VenueCategory::class);
    }

    public function VenueGalleries()
    {
        return $this->hasMany(VenueGallery::class);
    }

    public function getRouteKeyName()
    {
        return "slug";
    }
}
