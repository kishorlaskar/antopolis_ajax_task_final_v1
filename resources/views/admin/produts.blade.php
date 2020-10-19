@extends('admin.master')
@section('content')
    <h2 style="margin-top: 12px;" class="alert alert-success">Product Crud
    </h2><br>
    <div class="row">
        <div class="col-12 text-right">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-product" onclick="addProduct()">Add Product</a>
        </div>
    </div>
    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12">
            <table id="laravel_crud" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Product Color</th>
                    <th>Product Price</th>
                    <th>Product Size</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr id="row_{{$product->id}}">
                        <td>{{ $product->id  }}</td>
                        <td>{{ $product->category_name }}</td>
                        <td>{{ $product->brand_name }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td><img src=" {{ $product->product_image }}" width="65" height="65" class="img-thumbnail"/></td>
                        <td>{{ $product->product_color }}</td>
                        <td>{{ $product->product_price }}</td>
                        <td>{{ $product->product_size }}</td>
                        <td>{{ $product->publication_status }}</td>
                        <td>
                            <a href="javascript:void(0)" data-id="{{ $product->id }}" onclick="editProduct(event.target)" class="btn btn-info">Edit</a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" data-id="{{ $product->id }}"  onclick="deleteProduct(event.target)" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="product-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form name="productForm" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id">
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
                                <span id="categoryError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Brand Name</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="brand_id" id="brand_id">
                                    @php
                                        $brands = DB::table('brands')->get();
                                    @endphp
                                    <option>---Select Brand---</option>
                                    @foreach($brands as  $brand)
                                        <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                                <span id="brandError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Product Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name">
                                <span class="text-danger">
                              {{ $errors->has('product_name') ? $errors->first('product_name') : ' ' }}
                        </span>
                                <span id="productnameError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Product Image : </label>
                            <div class="col-md-12">
                                <input type="file" name="product_image" id="product_image" class="form-control" />
                                <span class="text-danger">
                              {{ $errors->has('product_image') ? $errors->first('product_image') : ' ' }}
                        </span>
                                <span id="productimageError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Product Size</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="product_size" name="product_size" placeholder="Enter Product Size">
                                <span class="text-danger">
                              {{ $errors->has('product_size') ? $errors->first('product_size') : ' ' }}
                        </span>
                                <span id="productsizeError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Product Color</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="product_color" name="product_color" placeholder="Enter Product Color">
                                <span class="text-danger">
                              {{ $errors->has('product_color') ? $errors->first('product_color') : ' ' }}
                        </span>
                                <span id="productcolorError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Product Price</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter Product Price">
                                <span class="text-danger">
                              {{ $errors->has('product_price') ? $errors->first('product_price') : ' ' }}
                        </span>
                                <span id="productpriceError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Product Quantity</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="product_quantity" name="product_quantity" placeholder="Enter Product Quantity">
                                <span class="text-danger">
                              {{ $errors->has('product_quantity') ? $errors->first('product_quantity') : ' ' }}
                        </span>
                                <span id="productquantityError" class="alert-message"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Product Short Description</label>
                            <div class="col-sm-12">
                        <textarea class="form-control" id="product_short_description" name="product_short_description" rows="4" cols="4">
                        </textarea>
                                <span class="text-danger">
                              {{ $errors->has('product_short_description') ? $errors->first('product_short_description') : ' ' }}
                        </span>
                                <span id="shortdescriptionError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">Product Long Description</label>
                            <div class="col-sm-12">
                        <textarea class="form-control" id="product_long_description" name="product_long_description" rows="4" cols="50">
                        </textarea>
                                <span class="text-danger">
                              {{ $errors->has('product_long_description') ? $errors->first('product_long_description') : ' ' }}
                        </span>
                                <span id="longdescriptionError" class="alert-message"></span>
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
                    <button type="button" class="btn btn-primary" onclick="createProduct()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#laravel_crud').DataTable();

        function addProduct() {
            $("#product_id").val('');
            $('#product-modal').modal('show');
        }

        function editProduct(event) {
            var id  = $(event).data("id");
            let _url = `/products/${id}`;
            $('#categoryError').text('');
            $('#brandError').text('');
            $('#productnameError').text('');
            $('#productimageError').text('');
            $('#productquantityError').text('');
            $('#productsizeError').text('');
            $('#productcolorError').text('');
            $('#productpriceError').text('');
            $('#shortdescriptionError').text('');
            $('#longdescriptionError').text('');
            $('#statusError').text('');

            $.ajax({
                url: _url,
                type: "GET",
                success: function(response) {
                    if(response) {
                        $("#product_id").val(response.id);
                        $("#category_id").val(response.category_id);
                        $("#brand_id").val(response.brand_id);
                        $("#product_name").val(response.product_name);
                        $("#product_image").val(response.product_image);
                        $("#product_color").val(response.product_color);
                        $("#product_size").val(response.product_size);
                        $("#product_quantity").val(response.product_quantity);
                        $("#product_price").val(response.product_price);
                        $("#product_short_description").val(response.product_short_description);
                        $("#product_long_description").val(response.product_long_description);
                        $("#publication_status").val(response.publication_status);

                        $('#product-modal').modal('show');
                    }
                }
            });
        }

        function createProduct() {
            var category_id = $('#category_id').val();
            var brand_id = $('#brand_id').val();
            var product_name = $('#product_name').val();
            var product_image = $('#product_image').val();
            var product_size = $('#product_size').val();
            var product_color = $('#product_color').val();
            var product_quantity = $('#product_quantity').val();
            var product_price = $('#product_price').val();
            var product_short_description = $('#product_short_description').val();
            var product_long_description = $('#product_long_description').val();
            var publication_status = $('#publication_status').val();
            var id = $('#product_id').val();

            let _url     = `/products`;
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    id: id,
                    category_id: category_id,
                    brand_id: brand_id,
                    product_name:product_name,
                    product_image:product_image,
                    product_color:product_color,
                    product_size:product_size,
                    product_quantity:product_quantity,
                    product_price:product_price,
                    product_short_description:product_short_description,
                    product_long_description: product_long_description,
                    publication_status: publication_status,
                    _token: _token
                },
                success: function(response) {
                    if(response.code == 200) {
                        if(id != ""){
                            $("#row_"+id+" td:nth-child(2)").html(response.data.category_id);
                            $("#row_"+id+" td:nth-child(3)").html(response.data.brand_id);
                            $("#row_"+id+" td:nth-child(4)").html(response.data.product_name);
                            $("#row_"+id+" td:nth-child(5)").html(response.data.product_image);
                            $("#row_"+id+" td:nth-child(6)").html(response.data.product_color);
                            $("#row_"+id+" td:nth-child(7)").html(response.data.product_size);
                            $("#row_"+id+" td:nth-child(8)").html(response.data.product_quantity);
                            $("#row_"+id+" td:nth-child(9)").html(response.data.product_price);
                            $("#row_"+id+" td:nth-child(10)").html(response.data.product_short_description);
                            $("#row_"+id+" td:nth-child(11)").html(response.data.product_long_description);
                            $("#row_"+id+" td:nth-child(12)").html(response.data.publication_status);
                        } else {
                            $('table tbody').prepend('<tr id="row_'+response.data.id+'">' +
                                '<td>'+response.data.id+'</td>' +
                                '<td>'+response.data.category_id+'</td>' +
                                '<td>'+response.data.brand_id+'</td>' +
                                '<td>'+response.data.product_name+'</td>' +
                                '<td>'+response.data.product_image+'</td>' +
                                '<td>'+response.data.product_color+'</td>' +
                                '<td>'+response.data.product_size+'</td>' +
                                '<td>'+response.data.product_quantity+'</td>' +
                                '<td>'+response.data.product_price+'</td>' +
                                '<td>'+response.data.product_short_description+'</td>' +
                                '<td>'+response.data.product_long_description+'</td>' +
                                '<td>'+response.data.publication_status+'</td>' +
                                '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editProduct(event.target)" class="btn btn-info">Edit</a></td>' +
                                '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="deleteProduct(event.target)" class="btn btn-danger">Delete</a></td>' +
                                '</tr>');
                        }
                        $('#category_id').val();
                        $('#brand_id').val();
                        $('#product_name').val();
                        $('#product_image').val();
                        $('#product_size').val();
                        $('#product_color').val();
                        $('#product_quantity').val();
                        $('#product_price').val();
                        $('#product_short_description').val();
                        $('#product_long_description').val();
                       $('#publication_status').val();
                    }
                },
                errors: function(response) {
                    $('#categoryError').text(response.responseJSON.errors.category_id);
                    $('#brandError').text(response.responseJSON.errors.brand_id);
                    $('#productnameError').text(response.responseJSON.errors.product_name);
                    $('#productimageError').text(response.responseJSON.errors.product_image);
                    $('#productcolorError').text(response.responseJSON.errors.product_color);
                    $('#productsizeError').text(response.responseJSON.errors.product_size);
                    $('#productquantityError').text(response.responseJSON.errors.product_quantity);
                    $('#productpriceError').text(response.responseJSON.errors.product_price);
                    $('#shortdescriptionError').text(response.responseJSON.errors.product_short_description);
                    $('#longdescriptionError').text(response.responseJSON.errors.product_long_description);
                    $('#statusError').text(response.responseJSON.errors.publication_status);
                }
            });
        }

        function deleteProduct(event) {
            var id  = $(event).data("id");
            let _url = `/products/${id}`;
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
