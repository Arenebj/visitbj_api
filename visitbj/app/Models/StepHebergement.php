<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StepHebergement
 * 
 * @property int $id
 * @property int $step_id
 * @property int $hotel_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Hotel $hotel
 * @property Step $step
 *
 * @package App\Models
 */
class StepHebergement extends Model
{
	protected $table = 'step_hebergement';

	protected $casts = [
		'step_id' => 'int',
		'hotel_id' => 'int'
	];

	protected $fillable = [
		'step_id',
		'hotel_id'
	];

	public function hotel()
	{
		return $this->belongsTo(Hotel::class);
	}

	public function step()
	{
		return $this->belongsTo(Step::class);
	}
}
