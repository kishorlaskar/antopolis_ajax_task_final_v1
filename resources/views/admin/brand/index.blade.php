@extends('admin.adminmaster')
@section('content')

    <div class="container">
        <h2 class="text-center text-success">Brand Crud</h2>
        <br>
        <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalAdd">Add Brand</a>
        <br>
        <br>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Brand Name</th>
                <th scope="col">Brand Description</th>
                <th scope="col">Image</th>
                <th scope="col">Publication Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody id="getdataTable">
            </tbody>
        </table>
    </div>

    <!-- Modal for Add New Brand -->
    <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalAddTitle">New Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmSave" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Brand Name</label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name">
                        </div>
                        <div class="form-group">
                            <label for="name">Brand Description</label>
                            <textarea type="text" class="form-control" id="brand_description" name="brand_description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="brand_image" name="brand_image">
                            <input type="hidden" name="old_image" id="old_image" value="">
                        </div>
                        <div class="form-group">
                            <label for="name">Publication Status</label>
                            <input type="text" class="form-control" id="publication_status" name="publication_status">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="frmAddClose">Close</button>
                    <input type="hidden" name="brand_id" id="brand_id" value="">
                    <input type="hidden" name="button_action" id="button_action" value="insert">
                    <button type="submit" class="btn btn-primary" id="action">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Brand -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEditLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalEditTitle">Edit Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmEdit" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Brand Name</label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name">
                        </div>
                        <div class="form-group">
                            <label for="name">Brand Description</label>
                            <textarea type="text" class="form-control" id="brand_description" name="brand_description" rows="4" cols="50"></textarea>
                        </div>


                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="brand_image" name="brand_image">
                            <input type="hidden" name="old_image" id="old_image" value="">
                            <input type="hidden" name="brand_id" id="brand_id" value="">
                        </div>
                        <div class="form-group">
                            <label for="name">Publication Status</label>
                            <input type="text" class="form-control" id="publication_status" name="publication_status">
                        </div>
                        <img src="" alt="" id="img_edit" width="40" height="40">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal" id="frmEditClose">Close</button>
                    <input type="hidden" name="button_action" id="button_action" value="insert">
                    <button type="submit" class="btn btn-primary" id="action">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javaScript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function getData() {
                $.ajax({
                    type: "get",
                    url: "{{route('brand.get')}}",
                    success: function (data) {
                        $('#getdataTable').html(data)
                    }
                });
            }
            getData();
            //  save data to database with ajax
            $('#frmSave').on('submit',function (e) {
                e.preventDefault();
                var request = new FormData(this);
                $.ajax({
                    type: "post",
                    url: "{{route('brand.store')}}",
                    data: request,
                    contentType:false,
                    cache:false,
                    processData:false,
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Your Data has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#frmSave')[0].reset();
                        $('#frmAddClose').click();
                        $('#brand_id').val(data.id);
                        $('#old_image').val(data.brand_image);
                        getData();
                    }
                });
            });

            //  show edit form for update
            $(document).on('click','.edit',function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $.get("{{route('brand.edit')}}", {id:id},
                    function (data) {
                        console.log(data);
                        $('#ModalEdit').modal('show');
                        $('#frmEdit').find('#brand_name').val(data.brand_name);
                        $('#frmEdit').find('#brand_description').val(data.brand_description);
                        $('#frmEdit').find('#old_image').val(data.brand_image);
                        $('#frmEdit').find('#publication_status').val(data.publication_status);
                        $('#frmEdit').find('#brand_id').val(data.id);
                        $('#frmEdit').find('#img_edit').attr('src','{{asset("upload/brand")}}/'+data.brand_image);
                    }
                );
            });

            //update data to database
            $('#frmEdit').on('submit',function(e){
                e.preventDefault();
                var request = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{route('brand.update')}}",
                    data: request,
                    contentType: false,
                    cache:false,
                    processData:false,
                    success: function (data) {
                        $('#frmEdit').trigger('reset');
                        $('#frmEditClose').click();
                        getData();
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Your Data has been updated Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
            });

            // delete data from database
            $(document).on('click','.delete',function(e){
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "{{route('brand.destroy')}}",
                            data: {id:id},
                            dataType: "JSON",
                            success: function (data) {
                                getData();
                            }
                        });
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Your Data has been deleted',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })

            });
        });
    </script>
@endsection
