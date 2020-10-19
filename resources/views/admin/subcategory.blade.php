@extends('admin.master')
@section('content')
    <h2 style="margin-top: 12px;" class="alert alert-success">Subcategory Crud
    </h2><br>
    <div class="row">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-subcategory" onclick="addSubcategory()">Add SubCategory</a>
        </div>
    </div>
    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12">
            <table id="laravel_crud" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Subcategory Name</th>
                    <th>Subcategory Description</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subcategories as $subcategory)
                    <tr id="row_{{$subcategory->id}}">
                        <td>{{ $subcategory->id  }}</td>
                        <td>{{ $subcategory->category_name }}</td>
                        <td>{{ $subcategory->subcategory_name }}</td>
                        <td>{{ $subcategory->description }}</td>
                        <td>{{ $subcategory->publication_status }}</td>
                        <td>
                            <a href="javascript:void(0)" data-id="{{ $subcategory->id }}" onclick="editSubCategory(event.target)" class="btn btn-info">Edit</a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" data-id="{{ $subcategory->id }}" class="btn btn-danger" onclick="deleteSubCategory(event.target)">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="subcategory-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form name="subcategoryForm" class="form-horizontal">
                        <input type="hidden" name="subcategory_id" id="subcategory_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Category Name</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="category_id" id="category_id">
                                    @php
                                    $categories = DB::table('categories')->get();
                                    @endphp
                                    <option>---Select Category---</option>
                                    @foreach($categories as  $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                              {{ $errors->has('category_id') ? $errors->first('category_id') : ' ' }}
                        </span>
                                <span id="categoryError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">SubCategory Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" placeholder="Enter SubCategory Name">
                                <span class="text-danger">
                              {{ $errors->has('subcategory_name') ? $errors->first('subcategory_name') : ' ' }}
                        </span>
                                <span id="nameError" class="alert-message"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">SubCategory Description</label>
                            <div class="col-sm-12">
                        <textarea class="form-control" id="description" name="description" rows="4" cols="50">
                        </textarea>
                                <span class="text-danger">
                              {{ $errors->has('subcategory_description') ? $errors->first('subcategory_description') : ' ' }}
                        </span>
                                <span id="descriptionError" class="alert-message"></span>
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
                    <button type="button" class="btn btn-primary" onclick="createSubCategory()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#laravel_crud').DataTable();

        function addSubcategory() {
            $("#subcategory_id").val('');
            $('#subcategory-modal').modal('show');
        }

        function editSubCategory(event) {
            var id  = $(event).data("id");
            let _url = `/subcategory/${id}`;
            $('#categoryError').text('');
            $('#nameError').text('');
            $('#descriptionError').text('');
            $('#statusError').text('');

            $.ajax({
                url: _url,
                type: "GET",
                success: function(response)
                {
                    if(response) {
                        $("#subcategory_id").val(response.id);
                        $("#category_id").val(response.category_id);
                        $("#subcategory_name").val(response.subcategory_name);
                        $("#description").val(response.description);
                        $("#publication_status").val(response.publication_status);
                        $('#subcategory-modal ').modal('show');
                    }
                }
            });
        }

        function createSubCategory() {
            var category_id  = $('#category_id').val();
            var subcategory_name = $('#subcategory_name').val();
            var description = $('#description').val();
            var publication_status = $('#publication_status').val();
            var id = $('#subcategory_id').val();

            let _url     = `/subcategory`;
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    id: id,
                    category_id:category_id,
                    subcategory_name: subcategory_name,
                    description: description,
                    publication_status: publication_status,
                    _token: _token
                },
                success: function(response) {
                    if(response.code == 200) {
                        if(id != ""){
                            $("#row_"+id+" td:nth-child(2)").html(response.data.category_id);
                            $("#row_"+id+" td:nth-child(3)").html(response.data.subcategory_name);
                            $("#row_"+id+" td:nth-child(4)").html(response.data.description);
                            $("#row_"+id+" td:nth-child(5)").html(response.data.publication_status);
                        } else {
                            $('table tbody').prepend('<tr id="row_'+response.data.id+'">' +
                                '<td>'+response.data.id+'</td>' +
                                '<td>'+response.data.category_id+'</td>' +
                                '<td>'+response.data.subcategory_name+'</td>' +
                                '<td>'+response.data.description+'</td>' +
                                '<td>'+response.data.publication_status+'</td>' +
                                '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editSubCategory(event.target)" class="btn btn-info">Edit</a></td>' +
                                '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="deleteSubCategory(event.target)" class="btn btn-danger">Delete</a></td>' +
                                '</tr>');
                        }

                        $('#category_id').val('');
                        $('#subcategory_name').val(''),
                        $('#description').val('');
                        $('#publication_status').val('');
                        $('#subcategory-modal').modal('hide');
                    }
                },
                errors: function(response) {
                    $('#categoryError').text(response.responseJSON.errors.category_id);
                    $('#nameError').text(response.responseJSON.errors.subcategory_name);
                    $('#descriptionError').text(response.responseJSON.errors.description);
                    $('#statusError').text(response.responseJSON.errors.publication_status);
                }
            });
        }

        function deleteSubCategory(event) {
            var id  = $(event).data("id");
            let _url = `/subcategory/${id}`;
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
                    $("#roe_"+id).text('Data is not Deleted')
                }
            });
        }

    </script>
@endsection
