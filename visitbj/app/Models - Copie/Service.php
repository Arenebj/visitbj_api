<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property string $type
 * @property string $place
 * @property string $city
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Step[] $steps
 *
 * @package App\Models
 */
class Service extends Model
{
	protected $table = 'services';

	protected $casts = [
		'price' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'price',
		'type',
		'place',
		'city'
	];

	public function steps()
	{
		return $this->belongsToMany(Step::class, 'step_service')
					->withPivot('id')
					->withTimestamps();
	}
}
