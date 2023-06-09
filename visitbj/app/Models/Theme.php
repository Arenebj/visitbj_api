<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Theme
 * 
 * @property int $id
 * @property string $label
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $cover
 * 
 * @property Collection|Park[] $parks
 *
 * @package App\Models
 */
class Theme extends Model
{
	protected $table = 'theme';

	protected $fillable = [
		'label',
		'cover'
	];

	public function parks()
	{
		return $this->hasMany(Park::class);
	}
}
