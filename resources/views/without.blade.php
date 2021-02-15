<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <title>Document</title>
</head>

<body>

    <div class="row">
        <div class="col-3">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" class="form-control w-25">
        </div>
        <div class="col-3">
            <label for="firstName">Last Name</label>
            <input type="text" id="lastName" class="form-control w-25">
        </div>
    </div>
    <br>
    {{-- <div class="container">
        <table id="myTable" class="table">
            <thead class="thead-light">
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
            </thead>

        </table>
    </div> --}}

</body>
<script>
    $(document).ready(function() {
        $('#firstName').on('keyup', function() {
            let fname = $(this).val();
            getTable(fname);
        })
        const fname = 'MARY';
        getTable('');

        function getTable($fname) {
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
                    'url': "{{ url('/userTable') }}",
                    'type': 'GET',
                    'data': function(d) {
                        d.fname = $fname;
                    }

                },
                // "{{ route('table', ['fname' => 'fname']) }}",
                columns: [{
                        data: 'customer_id',
                        name: 'customer_id'
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },

                ]
            });
        }

    });

</script>

</html>
