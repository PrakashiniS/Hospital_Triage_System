<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Patient
 * 
 * @property int $patient_id
 * @property string $name
 * @property int $age
 * @property string|null $symptoms
 * @property string|null $bp
 * @property int|null $heart_rate
 * @property float|null $temperature
 * @property string|null $triage_level
 * @property int|null $assigned_bed_id
 * @property Bed|null $bed
 * @property Collection|DoctorAssignment[] $doctor_assignments
 * @property Collection|Notification[] $notifications
 *
 * @package App\Models
 */
class Patient extends Model
{
	protected $table = 'patients';
	protected $primaryKey = 'patient_id';
	public $timestamps = false;

	protected $casts = [
		'age' => 'int',
		'heart_rate' => 'int',
		'temperature' => 'float',
		'assigned_bed_id' => 'int',
	
	];

	protected $fillable = [
		'name',
		'age',
		'symptoms',
		'bp',
		'heart_rate',
		'temperature',
		'triage_level',
		'assigned_bed_id',
		
	];

	public function bed()
	{
		return $this->belongsTo(Bed::class, 'assigned_bed_id');
	}

	public function doctor_assignments()
	{
		return $this->hasMany(DoctorAssignment::class);
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class);
	}
}