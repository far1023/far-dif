<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
	public $timestamps = false;

	function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	function allowances()
	{
		return $this->hasMany(PayrollHasAllowance::class, 'payroll_no', 'payroll_no');
	}
}
