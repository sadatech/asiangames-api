<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\QueryFilters;

class Athlete extends Model
{
    use SoftDeletes;

    //
    protected $fillable = [
        'firstname', 'lastname', 'country_id', 'typesport_id', 'photo', 'height', 'weight', 'gender_type'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /* Metode tambahan untuk model Branch Sport. */

    /**
     * Relation Method(s).
     *
     */

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function matchGroups()
    {
        return $this->hasMany('App\MatchGroup', 'athlete_id');
    }

    public function typeSport()
    {
        return $this->belongsTo('App\TypeSport', 'typesport_id');
    }

    /**
     * Filtering Branch Sport Berdasarakan Request User
     * @param $query
     * @param QueryFilters $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
