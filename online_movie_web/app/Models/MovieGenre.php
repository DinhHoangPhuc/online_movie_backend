<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MovieGenre
 * 
 * @property int $genre_id
 * @property int $movie_id
 * 
 * @property Genre $genre
 * @property Movie $movie
 *
 * @package App\Models
 */
class MovieGenre extends Model
{
	protected $table = 'movie_genre';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'genre_id' => 'int',
		'movie_id' => 'int'
	];

	public function genre()
	{
		return $this->belongsTo(Genre::class);
	}

	public function movie()
	{
		return $this->belongsTo(Movie::class);
	}
}
