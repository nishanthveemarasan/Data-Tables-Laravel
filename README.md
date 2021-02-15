<h2 style="align-center"> Yajra Datatables</h3>
<br>
<br>

<h3 style="color:red;">Installation</h3>
<hr>
<div>
    <p> composer require yajra/laravel-datatables:^1.5</p>
    <h4>Configuration</h4>
    <p>In App.php</p>
        'providers' => [
    // ...
    Yajra\DataTables\DataTablesServiceProvider::class,
],
    <br>
    'aliases' => [
        'DataTables' => Yajra\DataTables\Facades\DataTables::class,
    ],
    <br>
    <h4>publish configuration & assets:</h4>
    <p>php artisan vendor:publish --tag=datatables</p>
</div>
<br>
<h2>Usage</h2>
 <p>Our Idea is to add extra colums and edit existing columns and styling them</p> 
 <p>Also we will do custom filtering of first_name and Last_name</p>
  
<h4>In View FIle</h4><small>We will be doing following things</small>
<p>
    We need to add <b>jquery cdn</b> and <b>jquery dataTables CDN</p> and bootstrap CDN(optional if we are going to
style them)
</p>
<h5>BootstrapCDN</h5>
<hr>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>
<hr>
<br>
<h5>Jquery DataTablesCDN</h5>
<hr>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<hr>
<br>
<h5>Jquery CDN</h5>
<hr>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<hr>
<br>
<table id="myTable" class="table">
    <thead class="thead-light">
        <th>Id</th>
        <th>Product</th>
        <th>Status</th>
        <th>Varient</th>
        <th>SKU</th>
    </thead>
</table>

<p>In table we just have to configure with ID and the table head</p>
<br>
<h5>In Script File</h5>
<script>
    $(document).ready(function() {
        //when we type first name, we will pass it to the method along with last name
        $('#firstName').on('keyup', function() {
            let fname = $(this).val();
            let lname = $('#lastName').val();
            getTable(fname, lname);
        })
        //when we type last name, we will pass it to the method along with first name
        $('#lastName').on('keyup', function() {
            let fname = $('#firstName').val();
            let lname = $(this).val();
            getTable(fname, lname);
        })
        //this function will execute by default when the page loads
        //since we are filtering first name and the last name, we will send empty string for both first name and the last name
        getTable('', '');

        function getTable($fname, $lname) {
            $("#myTable").dataTable().fnDestroy();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    'url': "{{ url('/user') }}",
                    'type': 'GET',
                    'data': function(d) {
                        d.fname = $fname;
                        d.lname = $lname;
                    }

                },
                columns: [{
                        data: 'customer_id',
                        name: 'customer_id'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'permissions',
                        name: 'permissions',
                    },
                ]
            });
        }
    });

</script>
<hr>
<br>
<h4>In Controller file</h4>
<p>use Yajra\DataTables\DataTables;</p>
<br>
<br>
<?php
public function getCustomer($fname = "")
    {
        //get the first name if exists
        $fname = (!empty($_GET["fname"])) ? ($_GET["fname"]) : '';
        //get the last name if exist
        $lname = (!empty($_GET["lname"])) ? ($_GET["lname"]) : '';

        //if both are empty, we will just get all the results
        if (empty($fname) and empty($lname)) {
            $customer = Customer::all();
            //else we will filter
        } elseif (!empty($fname) or !empty($lname)) {
            $customer = Customer::where('first_name', 'like', '%' . $fname . '%')
                ->where('last_name', 'like', '%' . $lname . '%')
                ->get();
        }

        
        return DataTables::of($customer)
            //add a extra column
            ->addColumn('permissions', function (Customer $role) {
                return '<div class="badge badge-info">fsdfsdf</div>';
            })
            ->addColumn('actions', function ($customer) {
                return  '<a class="btn btn-default text-primary" href="users/' . $customer->customer_id . '">' . $customer->first_name .
                    '</a>';
            })
            //edit exisiting colums
            ->editColumn('first_name', function ($customer) {
                return '<div class="badge alert-info p-2 text-primary text-center">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="display:inline-block;vertical-align:text-bottom"><path fill-rule="evenodd" d="M13.78 4.22a.75.75 0 010 1.06l-7.25 7.25a.75.75 0 01-1.06 0L2.22 9.28a.75.75 0 011.06-1.06L6 10.94l6.72-6.72a.75.75 0 011.06 0z"></path></svg>
                Active</div>';
            })
            //we have to inclucde all the columns which we were added or editted 
            //then only html style will work
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

