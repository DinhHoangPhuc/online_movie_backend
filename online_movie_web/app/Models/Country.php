<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * 
 * @property int $id
 * @property string $country_name
 * 
 * @property Collection|Actor[] $actors
 * @property Collection|Movie[] $movies
 *
 * @package App\Models
 */
class Country extends Model
{
	protected $table = 'country';
	public $timestamps = false;

	protected $fillable = [
		'country_name'
	];

	public function actors()
	{
		return $this->hasMany(Actor::class);
	}

	public function movies()
	{
		return $this->belongsToMany(Movie::class, 'movie_country');
	}
}
