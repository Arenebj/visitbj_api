<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Place
 * 
 * @property int $id
 * @property string $name
 * @property string $cover
 * @property string $description
 * @property float $longitude
 * @property float $latitude
 * @property int $city_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property City $city
 * @property Collection|Activity[] $activities
 * @property Collection|Event[] $events
 *
 * @package App\Models
 */
class Place extends Model
{
	protected $table = 'places';

	protected $casts = [
		'longitude' => 'float',
		'latitude' => 'float',
		'city_id' => 'int'
	];

	protected $fillable = [
		'name',
		'cover',
		'description',
		'longitude',
		'latitude',
		'city_id'
	];

	public function city()
	{
		return $this->belongsTo(City::class);
	}

	public function activities()
	{
		return $this->hasMany(Activity::class);
	}

	public function events()
	{
		return $this->hasMany(Event::class);
	}
}
