<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\QueryFilters;


class MatchEntry extends Model
{
	use SoftDeletes;

    //
    protected $fillable = [
        'code', 'description', 'typesport_id', 
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

	public function typeSport()
    {
        return $this->belongsTo('App\TypeSport', 'typesport_id');
    }

    public function matchGroups()
    {
        return $this->hasMany('App\MatchGroup', 'matchentry_id');
    }

    public function scheduleDetails()
    {
        return $this->hasMany('App\scheduleDetail', 'matchentry_id');
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
