<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StepService
 * 
 * @property int $id
 * @property int $step_id
 * @property int $service_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Service $service
 * @property Step $step
 *
 * @package App\Models
 */
class StepService extends Model
{
	protected $table = 'step_service';

	protected $casts = [
		'step_id' => 'int',
		'service_id' => 'int'
	];

	protected $fillable = [
		'step_id',
		'service_id'
	];

	public function service()
	{
		return $this->belongsTo(Service::class);
	}

	public function step()
	{
		return $this->belongsTo(Step::class);
	}
}
