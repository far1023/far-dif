<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractHistory;
use App\Http\Resources\APIResponse;
use Illuminate\Support\Facades\Validator;

class ContractHistoryController extends Controller
{
	public function index()
	{
		try {
			return response()->json(
				new APIResponse(
					true,
					"Employee contracts",
					ContractHistory::with(['employee'])->latest()->get()
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
			if ($data = ContractHistory::with(['employee'])->find($id)) {
				return response()->json(
					new APIResponse(
						true,
						"Contract detail",
						$data
					),
					200
				);
			}

			return response()->json(
				new APIResponse(
					true,
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

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'contract_no' => ['required', 'unique:contract_histories,contract_no'],
				'employee_id' => ['required', 'exists:employees,id'],
				'position' => ['required'],
				'division' => ['required'],
				'start' => ['required', 'date_format:Y-m-d'],
				'end' => ['required', 'date_format:Y-m-d'],
				'basic_salary' => ['required', 'integer'],
			],
			[
				'contract_no.required' => 'contract_no is required',
				'contract_no.unique' => 'contract_no already registered in system',
				'employee_id.required' => 'employee_id is required',
				'employee_id.exists' => 'Employee data not found',
				'position.required' => 'position is required',
				'division.required' => 'division is required',
				'start.required' => 'start is required',
				'start.date_format' => 'Please fill start with date(Y-m-d)',
				'end.required' => 'end is required',
				'end.date_format' => 'Please fill end with date(Y-m-d)',
				'basic_salary.required' => 'basic_salary is required',
				'basic_salary.integer' => 'Please fill only with number',
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

		try {
			ContractHistory::create($request->all());
			return response()->json(
				new APIResponse(
					true,
					"The request was fulfilled, data has been stored",
					$request->all()
				),
				201
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

	public function update(Request $request, int $id)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'contract_no' => ['required', 'unique:contract_histories,contract_no,' . $id],
				'employee_id' => ['required', 'exists:employees,id'],
				'position' => ['required'],
				'division' => ['required'],
				'start' => ['required', 'date_format:Y-m-d'],
				'end' => ['required', 'date_format:Y-m-d'],
				'basic_salary' => ['required', 'integer'],
			],
			[
				'contract_no.required' => 'contract_no is required',
				'contract_no.unique' => 'contract_no already registered in system',
				'employee_id.required' => 'employee_id is required',
				'employee_id.exists' => 'Employee data not found',
				'position.required' => 'position is required',
				'division.required' => 'division is required',
				'start.required' => 'start is required',
				'start.date_format' => 'Please fill start with date(Y-m-d)',
				'end.required' => 'end is required',
				'end.date_format' => 'Please fill end with date(Y-m-d)',
				'basic_salary.required' => 'basic_salary is required',
				'basic_salary.integer' => 'Please fill only with number',
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

		$data = contractHistory::findOrFail($id);

		try {
			$data->update($request->all());
			return response()->json(
				new APIResponse(
					true,
					"The request was fulfilled, data has been updated",
					$request->all()
				),
				201
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

	public function destroy(int $id)
	{
		$data = ContractHistory::findOrFail($id);

		try {
			$data->delete();
			return response()->json(
				new APIResponse(
					true,
					"Employee contract deleted",
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
