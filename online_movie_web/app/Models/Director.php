<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Director
 * 
 * @property int $id
 * @property string $director_name
 * @property int $country_id
 * 
 * @property Collection|Movie[] $movies
 *
 * @package App\Models
 */
class Director extends Model
{
	protected $table = 'director';
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'director_name',
		'country_id'
	];

	public function movies()
	{
		return $this->hasMany(Movie::class);
	}
}
