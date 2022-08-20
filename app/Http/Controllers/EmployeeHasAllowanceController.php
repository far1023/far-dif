<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use Illuminate\Http\Request;
use App\Http\Resources\APIResponse;
use App\Models\EmployeeHasAllowance;
use Illuminate\Support\Facades\Validator;

class EmployeeHasAllowanceController extends Controller
{
	public function index()
	{
		abort(404);
	}
	public function show()
	{
		abort(404);
	}
	public function update()
	{
		abort(404);
	}
	public function destroy()
	{
		abort(404);
	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'employee_id' => ['required', 'exists:employees,id'],
				'allowances' => ['array', 'nullable'],
			],
			[
				'employee_id.required' => 'employee_id is required',
				'employee_id.exists' => 'Employee data not found',
				'allowances.array' => 'Please provide allowance data in array',
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

		$data = EmployeeHasAllowance::where('employee_id', $request->employee_id)->get();

		try {
			EmployeeHasAllowance::where('employee_id', $request->employee_id)->delete();
		} catch (\Throwable $th) {
			return response()->json(
				new APIResponse(
					false,
					$th->getMessage()
				),
				500
			);
		}

		$create = array();

		if ($request->allowances) {
			try {
				foreach ($request->allowances as $v) {
					if (Allowance::find($v)) {
						$create[] = array(
							'employee_id' => $request->employee_id,
							'allowance_id' => $v
						);
					}
				}

				if (count($create) > 0) {
					EmployeeHasAllowance::insert($create);
				} else {
					foreach ($data as $v) {
						$create[] = array(
							'employee_id' => $request->employee_id,
							'allowance_id' => $v->allowance_id
						);
					}
					EmployeeHasAllowance::insert($create);

					return response()->json(
						new APIResponse(
							false,
							"Something went wrong, allowances not updated"
						),
						422
					);
				}

				return response()->json(
					new APIResponse(
						true,
						"Employee's allowance has been updated"
					),
					201
				);
			} catch (\Throwable $th) {
				foreach ($data as $v) {
					$create[] = array(
						'employee_id' => $request->employee_id,
						'allowance_id' => $v->allowance_id
					);
				}
				EmployeeHasAllowance::insert($create);

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
				true,
				"Employee's allowance has been updated"
			),
			201
		);
	}
}
