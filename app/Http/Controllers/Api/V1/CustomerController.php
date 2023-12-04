<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\Customer;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use Illuminate\Http\Request;
use App\Filters\V1\CustomerFilter;

use App\Models\Invoice;
use Illuminate\Support\Arr;


// use App\Http\Resources\V1\CustomerResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new CustomerFilter();
        $queryItems = $filter->transform($request);
        $customerQuery = Customer::Where($queryItems);
        $includeInvoices = $request->query('includesInvoices');

        if ($includeInvoices) {
            $customerQuery = $customerQuery->with('invoice');
        }

        return new  CustomerCollection($customerQuery->paginate()->appends($request->query()));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    // bulk storage of data

    public function bulkStore(BulkStoreInvoiceRequest $request)
    {

        $bulk = collect($request->all())->map(function ($arr, $key) {
            return  Arr::except($arr, ['billedDate', 'paidDate', 'customerId']);
        });

        Invoice::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includesInvoices');


        if ($includeInvoices) {
            return new CustomerResource($customer->loadMissing('invoice'));
        }

        return new CustomerResource($customer);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
