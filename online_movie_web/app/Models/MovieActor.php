<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MovieActor
 * 
 * @property int $actor_id
 * @property int $movie_id
 * 
 * @property Actor $actor
 * @property Movie $movie
 *
 * @package App\Models
 */
class MovieActor extends Model
{
	protected $table = 'movie_actor';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'actor_id' => 'int',
		'movie_id' => 'int'
	];

	public function actor()
	{
		return $this->belongsTo(Actor::class);
	}

	public function movie()
	{
		return $this->belongsTo(Movie::class);
	}
}
