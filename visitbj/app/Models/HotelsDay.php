<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HotelsDay
 *
 * @property int $id
 * @property int $planning_id
 * @property int $hotel_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Hotel $hotel
 * @property Planning $planning
 *
 * @package App\Models
 */
class HotelsDay extends Model
{
	protected $table = 'hotels_day';

	protected $casts = [
		'planning_id' => 'int',
		'hotel_id' => 'int'
	];

	protected $fillable = [
		'planning_id',
		'hotel_id'
	];

	public function hotel()
	{
		return $this->belongsTo(Hotel::class);
	}

	public function planning()
	{
		return $this->belongsTo(Planning::class);
	}
}
