<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\APIResponse;
use App\Models\PayrollHasAllowance;
use Illuminate\Support\Facades\Validator;

class PayrollController extends Controller
{
	public function index()
	{
		try {
			return response()->json(
				new APIResponse(
					true,
					"Generated payrolls",
					Payroll::with(['employee', 'allowances'])->get()
				),
				200
			);
		} catch (\Throwable $th) {
			return response()->json(
				new APIResponse(
					false,
					$th->getMessage()
				),
				500
			);
		}
	}

	public function show(int $id)
	{
		try {
			if ($data = Payroll::with(['employee', 'allowances'])->find($id)) {
				return response()->json(
					new APIResponse(
						true,
						"Payroll found",
						$data
					),
					200
				);
			}

			return response()->json(
				new APIResponse(
					false,
					"Data not found"
				),
				404
			);
		} catch (\Throwable $th) {
			return response()->json(
				new APIResponse(
					false,
					$th->getMessage()
				),
				500
			);
		}
	}

	/**
	 * generate payroll by month and year from request
	 * with employee_id (optional)
	 */
	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'month' => ['required', 'in:1,2,3,4,5,6,7,8,9,10,11,12'],
				'year' => ['required'],
				'employee_id' => ['nullable', 'exists:employees,id'],
			],
			[
				'month.required' => 'month is required',
				'month.in' => 'month value not valid',
				'year.required' => 'year is required',
				'employee_id.exists' => 'Employee not found',
			]
		);

		if ($validator->fails()) {
			return response()->json(
				new APIResponse(
					false,
					"Invalid input",
					$validator->errors()->toArray()
				),
				422
			);
		}


		$data = Employee::whereHas('contracts', function ($query) use ($request) {
			$query->whereMonth('start', '<=', $request->month)
				->whereMonth('end', '>=', $request->month);
			$query->whereYear('start', '<=', $request->year)
				->whereYear('end', '>=', $request->year);
		})
			->orWhereHas('allowances')
			->with(
				[
					'contracts' => function ($query) use ($request) {
						$query->whereMonth('start', '<=', $request->month)
							->whereMonth('end', '>=', $request->month);
						$query->whereYear('start', '<=', $request->year)
							->whereYear('end', '>=', $request->year);
					},
					'allowances.allowance'
				]
			);

		if ($request->employee_id) {
			$data = $data->where('id', $request->employee_id);
		}

		$payroll = $payroll_no = [];

		$data = $data->get();

		if ($data) {
			foreach ($data as $i => $value) {
				$basic_salary = $allowance_amount = 0;

				if ($value->contracts) {
					foreach ($value->contracts as $contract) {
						$basic_salary += $contract->basic_salary;
					}
				}

				$payroll_no[] = $use_payroll_no = Str::random(15);
				$payroll[$i] = [
					"payroll_no" => $use_payroll_no,
					"month" => $request->month,
					"year" => $request->year,
					"employee_id" => $value->id,
					"salary_amount" => $basic_salary,
					"created_at" => date('Y-m-d H:i:s'),
					"created_by" => 1
				];

				if ($value->allowances) {
					$payroll_has_allowance = [];

					foreach ($value->allowances as $j => $allowance) {
						if ($allowance->allowance->fix_amount) {
							$allowance_amount += $allowance->allowance->fix_amount;
							$amount = $allowance->allowance->fix_amount;
						} else {
							$allowance_amount += ($allowance->allowance->percentage_on_basic / 100 * $basic_salary);
							$amount = $allowance->allowance->percentage_on_basic / 100 * $basic_salary;
						}
						$payroll_has_allowance[$j]['payroll_no'] = $use_payroll_no;
						$payroll_has_allowance[$j]['allowance_name'] = $allowance->allowance->name;
						$payroll_has_allowance[$j]['allowance_amount'] = $amount;
					}
				}

				$payroll[$i]["allowance_amount"] = $allowance_amount;
				$payroll[$i]["take_home_pay"] = $basic_salary + $allowance_amount;
			}

			try {
				Payroll::insert($payroll);
				PayrollHasAllowance::insert($payroll_has_allowance);

				return response()->json(
					new APIResponse(
						true,
						"Payroll generated",
						$payroll
					),
					200
				);
			} catch (\Throwable $th) {
				PayrollHasAllowance::where('payroll_no', $payroll_no)->delete();

				return response()->json(
					new APIResponse(
						false,
						$th->getMessage()
					),
					500
				);
			}
		}

		return response()->json(
			new APIResponse(
				false,
				"No employee found",
			),
			200
		);
	}

	public function update()
	{
		abort(404);
	}

	public function destroy(int $id)
	{
		$data = Payroll::findOrFail($id);

		try {
			$data->delete();
			return response()->json(
				new APIResponse(
					true,
					"Payroll data deleted",
				),
				200
			);
		} catch (\Throwable $th) {
			return response()->json(
				new APIResponse(
					false,
					$th->getMessage()
				),
				500
			);
		}
	}
}
