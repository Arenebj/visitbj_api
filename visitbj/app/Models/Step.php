<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Step
 * 
 * @property int $id
 * @property int $number
 * @property float|null $distance
 * @property int $pack_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Pack $pack
 * @property Collection|StepHebergement[] $step_hebergements
 * @property Collection|Service[] $services
 *
 * @package App\Models
 */
class Step extends Model
{
	protected $table = 'step';

	protected $casts = [
		'number' => 'int',
		'distance' => 'float',
		'pack_id' => 'int'
	];

	protected $fillable = [
		'number',
		'distance',
		'pack_id'
	];

	public function pack()
	{
		return $this->belongsTo(Pack::class);
	}

	public function step_hebergements()
	{
		return $this->hasMany(StepHebergement::class);
	}

	public function services()
	{
		return $this->belongsToMany(Service::class, 'step_service')
					->withPivot('id')
					->withTimestamps();
	}
}
