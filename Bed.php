<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bed
 * 
 * @property int $bed_id
 * @property string $bed_type
 * @property bool|null $is_occupied
 * @property string|null $ward_number
 * 
 * @property Collection|Patient[] $patients
 *
 * @package App\Models
 */
class Bed extends Model
{
	protected $table = 'beds';
	protected $primaryKey = 'bed_id';
	public $timestamps = false;

	protected $casts = [
		'is_occupied' => 'bool'
	];

	protected $fillable = [
		'bed_type',
		'is_occupied',
		'ward_number'
	];

	public function patients()
	{
		return $this->hasMany(Patient::class, 'assigned_bed_id');
	}
}
