<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BedAvailability
 * 
 * @property int $availability_id
 * @property string $ward_number
 * @property int $total_beds
 * @property string $ward_incharge
 *
 * @package App\Models
 */
class BedAvailability extends Model
{
	protected $table = 'bed_availability';
	protected $primaryKey = 'availability_id';
	public $timestamps = false;

	protected $casts = [
		'total_beds' => 'int'
	];

	protected $fillable = [
		'ward_number',
		'total_beds',
		'ward_incharge'
	];
}
