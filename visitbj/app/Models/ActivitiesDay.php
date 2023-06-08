<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivitiesDay
 * 
 * @property int $id
 * @property int $planning_id
 * @property int $activity_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Activity $activity
 * @property Planning $planning
 *
 * @package App\Models
 */
class ActivitiesDay extends Model
{
	protected $table = 'activities_day';

	protected $casts = [
		'planning_id' => 'int',
		'activity_id' => 'int'
	];

	protected $fillable = [
		'planning_id',
		'activity_id'
	];

	public function activity()
	{
		return $this->belongsTo(Activity::class);
	}

	public function planning()
	{
		return $this->belongsTo(Planning::class);
	}
}
