<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\APIResponse;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
	public function index()
	{
		try {
			return response()->json(
				new APIResponse(
					true,
					"Registered employees",
					Employee::with(['contracts' => function ($query) {
						$query->active();
					}, 'allowances.allowance'])->latest()->get()
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
			$data = Employee::with(['contracts' => function ($query) {
				$query->active();
			}, 'allowances.allowance'])->find($id);

			if ($data) {
				return response()->json(
					new APIResponse(
						true,
						"Employee data",
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

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'name' => ['required', 'string'],
				'pob' => ['required', 'string'],
				'dob' => ['required', 'date_format:Y-m-d'],
				'gender' => ['required', 'in:male,female'],
				'contact' => ['required', 'string'],
				'email' => ['required', 'string'],
				'address' => ['nullable', 'string'],
			],
			[
				'name.required' => 'name is required',
				'pob.required' => 'pob is required',
				'dob.required' => 'dob is required',
				'dob.date_format' => 'Please fill dob with Y-m-d date format',
				'gender.required' => 'gender is required',
				'gender.in' => 'Gender value is not allowed',
				'contact.required' => 'contact is required',
				'email.required' => 'email is required',
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
			Employee::create($request->all());
			return response()->json(
				new APIResponse(
					true,
					"The request was fulfilled, employee data has been stored",
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
				'name' => ['required', 'string'],
				'pob' => ['required', 'string'],
				'dob' => ['required', 'date_format:Y-m-d'],
				'gender' => ['required', 'in:male,female'],
				'contact' => ['required', 'string'],
				'email' => ['required', 'string'],
				'address' => ['nullable', 'string'],
			],
			[
				'name.required' => 'name is required',
				'pob.required' => 'pob is required',
				'dob.required' => 'dob is required',
				'dob.date_format' => 'Please fill dob with Y-m-d date format',
				'gender.required' => 'gender is required',
				'gender.in' => 'Gender value is not allowed',
				'contact.required' => 'contact is required',
				'email.required' => 'email is required',
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

		$data = Employee::findOrFail($id);

		try {
			$data->update($request->all());

			return response()->json(
				new APIResponse(
					true,
					"The request was fulfilled, employee data has been updated",
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
		$data = Employee::findOrFail($id);

		try {
			$data->delete();
			return response()->json(
				new APIResponse(
					true,
					"Employee data deleted",
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
