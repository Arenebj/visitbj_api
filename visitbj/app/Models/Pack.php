<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pack
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $limit_person
 * @property string $duration
 * @property int $price
 * @property string $type
 * @property int $theme_id
 * @property int|null $ratings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Theme $theme
 * @property Collection|MediaPack[] $media_packs
 * @property Collection|Step[] $steps
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Pack extends Model
{
	protected $table = 'pack';

	protected $casts = [
		'limit_person' => 'int',
		'price' => 'int',
		'theme_id' => 'int',
		'ratings' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'limit_person',
		'duration',
		'price',
		'type',
		'theme_id',
		'ratings'
	];

	public function theme()
	{
		return $this->belongsTo(Theme::class);
	}

	public function media_packs()
	{
		return $this->hasMany(MediaPack::class);
	}

	public function steps()
	{
		return $this->hasMany(Step::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_pack')
					->withPivot('id', 'number_participant')
					->withTimestamps();
	}
}
