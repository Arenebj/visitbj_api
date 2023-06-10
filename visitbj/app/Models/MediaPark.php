<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MediaPark
 * 
 * @property int $id
 * @property string $type
 * @property string $path
 * @property int $pack_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Pack $pack
 *
 * @package App\Models
 */
class MediaPark extends Model
{
	protected $table = 'media_park';

	protected $casts = [
		'pack_id' => 'int'
	];

	protected $fillable = [
		'type',
		'path',
		'pack_id'
	];

	public function pack()
	{
		return $this->belongsTo(Pack::class);
	}
}
