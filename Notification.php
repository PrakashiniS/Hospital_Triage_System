<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $notification_id
 * @property int|null $user_id
 * @property int|null $patient_id
 * @property string $message
 * @property bool|null $is_read
 * @property Carbon|null $created_at
 * 
 * @property User|null $user
 * @property Patient|null $patient
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';
	protected $primaryKey = 'notification_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'patient_id' => 'int',
		'is_read' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'patient_id',
		'message',
		'is_read'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function patient()
	{
		return $this->belongsTo(Patient::class);
	}
}
