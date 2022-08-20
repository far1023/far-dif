<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeHasAllowance extends Model
{
	public $timestamps = false;

	function allowance()
	{
		return $this->belongsTo(Allowance::class);
	}

	function employee()
	{
		return $this->belongsTo(Employee::class);
	}
}
