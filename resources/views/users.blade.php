<!DOCTYPE html>
<html>

<head>
    <title>Stripe IN</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        img {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 150px;
        }

        img:hover {
            box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
        }
    </style>
</head>

<body>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" id="addEmployeeModalOpen">
        Add Employee
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="addEmployeeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeTitle">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createEmployee">
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputFirstName" class="form-label">First Name</label>
                                        <input type="text" name="firstName" value="hemal" class="form-control" id="firstName" aria-describedby="firstNameHelp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputLastName" class="form-label">Last Name</label>
                                        <input type="text" name="lastName" value="Buha" class="form-control" id="lastName" aria-describedby="lastNameHelp">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="buhahemal10@gmail.com" id="email" aria-describedby="emailHelp">
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputDOB" class="form-label">Date of Birth</label>
                                        <input type="date" name="dateofbirth" class="form-control" id="DOB" aria-describedby="DOBHelp">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputCurrentAddress" class="form-label">Current Address</label>
                                        <input type="text" name="currentaddress" class="form-control" id="currentAddress" value="Bjjhj" aria-describedby="currentaddressHelp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputPermenentAddress" class="form-label">Permenent Address</label>
                                        <input type="text" name="permenentaddress" class="form-control" id="permenetAddress" value="Bjjhj" aria-describedby="permenentaddressHelp">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputCurrentAddress" class="form-label">Role</label>
                                        @foreach($roles as $key => $role)
                                        <div class="form-check">
                                            <input class="form-check-input" name="roles[]" type="checkbox" value="{{ $key }}">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $role }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputPermenentAddress" class="form-label">Image</label>
                                        <input type="file" name='profileimg' class="form-control" id="permenetAddress" aria-describedby="permenentaddressHelp">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="form-errors"></div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class="mb-4">Employee List</h2>
        <table class="table table-striped table-bordered wrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Profile</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>DOB</th>
                    <th>CurrentAddress</th>
                    <th>PermenentAddress</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $("#addEmployeeModalOpen").click(function () {
        $('#createEmployee').trigger("reset");  
        $("#addEmployee").modal("show");
    });
    $('#createEmployee').on('submit', function(e) {
        e.preventDefault();
        $('#form-errors').html('');
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: 'user',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                if (error.status === 422) {
                    $errors = error.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each($errors['errors'], function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></di>';
                    $('#form-errors').html(errorsHtml);
                } else {
                    alert("Oops Something Went Wrong");
                }
            }
        });
    });

    function timeConverter(UNIX_timestamp) {
        let a = new Date(UNIX_timestamp * 1000);
        let year = a.getFullYear();
        let month = months[a.getMonth()];
        let date = a.getDate();
        let hour = a.getHours();
        let min = a.getMinutes();
        let sec = a.getSeconds();
        let time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;
        return time;
    }
    $(function() {

        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            pagingType: "full_numbers",
            ajax: "{{ route('users.list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'profileimg',
                    name: 'profileimg',
                    render: function(data, type, row) {
                        return '<img src="' + data + '" />';
                    }
                },
                {
                    data: 'firstname',
                    name: 'firstname'
                },
                {
                    data: 'lastname',
                    name: 'lastname'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'birthdate',
                    name: 'birthdate',
                    render: function(data, type, row) {
                        return timeConverter(data);
                    }
                },
                {
                    data: 'currentaddress',
                    name: 'currentaddress'
                },
                {
                    data: 'permenentaddress',
                    name: 'permenentaddress'
                },
                {
                    data: 'roles',
                    name: 'roles',
                    render: function(data, type, row) {
                        let tempString = '';
                        data.forEach(function(role) {
                            tempString += role['rolename'] + ', ';
                        });
                        return tempString;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>

</html>