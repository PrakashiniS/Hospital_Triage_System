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
 * @property int $user_id
 * @property string $username
 * @property string $password_hash
 * @property string $name
 * @property string $role
 * @property string|null $phone
 * @property string|null $email
 * @property Carbon|null $created_at
 * 
 * @property Collection|DoctorAssignment[] $doctor_assignments
 * @property Collection|Notification[] $notifications
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'user_id';
	public $timestamps = false;

	protected $fillable = [
		'username',
		'password_hash',
		'name',
		'role',
		'phone',
		'email'
	];

	public function doctor_assignments()
	{
		return $this->hasMany(DoctorAssignment::class, 'doctor_id');
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class);
	}
}