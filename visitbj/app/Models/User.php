<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $email
 * @property string $phone_number
 * @property string $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $reference
 * @property bool $deleted
 * 
 * @property Collection|Pack[] $packs
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'deleted' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'password',
		'email',
		'phone_number',
		'role',
		'reference',
		'deleted'
	];

	public function packs()
	{
		return $this->belongsToMany(Pack::class, 'user_pack')
					->withPivot('id', 'number_participant')
					->withTimestamps();
	}
}
