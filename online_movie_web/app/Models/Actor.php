<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Actor
 * 
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property string $picture
 * 
 * @property Country $country
 * @property Collection|Movie[] $movies
 *
 * @package App\Models
 */
class Actor extends Model
{
	protected $table = 'actor';
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'name',
		'country_id',
		'picture'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function movies()
	{
		return $this->belongsToMany(Movie::class, 'movie_actor');
	}
}
