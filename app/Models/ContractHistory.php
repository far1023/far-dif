<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractHistory extends Model
{
	use HasFactory;
	protected $guarded = [];

	function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	public function scopeActive($query)
	{
		$query->selectRaw('*');
		$query->whereRaw('end IN(SELECT MAX(end) FROM contract_histories GROUP BY employee_id)');
		return $query->groupBy('contract_histories.employee_id');
	}
}
