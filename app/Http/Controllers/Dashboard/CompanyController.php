<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CompanyRequest;
use App\Models\Company;
use App\Traits\FiltersListTrait;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use FiltersListTrait, ImageHandler;

    public function index(Request $request)
    {
        try {
            $query = Company::query();

            $query = $this->applyNameFilterAndSorting($request, $query);

            $companies = $query->paginate(PaginationEnum::DefaultCount->value)->appends($request->all());

            return view('dashboard.companies.index', compact('companies'));
        } catch (\Throwable $e) {

            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $company = Company::findOrFail($id);


            return view('dashboard.companies.show', compact('company'));
        } catch (\Throwable $e) {

            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }


    public function store(CompanyRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $imagePath = $this->storeImage($request->file('logo'), 'companies');
            }
            $data['logo'] = $imagePath;

            $company = Company::create($data);

            return response()->json([
                'message' => __('messages.added_successfully'),
                'data' => $company,
                'logo_url' => $company->logo_url

            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => __('messages.add_failed') . ': ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(CompanyRequest $request,  $company)
    {
        try {
            $company = Company::findOrFail($company);
            $data = $request->validated();
            if ($request->hasFile('logo')) {
                $imagePath = $this->updateImage(
                    $request->file('logo'),
                    $company->logo,
                    'companies'
                );

                $data['logo'] = $imagePath;
            }
            $company->update($data);

            return response()->json([
                'message'   => __('messages.updated_successfully'),
                'data' => $company,
                'logo_url' => $company->logo_url
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => __('messages.update_failed') . ': ' . $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $type = Company::findOrFail($id);
            $type->delete();

            return response()->json([
                'status'  => true,
                'message' => __('messages.deleted_successfully'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => __('messages.delete_failed') . ': ' . $e->getMessage(),
            ], 500);
        }
    }
}