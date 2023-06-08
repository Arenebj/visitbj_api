<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property int $place_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Place $place
 * @property Collection|EventsDay[] $events_days
 *
 * @package App\Models
 */
class Event extends Model
{
	protected $table = 'events';

	protected $casts = [
		'price' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'place_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'price',
		'start_date',
		'end_date',
		'place_id'
	];

	public function place()
	{
		return $this->belongsTo(Place::class);
	}

	public function events_days()
	{
		return $this->hasMany(EventsDay::class);
	}
}
