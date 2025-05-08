<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DoctorAssignment
 * 
 * @property int $assignment_id
 * @property int|null $doctor_id
 * @property int|null $patient_id
 * @property Carbon|null $assigned_time
 * @property string|null $status
 * 
 * @property User|null $user
 * @property Patient|null $patient
 *
 * @package App\Models
 */
class DoctorAssignment extends Model
{
	protected $table = 'doctor_assignments';
	protected $primaryKey = 'assignment_id';
	public $timestamps = false;

	protected $casts = [
		'doctor_id' => 'int',
		'patient_id' => 'int',
		'assigned_time' => 'datetime'
	];

	protected $fillable = [
		'doctor_id',
		'patient_id',
		'assigned_time',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'doctor_id');
	}

	public function patient()
	{
		return $this->belongsTo(Patient::class);
	}
}
