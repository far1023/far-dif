<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use Illuminate\Http\Request;
use App\Http\Resources\APIResponse;
use Illuminate\Support\Facades\Validator;

class AllowanceController extends Controller
{
	public function index()
	{
		try {
			return response()->json(
				new APIResponse(
					true,
					"Registered allowances",
					Allowance::get()
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
			if ($data = Allowance::find($id)) {
				return response()->json(
					new APIResponse(
						true,
						"Allowance found",
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
				'name' => ['required', 'unique:allowances,name,'],
				'percentage_on_basic' => ['required_if:fix_amount,null', 'nullable', 'integer'],
				'fix_amount' => ['required_if:percentage_on_basic,null', 'nullable', 'integer'],
			],
			[
				'name.required' => 'name is required',
				'name.unique' => 'Allowance name already registered in system',
				'percentage_on_basic.integer' => 'Please fill only with number',
				'percentage_on_basic.required_if' => 'Choose and fill one',
				'fix_amount.integer' => 'Please fill only with number',
				'fix_amount.required_if' => 'Choose and fill one',
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
			Allowance::create($request->all());
			return response()->json(
				new APIResponse(
					true,
					"The request was fulfilled, allowance data has been stored",
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
				'name' => ['required', 'unique:allowances,name,' . $id],
				'percentage_on_basic' => ['required_if:fix_amount,null', 'nullable', 'integer'],
				'fix_amount' => ['required_if:percentage_on_basic,null', 'nullable', 'integer'],
			],
			[
				'name.required' => 'name is required',
				'name.unique' => 'Allowance name already registered in system',
				'percentage_on_basic.integer' => 'Please fill only with number',
				'percentage_on_basic.required_if' => 'Choose and fill one',
				'fix_amount.integer' => 'Please fill only with number',
				'fix_amount.required_if' => 'Choose and fill one',
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

		$data = Allowance::findOrFail($id);

		try {
			$data->update($request->all());
			return response()->json(
				new APIResponse(
					true,
					"The request was fulfilled, allowance data has been updated",
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
		$data = Allowance::findOrFail($id);

		try {
			$data->delete();
			return response()->json(
				new APIResponse(
					true,
					"Allowance data deleted",
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
