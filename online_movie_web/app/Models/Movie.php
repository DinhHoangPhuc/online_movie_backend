<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Movie
 * 
 * @property int $id
 * @property string $title
 * @property Carbon $release_year
 * @property string $srcipt_summary
 * @property string $source
 * @property string $trailer
 * @property Carbon $moive_length
 * @property string $poster
 * @property int $director_id
 * 
 * @property Director $director
 * @property Collection|Actor[] $actors
 * @property Collection|Country[] $countries
 * @property Collection|Genre[] $genres
 *
 * @package App\Models
 */
class Movie extends Model
{
	protected $table = 'movie';
	public $timestamps = false;

	protected $casts = [
		'release_year' => 'string',
		'moive_length' => 'datetime',
		'director_id' => 'int'
	];

	protected $fillable = [
		'title',
		'release_year',
		'srcipt_summary',
		'source',
		'trailer',
		'moive_length',
		'poster',
		'director_id'
	];

	public function director()
	{
		return $this->belongsTo(Director::class);
	}

	public function actors()
	{
		return $this->belongsToMany(Actor::class, 'movie_actor', 'movie_id', 'actor_id');
	}

	public function countries()
	{
		return $this->belongsToMany(Country::class, 'movie_country', 'movie_id', 'country_id');
	}

	public function genres()
	{
		return $this->belongsToMany(Genre::class, 'movie_genre', 'movie_id', 'genre_id');
	}
}
