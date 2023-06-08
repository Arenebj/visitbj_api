<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventsDay
 * 
 * @property int $id
 * @property int $planning_id
 * @property int $event_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Event $event
 * @property Planning $planning
 *
 * @package App\Models
 */
class EventsDay extends Model
{
	protected $table = 'events_day';

	protected $casts = [
		'planning_id' => 'int',
		'event_id' => 'int'
	];

	protected $fillable = [
		'planning_id',
		'event_id'
	];

	public function event()
	{
		return $this->belongsTo(Event::class);
	}

	public function planning()
	{
		return $this->belongsTo(Planning::class);
	}
}
