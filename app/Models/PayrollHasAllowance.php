<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollHasAllowance extends Model
{
	public $timestamps = false;

	function payroll()
	{
		return $this->belongsTo(Payroll::class, 'payroll_no', 'payroll_no');
	}
}
