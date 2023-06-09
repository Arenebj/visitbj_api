<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Hotel
 *
 * @property int $id
 * @property string $name
 * @property string $cover
 * @property string $description
 * @property int $city_id
 * @property string $adresse
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property City $city
 * @property Collection|HotelsDay[] $hotels_days
 *
 * @package App\Models
 */
class Hotel extends Model
{
	protected $table = 'hotels';

	protected $casts = [
		'city_id' => 'int'
	];

	protected $fillable = [
		'name',
		'cover',
		'description',
		'city_id',
		'adresse'
	];

	public function city()
	{
		return $this->belongsTo(City::class);
	}

	public function hotels_days()
	{
		return $this->hasOne(HotelsDay::class);
	}
}
