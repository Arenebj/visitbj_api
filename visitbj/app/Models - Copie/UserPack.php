<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPack
 * 
 * @property int $id
 * @property int $user_id
 * @property int $pack_id
 * @property int|null $number_participant
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Pack $pack
 * @property User $user
 *
 * @package App\Models
 */
class UserPack extends Model
{
	protected $table = 'user_pack';

	protected $casts = [
		'user_id' => 'int',
		'pack_id' => 'int',
		'number_participant' => 'int'
	];

	protected $fillable = [
		'user_id',
		'pack_id',
		'number_participant'
	];

	public function pack()
	{
		return $this->belongsTo(Pack::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
