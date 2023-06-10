<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MediaPack
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
class MediaPack extends Model
{
	protected $table = 'media_pack';

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
