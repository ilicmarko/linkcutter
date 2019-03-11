<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Feature
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plan[] $plans
 * @mixin \Eloquent
 */
class Feature extends Model
{
    use HasSlug;

    protected $guarded = [];

    public function plans()
    {
        return $this->belongsToMany('App\Plan');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
