<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Plan
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * 
 * @property Collection|Subscription[] $subscriptions
 *
 * @package App\Models
 */
class Plan extends Model
{
	protected $table = 'plan';
	public $timestamps = false;

	protected $casts = [
		'price' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'price'
	];

	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}
}
