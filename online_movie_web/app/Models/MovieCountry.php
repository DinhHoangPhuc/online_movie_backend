<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MovieCountry
 * 
 * @property int $movie_id
 * @property int $country_id
 * 
 * @property Country $country
 * @property Movie $movie
 *
 * @package App\Models
 */
class MovieCountry extends Model
{
	protected $table = 'movie_country';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'movie_id' => 'int',
		'country_id' => 'int'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function movie()
	{
		return $this->belongsTo(Movie::class);
	}
}
