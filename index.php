<?php
require_once "conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>User List</h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="add.php" class="btn btn-outline-info">Add User</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Profile</th>
                                    <th>Action</th>
                                </thead>
                                <tbody class="user-listing">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        getListing();

        function getListing() {
            $.ajax({
                url: 'index_ajax.php',
                type: 'GET',
                data: {
                    'type': 'list'
                },
                success: function(data) {
                    try {
                        data = JSON.parse(data);
                    } catch (e) {}
                    if (data.status == 1) {
                        var html = '';
                        $.each(data.data, function(key, val) {
                            html += "<tr>";
                            html += "<td>" + val.id + "</td>";
                            html += "<td>" + val.first_name + "</td>";
                            html += "<td>" + val.last_name + "</td>";
                            html += "<td>" + val.email + "</td>";
                            html += "<td>" + val.gender + "</td>";
                            html += "<td style='width:10%;'><img class='w-75' src='profile-img/" + val.file_name + "'></td>";
                            html += "<td> <a href='edit.php?id=" + val.id + "' class='btn btn-outline-success'>Edit</a> <a href='javascript:void(0)' class='btn btn-outline-danger btn_delete' data-id='" + val.id + "'>Delete</a> </td>";
                            html += "</tr>";
                        });
                        $(".user-listing").html();
                        $(".user-listing").html(html);
                    } else {
                        html += "<tr>"
                        html += "<td colspan='3' class='text-secondary'> No Data Found...! </td>"
                        html += "</tr>"
                        $(".user-listing").html();
                        $(".user-listing").html(html);
                    }
                }
            });
        }

        $(document).on("click", ".btn_delete", function() {
            var id = $(this).attr('data-id');
            console.log(id);
            
            if (id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't to Delete this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'delete_ajax.php',
                            type: 'POST',
                            data: {
                                'id':id
                            },
                            success: function(data) {
                                try {
                                    data = JSON.parse(data);
                                } catch (e) {}

                                if (data.status == 1) {
                                    toastr.success(data.msg, 'Success');
                                    setTimeout(() => {
                                        location = 'index.php';
                                    },1000);
                                } else {
                                    toastr.error(data.msg, 'Error');
                                }
                            }
                        });
                    }
                });
            }
        });
    });
</script>