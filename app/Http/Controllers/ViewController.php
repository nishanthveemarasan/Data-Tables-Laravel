<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ViewController extends Controller
{
    public function getCustomer($fname = "")
    {
        $fname = (!empty($_GET["fname"])) ? ($_GET["fname"]) : '';
        $lname = (!empty($_GET["lname"])) ? ($_GET["lname"]) : '';

        if (empty($fname) and empty($lname)) {
            $customer = Customer::all();
        } elseif (!empty($fname) or !empty($lname)) {
            $customer = Customer::where('first_name', 'like', '%' . $fname . '%')
                ->where('last_name', 'like', '%' . $lname . '%')
                ->get();
        }

        //return view('user')->with('customers', $customer);
        return DataTables::of($customer)
            ->addColumn('permissions', function (Customer $role) {
                return '<div class="badge badge-info">fsdfsdf</div>';
            })
            ->addColumn('actions', function ($customer) {
                return  '<a class="btn btn-default text-primary" href="users/' . $customer->customer_id . '">' . $customer->first_name .
                    '</a>';
            })
            ->editColumn('first_name', function ($customer) {
                return '<div class="badge alert-info p-2 text-primary text-center">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="display:inline-block;vertical-align:text-bottom"><path fill-rule="evenodd" d="M13.78 4.22a.75.75 0 010 1.06l-7.25 7.25a.75.75 0 01-1.06 0L2.22 9.28a.75.75 0 011.06-1.06L6 10.94l6.72-6.72a.75.75 0 011.06 0z"></path></svg>
                Active</div>';
            })
            ->rawColumns(['permissions', 'actions', 'first_name'])

            ->make(true);

        /*
                return DataTables::of($customer)
            ->editColumn('first_name', function ($customer) {
                return '<span class="text-primary">' . $customer->first_name . '</span>';
            })
            ->addColumn('action', function ($customer) {
                return '<a href="#edit-' . $customer->customer_id . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })

            ->make(true);
             *
             * @return void
             */
    }

    public function getUSerId($id)
    {
        dd($id);
    }
}
