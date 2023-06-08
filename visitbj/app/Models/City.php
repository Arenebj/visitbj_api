<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * 
 * @property int $id
 * @property string $name
 * @property string $cover
 * @property string $description
 * @property float $longitude
 * @property float $latitude
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Hotel[] $hotels
 * @property Collection|Place[] $places
 *
 * @package App\Models
 */
class City extends Model
{
	protected $table = 'cities';

	protected $casts = [
		'longitude' => 'float',
		'latitude' => 'float'
	];

	protected $fillable = [
		'name',
		'cover',
		'description',
		'longitude',
		'latitude'
	];

	public function hotels()
	{
		return $this->hasMany(Hotel::class);
	}

	public function places()
	{
		return $this->hasMany(Place::class);
	}
}
