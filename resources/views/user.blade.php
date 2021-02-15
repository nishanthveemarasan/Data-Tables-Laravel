<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <title>Document</title>
</head>

<body class="bg-light">


    <br>
    <div class="container ">

        <br>
        <br>
        <div class="row bg-light">
            <div class="col-3">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" class="form-control mb-3">
            </div>
            <div class="col-3">
                <label for="firstName">Last Name</label>
                <input type="text" id="lastName" class="form-control mb-3">
            </div>
        </div>
        <br><br>
        <div class="row m-0" style="background-color: lightgray">
            <div class="col-2">
                <div class="input-group input-group-sm m-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">ID</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group input-group-sm m-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Product</span>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                        <option value="1" selected>All</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group input-group-sm m-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Status</span>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                        <option value="1" selected>All</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group input-group-sm m-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Varient</span>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                        <option value="1" selected>All</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </div>
        <br><br>
        <table id="myTable" class="table">
            <thead class="thead-light">
                <th>Id</th>
                <th>Product</th>
                <th>Status</th>
                <th>Varient</th>
                <th>SKU</th>
            </thead>
        </table>
    </div>

</body>
<script>
    $(document).ready(function() {

        $('#firstName').on('keyup', function() {
            let fname = $(this).val();
            let lname = $('#lastName').val();
            getTable(fname, lname);
        })
        $('#lastName').on('keyup', function() {
            let fname = $('#firstName').val();
            let lname = $(this).val();
            getTable(fname, lname);
        })
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
                // "{{ route('table', ['fname' => 'fname']) }}",
                columns: [

                    {
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
                        // orderable: false,
                        // searchable: false
                    },

                ]
            });
        }

    });

</script>

</html>
