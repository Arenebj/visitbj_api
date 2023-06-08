<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reservation
 * 
 * @property int $id
 * @property int $user_id
 * @property int $park_id
 * @property int|null $number_participant
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Park $park
 * @property User $user
 * @property Collection|RoomDetail[] $room_details
 *
 * @package App\Models
 */
class Reservation extends Model
{
	protected $table = 'reservation';

	protected $casts = [
		'user_id' => 'int',
		'park_id' => 'int',
		'number_participant' => 'int'
	];

	protected $fillable = [
		'user_id',
		'park_id',
		'number_participant'
	];

	public function park()
	{
		return $this->belongsTo(Park::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function room_details()
	{
		return $this->hasMany(RoomDetail::class);
	}
}
