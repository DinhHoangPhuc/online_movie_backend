<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Genre
 * 
 * @property int $id
 * @property string $genre_name
 * 
 * @property Collection|Movie[] $movies
 *
 * @package App\Models
 */
class Genre extends Model
{
	protected $table = 'genre';
	public $timestamps = false;

	protected $fillable = [
		'genre_name'
	];

	public function movies()
	{
		return $this->belongsToMany(Movie::class, 'movie_genre');
	}
}
