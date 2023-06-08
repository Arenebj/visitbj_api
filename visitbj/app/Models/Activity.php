<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $place_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Place $place
 * @property Collection|ActivitiesDay[] $activities_days
 *
 * @package App\Models
 */
class Activity extends Model
{
	protected $table = 'activities';

	protected $casts = [
		'price' => 'int',
		'place_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'price',
		'place_id'
	];

	public function place()
	{
		return $this->belongsTo(Place::class);
	}

	public function activities_days()
	{
		return $this->hasMany(ActivitiesDay::class);
	}
}
