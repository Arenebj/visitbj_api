<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Park
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $limit_person
 * @property string $duration
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property int $price
 * @property string|null $exclusion
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $theme_id
 * 
 * @property Theme $theme
 * @property Collection|MediaPark[] $media_parks
 * @property Collection|Planning[] $plannings
 * @property Collection|Reservation[] $reservations
 *
 * @package App\Models
 */
class Park extends Model
{
	protected $table = 'parks';

	protected $casts = [
		'limit_person' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'price' => 'int',
		'theme_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'limit_person',
		'duration',
		'start_date',
		'end_date',
		'price',
		'exclusion',
		'type',
		'theme_id'
	];

	public function theme()
	{
		return $this->belongsTo(Theme::class);
	}

	public function media_parks()
	{
		return $this->hasMany(MediaPark::class, 'pack_id');
	}

	public function plannings()
	{
		return $this->hasMany(Planning::class);
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class);
	}
}
