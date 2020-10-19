@extends('admin.master')
@section('content')
    <h2 style="margin-top: 12px;text-align:center" class="alert alert-success" >Brand Crud
    </h2><br>
    <div class="row">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-brand" onclick="addBrand()">Add Brand</a>
        </div>
    </div>
    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12">
            <table id="laravel_crud" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($brands as $brand)
                    <tr id="row_{{$brand->id}}">
                        <td>{{ $brand->id  }}</td>
                        <td>{{ $brand->brand_name }}</td>
                        <td>{{ $brand->brand_description }}</td>
                        <td><img src="{{ $brand->brand_image }}" width="60px" height="60px" style="" class="img-thumbnail"></td>
                        <td>{{ $brand->publication_status }}</td>
                        <td>
                            <a href="javascript:void(0)" data-id="{{ $brand->id }}" onclick="editBrand(event.target)" class="btn btn-info">Edit</a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" data-id="{{ $brand->id }}" onclick="deleteBrand(event.target)"  class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="brand-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form name="brandForm" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="brand_id" id="brand_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Brand Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Enter Brand Name">
                                <span class="text-danger">
                              {{ $errors->has('brand_name') ? $errors->first('brand_name') : ' ' }}
                        </span>
                                <span id="nameError" class="alert-message"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Brand Description</label>
                            <div class="col-sm-12">
                        <textarea class="form-control" id="brand_description" name="brand_description" rows="4" cols="50">
                        </textarea>
                                <span class="text-danger">
                              {{ $errors->has('brand_description') ? $errors->first('brand_description') : ' ' }}
                        </span>
                                <span id="descriptionError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Select Brand Logo : </label>
                            <div class="col-md-8">
                                <input type="file" name="brand_image" id="brand_image" class="form-control" />
                                <span class="text-danger">
                              {{ $errors->has('brand_image') ? $errors->first('brand_image') : ' ' }}

                        </span>
                                <span id="imageError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Publication Status</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="publication_status" name="publication_status" placeholder="Enter Publication Status">
                                <span class="text-danger">
                              {{ $errors->has('publication_status') ? $errors->first('publication_status') : ' ' }}
                        </span>
                                <span id="statusError" class="alert-message"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="createBrand()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#laravel_crud').DataTable();

        function addBrand() {
            $("#brand_id").val('');
            $('#brand-modal').modal('show');
        }

        function editBrand(event) {
            var id  = $(event).data("id");
            let _url = `/brands/${id}`;
            $('#nameError').text('');
            $('#descriptionError').text('');
            $('#imageError').text('');
            $('#statusError').text('');

            $.ajax({
                url: _url,
                type: "GET",
                success: function(response) {
                    if(response) {
                        $("#brand_id").val(response.id);
                        $("#brand_name").val(response.brand_name);
                        $("#brand_description").val(response.brand_description);
                        $("#brand_image").val(response.brand_image);
                        $("#publication_status").val(response.publication_status);
                        $('#brand-modal').modal('show');
                    }
                }
            });
        }

        function createBrand() {
            var brand_name = $('#brand_name').val();
            var brand_description = $('#brand_description').val();
            var brand_image = $('#brand_image').val();
            var publication_status = $('#publication_status').val();
            var id = $('#brand_id').val();

            let _url     = `/brands`;
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    id: id,
                    brand_name: brand_name,
                    brand_description: brand_description,
                    brand_image: brand_image,
                    publication_status: publication_status,
                    _token: _token
                },
                success: function(response) {
                    if(response.code == 200) {
                        if(id != ""){
                            $("#row_"+id+" td:nth-child(2)").html(response.data.brand_name);
                            $("#row_"+id+" td:nth-child(3)").html(response.data.brand_description);
                            $("#row_"+id+" td:nth-child(4)").html(response.data.brand_image);
                            $("#row_"+id+" td:nth-child(5)").html(response.data.publication_status);
                        } else {
                            $('table tbody').prepend('<tr id="row_'+response.data.id+'">' +
                                '<td>'+response.data.id+'</td>' +
                                '<td>'+response.data.brand_name+'</td>' +
                                '<td>'+response.data.brand_description+'</td>' +
                                '<td>'+response.data.brand_image+'</td>' +
                                '<td>'+response.data.publication_status+'</td>' +
                                '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editBrand(event.target)" class="btn btn-info">Edit</a></td>' +
                                '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="deleteBrand(event.target)" class="btn btn-danger">Delete</a></td>' +
                                '</tr>');
                        }
                        $('#brand_name').val('');
                        $('#brand_description').val('');
                        $('#brand_image').val('');
                        $('#publication_status').val('');
                        $('#brand-modal').modal('hide');
                    }
                },
                errors: function(response) {
                    $('#nameError').text(response.responseJSON.errors.brand_name);
                    $('#descriptionError').text(response.responseJSON.errors.brand_description);
                    $('#imageError').text(response.responseJSON.errors.brand_image);
                    $('#statusError').text(response.responseJSON.errors.publication_status);
                }
            });
        }

        function deleteBrand(event) {
            var id  = $(event).data("id");
            let _url = `/brands/${id}`;
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: 'DELETE',
                data: {
                    _token: _token
                },
                success: function(response) {
                    $("#row_"+id).remove();
                },
                error: function (response) {
                    $("#row_"+id).text('Data is not Deleted')
                }
            });
        }

    </script>
@endsection
