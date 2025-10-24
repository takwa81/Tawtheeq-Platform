<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use App\Traits\FiltersListTrait;
use Illuminate\Http\Request;

class SubscriptionPackageController extends Controller
{
 use FiltersListTrait;

    public function index(Request $request)
    {
        try {
            $query = SubscriptionPackage::query();

            $query = $this->applyNameFilterAndSorting($request, $query);

            $packages  = $query->paginate(PaginationEnum::DefaultCount->value)->appends($request->all());

            return view('dashboard.subscription_packages.index', compact('packages'));
        } catch (\Throwable $e) {

            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    // public function show(Request $request, $id)
    // {
    //     try {
    //         $company = SubscriptionPackage::findOrFail($id);


    //         return view('dashboard.subscription_packages.show', compact('company'));
    //     } catch (\Throwable $e) {

    //         toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
    //         return redirect()->back();
    //     }
    // }


    // public function store(CompanyRequest $request)
    // {
    //     try {
    //         $data = $request->validated();

    //         if ($request->hasFile('logo')) {
    //             $imagePath = $this->storeImage($request->file('logo'), 'companies');
    //         }
    //         $data['logo'] = $imagePath;

    //         $company = Company::create($data);

    //         return response()->json([
    //             'message' => __('messages.added_successfully'),
    //             'data' => $company,
    //             'logo_url' => $company->logo_url

    //         ], 200);
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => __('messages.add_failed') . ': ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function update(CompanyRequest $request,  $company)
    // {
    //     try {
    //         $company = Company::findOrFail($company);
    //         $data = $request->validated();
    //         if ($request->hasFile('logo')) {
    //             $imagePath = $this->updateImage(
    //                 $request->file('logo'),
    //                 $company->logo,
    //                 'companies'
    //             );

    //             $data['logo'] = $imagePath;
    //         }
    //         $company->update($data);

    //         return response()->json([
    //             'message'   => __('messages.updated_successfully'),
    //             'data' => $company,
    //             'logo_url' => $company->logo_url
    //         ], 200);
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => __('messages.update_failed') . ': ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }
}
