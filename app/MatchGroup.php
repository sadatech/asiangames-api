<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\QueryFilters;

class MatchGroup extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'matchentry_id', 'athlete_id', 
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

	/* Metode tambahan untuk model Match Grouping. */

	/**
     * Relation Method(s).
     *
     */

	public function athlete()
    {
        return $this->belongsTo('App\Athlete', 'athlete_id');
    }

    public function matchEntry()
    {
        return $this->belongsTo('App\MatchEntry', 'matchentry_id');
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
