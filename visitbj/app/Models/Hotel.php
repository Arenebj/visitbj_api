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
 * @property string $adresse
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|StepHebergement[] $step_hebergements
 *
 * @package App\Models
 */
class Hotel extends Model
{
	protected $table = 'hotels';

	protected $fillable = [
		'name',
		'cover',
		'description',
		'adresse'
	];

	public function step_hebergements()
	{
		return $this->hasMany(StepHebergement::class);
	}
}
