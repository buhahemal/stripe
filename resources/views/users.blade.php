<!DOCTYPE html>
<html>

<head>
    <title>Stripe IN</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        .imglist {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="container" style="padding-top: 2%;">
        <div class="row">
        <div class="col-md-3  offset-md-9">
        <button type="button" class="btn btn-primary" id="addEmployeeModalOpen">
            Add Employee
        </button>
    </div>
        
        </div>
        <h2 class="mb-4">Employee List</h2>
        <br>
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



    <!-- Add Employee Modal -->
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
                                        <input type="text" required maxlength="255" name="firstName" class="form-control" id="firstName" aria-describedby="firstNameHelp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputLastName" class="form-label">Last Name</label>
                                        <input type="text" required maxlength="255" name="lastName" class="form-control" id="lastName" aria-describedby="lastNameHelp">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <input type="email" required name="email" maxlength="255" class="form-control" id="email" aria-describedby="emailHelp">
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputDOB" class="form-label">Date of Birth</label>
                                        <input type="date" required name="dateofbirth" class="form-control" id="DOB" aria-describedby="DOBHelp">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputCurrentAddress" class="form-label">Current Address</label>
                                        <input type="text" required name="currentaddress" class="form-control" id="currentAddress" aria-describedby="currentaddressHelp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputPermenentAddress" class="form-label">Permenent Address</label>
                                        <input type="text" required name="permenentaddress" class="form-control" id="permenetAddress" aria-describedby="permenentaddressHelp">
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
                                        <label for="profileImage" class="form-label">Image</label>
                                        <input accept="image/jpg, image/png" type="file" required name='profileimg'  onchange="document.getElementById('profileImgPreview').src = window.URL.createObjectURL(this.files[0])" class="form-control" id="profileimage" aria-describedby="profileImageHelp">
                                        <img id="profileImgPreview" alt="Preview Image" width="100%"/>
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


    <!-- Edit Employee Modal -->
    <div class="modal fade" id="EditEmployeeModal" tabindex="-1" aria-labelledby="EditEmployeeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showEmployeeTitle">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="EditEmployee">
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="EinputFirstName" class="form-label">First Name</label>
                                        <input type="text" required maxlength="255" name="firstName" class="form-control" id="EfirstName" aria-describedby="firstNameHelp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="EinputLastName" class="form-label">Last Name</label>
                                        <input type="text" required maxlength="255" name="lastName" class="form-control" id="ElastName" aria-describedby="lastNameHelp">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="EinputEmail" class="form-label">Email</label>
                                    <input type="email" required maxlength="255" name="email" class="form-control" id="Eemail" aria-describedby="emailHelp">
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="EinputDOB" class="form-label">Date of Birth</label>
                                        <input type="date" required name="dateofbirth" class="form-control" id="EDOB" aria-describedby="DOBHelp">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="EinputCurrentAddress" class="form-label">Current Address</label>
                                        <input type="text" required name="currentaddress" class="form-control" id="EcurrentAddress" aria-describedby="currentaddressHelp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputPermenentAddress" class="form-label">Permenent Address</label>
                                        <input type="text" required name="permenentaddress" class="form-control" id="EpermenetAddress" aria-describedby="permenentaddressHelp">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="EinputCurrentAddress" class="form-label">Role</label>
                                        @foreach($roles as $key => $role)
                                        <div class="form-check">
                                            <input class="form-check-input" id="Eroles" name="Eroles[]" type="checkbox" value="{{ $key }}">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $role }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="profileImage" class="form-label">Image</label>
                                        <input type="file" accept="image/jpg, image/png" onchange="document.getElementById('Eprofileview').src = window.URL.createObjectURL(this.files[0])" name='profileimg' class="form-control" id="Eprofileimg" aria-describedby="ProfileImgHelp">
                                        <img id="Eprofileview" style="width:100%" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="Eform-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var EmployeeId = null;
    var table = null;
    let yesterdayDate = new Date(new Date().setDate(new Date().getDate() - 1)),
        maxDate = yesterdayDate.toISOString().substring(0, 10);
    $('#DOB').prop('max', maxDate);
    $('#EDOB').prop('max', maxDate);

    function sweet(msg) {
        swal("Good job!", msg, "success");
    }

    function oopsWentWrong(msg) {
        swal("Oops", msg, "error")
    }
    $("#addEmployeeModalOpen").click(function() {
        $('#createEmployee').trigger("reset");
        $("#addEmployee").modal("show");
    });
    $('#createEmployee').on('submit', function(e) {
        e.preventDefault();
        $('#form-errors').html('');
        let formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: 'user',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                sweet(response.message);
                table.ajax.reload();
                $("#addEmployee").modal("hide");
            },
            error: function(error) {
                if (error.status === 422) {
                    let errors = error.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors['errors'], function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></di>';
                    $('#form-errors').html(errorsHtml);
                } else {
                    oopsWentWrong(error.message);
                }
            }
        });
    });

    $('#EditEmployee').on('submit', function(e) {
        e.preventDefault();
        $('#Eform-errors').html('');
        let formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: 'user/' + EmployeeId,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                EmployeeId = null;
                sweet(response.message);
                table.ajax.reload(null, false);
                $("#EditEmployeeModal").modal("hide");
            },
            error: function(error) {
                if (error.status === 422) {
                    let errors = error.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors['errors'], function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></di>';
                    $('#Eform-errors').html(errorsHtml);
                } else {
                    oopsWentWrong(error.message);
                }
            }
        });
    });
    $(document).on('click', '.edit', function(event) {
        EmployeeId = event.target.id;
        if (!!EmployeeId) {
            $.ajax({
                type: "GET",
                url: 'user/' + EmployeeId + '/edit',
                success: function(response) {
                    let user = response.user;
                    $('#EditEmployee').trigger("reset");
                    $("#EfirstName").val(user.firstname);
                    $("#ElastName").val(user.lastname);
                    $("#Eemail").val(user.email);
                    $("#EDOB").val(timeConverter(user.birthdate));
                    $("#EcurrentAddress").val(user.currentaddress);
                    $("#EpermenetAddress").val(user.permenentaddress);
                    $.each(user.roles, function(i, role) {
                        $("input[id='Eroles'][value='" + role.roleid + "']").prop('checked', true);
                    });
                    $("#Eprofileview").attr("src", user.profileimg);
                    $("#Eprofileview").attr("alt", user.firstname);
                    $('#EditEmployeeModal').modal('show');
                },
                error: function(error) {
                    oopsWentWrong(error.message);
                }
            });
        } else {
            oopsWentWrong("Please Refresh Your Page");
        }
    });

    $(document).on('click', '.delete', function(event) {
        EmployeeId = event.target.id;
        swal({
                title: "Are You Sure?",
                text: "You will Be Not Able To Retrieve This Employee Details.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No, Cancel Please!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "delete",
                        url: 'user/' + EmployeeId,
                        success: function(response) {
                            EmployeeId = null;
                            sweet(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function(error) {
                            EmployeeId = null;
                            oopsWentWrong(error.responseJSON.message);
                        }
                    });
                } else {
                    swal("Cancelled", "Employee Details is Safe:)", "error");
                }
            });
    });


    function timeConverter(UNIX_timestamp) {
        let a = new Date(UNIX_timestamp * 1000);
        let year = a.getFullYear();
        let month = (a.getMonth() + 1).toString().padStart(2, "0");
        let date = a.getDate().toString().padStart(2, "0");
        let time = year + '-' + month + '-' + date;
        return time;
    }
    $(function() {
        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            stateSave: true,
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
                        return '<img class="imglist" loading="lazy" src="' + data + '" />';
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