<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoomDetail
 * 
 * @property int $id
 * @property int $reservation_id
 * @property string $room_type
 * @property int $number_of_room
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Reservation $reservation
 *
 * @package App\Models
 */
class RoomDetail extends Model
{
	protected $table = 'room_details';

	protected $casts = [
		'reservation_id' => 'int',
		'number_of_room' => 'int'
	];

	protected $fillable = [
		'reservation_id',
		'room_type',
		'number_of_room'
	];

	public function reservation()
	{
		return $this->belongsTo(Reservation::class);
	}
}
