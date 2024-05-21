<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * 
 * @property int $id
 * @property int $users_id
 * @property int $plan_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $status
 * 
 * @property Plan $plan
 * @property User $user
 *
 * @package App\Models
 */
class Subscription extends Model
{
	protected $table = 'subscription';
	public $timestamps = false;

	protected $casts = [
		'users_id' => 'int',
		'plan_id' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime'
	];

	protected $fillable = [
		'users_id',
		'plan_id',
		'start_date',
		'end_date',
		'status'
	];

	public function plan()
	{
		return $this->belongsTo(Plan::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}
}
