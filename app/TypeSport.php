<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filter\QueryFilters;

class TypeSport extends Model
{
	use SoftDeletes;

    //
    protected $fillable = [
        'name', 'description', 'kindsport_id'
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

    public function kindSport()
    {
        return $this->belongsTo('App\KindSport', 'kindsport_id');
    }
}
