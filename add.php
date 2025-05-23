<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-warning">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Add User</h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="index.php" class="btn btn-outline-primary">Back To List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="javascript:void(0)" method="POST" id="myform" enctype="multipart/form-data">
                            <div class="uploadIcon d-flex justify-content-center">
                                <img class="img-thumbnail imgUpload" src="./profile-img/balnk-avtar.jpg" alt="pic" height="200px"
                                    width="200px" style="border-radius: 50%;">
                            </div>
                            <input type="file" id="photo" required="true" style="display: none;" value="image" name="image">
                            <div class="form-group">
                                <label for="first_name">First name :<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter First name" name="first_name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last name :<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Last name" name="last_name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email :<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="Enter Email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password :<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" placeholder="Enter Password" name="password">
                            </div>
                            <div class="mt-2"><label for="gender">Gender <span class="text-danger">*</span></label></div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input gender" name="gender" value="male">Male
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input gender" name="gender" value="female">Female
                                </label>
                            </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-outline-warning">Reset</button>
                        <a href="javascript:void(0)" type="submit" class="btn btn-outline-success btn_submit">Submit</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $("#myform").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                email: {
                    required: true
                },
                password: {
                    required: true
                },
            },
            submitHandler: function(form) {
                // return true;
            }
        });

        $(".btn_submit").on("click", function() {
            var _this = $(this);
            if ($("#myform").valid()) {
                _this.prop("disabled", true).text("Proccessing....!");
                var formData = new FormData($('#myform')[0]);
                $.ajax({
                    url: 'add_ajax.php',
                    type: 'POST',
                    data: formData,
                    contentType : false,
                    processData : false,
                    success: function(data) {
                        _this.prop("disabled", false).html("submit");

                        try {
                            data = JSON.parse(data);
                        } catch (e) {}

                        if (data.status == 1) {
                            toastr.success(data.msg, 'Success');
                            setTimeout(() => {
                                location = 'index.php';
                            }, 1000);
                        } else {
                            toastr.error(data.msg, 'Error');
                        }
                    }
                });
            }
        });

        // file upload code
        $(".uploadIcon").click(function() {
            $("#photo").trigger('click');
        });
        $("#photo").change(function() {

            file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $(".imgUpload")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>