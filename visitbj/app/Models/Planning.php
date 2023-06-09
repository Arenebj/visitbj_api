<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Planning
 * 
 * @property int $id
 * @property int $number
 * @property float|null $distance
 * @property int $park_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Park $park
 * @property Collection|ActivitiesDay[] $activities_days
 * @property Collection|EventsDay[] $events_days
 * @property Collection|HotelsDay[] $hotels_days
 *
 * @package App\Models
 */
class Planning extends Model
{
	protected $table = 'plannings';

	protected $casts = [
		'number' => 'int',
		'distance' => 'float',
		'park_id' => 'int'
	];

	protected $fillable = [
		'number',
		'distance',
		'park_id'
	];

	public function park()
	{
		return $this->belongsTo(Park::class);
	}

	public function activities_days()
	{
		return $this->hasMany(ActivitiesDay::class);
	}

	public function events_days()
	{
		return $this->hasMany(EventsDay::class);
	}

	public function hotels_days()
	{
		return $this->hasMany(HotelsDay::class);
	}
}
