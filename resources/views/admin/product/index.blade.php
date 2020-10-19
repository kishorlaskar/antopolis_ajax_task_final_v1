@extends('admin.adminmaster')
@section('content')

    <div class="container">
        <h2 class="text-center text-success">Product Crud</h2>
        <br>
        <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalAdd">Add Product</a>
        <br>
        <br>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Category</th>
                <th scope="col">SubCategory</th>
                <th scope="col">Brand</th>
                <th scope="col">Name</th>
                <th scope="col">Size</th>
                <th scope="col">Color</th>
                <th scope="col">Price</th>
                <th scope="col">Image</th>
                <th scope="col">Status</th>
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
                    <h5 class="modal-title" id="ModalAddTitle">New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmSave" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Category</label>
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
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">SubCategory</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="subcategory_id" id="subcategory_id">
                                    @php
                                        $subcategories = DB::table('subcategories')->get();
                                    @endphp
                                    <option>---Select Category---</option>
                                    @foreach($subcategories as  $subcategory)
                                        <option value="{{$subcategory->id}}">{{$subcategory->subcategory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Brand</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="brand_id" id="brand_id">
                                    @php
                                        $brands = DB::table('brands')->get();
                                    @endphp
                                    <option>---Select Category---</option>
                                    @foreach($brands as  $brand)
                                        <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Size</label>
                            <input type="text" class="form-control" id="product_size" name="product_size">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Color</label>
                            <input type="text" class="form-control" id="product_color" name="product_color">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Price</label>
                            <input type="text" class="form-control" id="product_price" name="product_price">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Quantity</label>
                            <input type="text" class="form-control" id="product_quantity" name="product_quantity">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Short Description</label>
                            <textarea type="text" class="form-control" id="product_short_description" name="product_short_description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="name">Product Long Description</label>
                            <textarea type="text" class="form-control" id="product_long_description" name="product_long_description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="product_image" name="product_image">
                            <input type="hidden" name="old_image" id="old_image" value="">
                        </div>
                        <div class="form-group">
                            <label for="name">Publication Status</label>
                            <input type="text" class="form-control" id="publication_status" name="publication_status">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="frmAddClose">Close</button>
                    <input type="hidden" name="product_id" id="product_id" value="">
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
                    <h5 class="modal-title" id="ModalEditTitle">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmEdit" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Category</label>
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
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">SubCategory</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="subcategory_id" id="subcategory_id">
                                    @php
                                        $subcategories = DB::table('subcategories')->get();
                                    @endphp
                                    <option>---Select Category---</option>
                                    @foreach($subcategories as  $subcategory)
                                        <option value="{{$subcategory->id}}">{{$subcategory->subcategory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Brand</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="brand_id" id="brand_id">
                                    @php
                                        $brands = DB::table('brands')->get();
                                    @endphp
                                    <option>---Select Category---</option>
                                    @foreach($brands as  $brand)
                                        <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Size</label>
                            <input type="text" class="form-control" id="product_size" name="product_size">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Color</label>
                            <input type="text" class="form-control" id="product_color" name="product_color">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Price</label>
                            <input type="text" class="form-control" id="product_price" name="product_price">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Quantity</label>
                            <input type="text" class="form-control" id="product_quantity" name="product_quantity">
                        </div>
                        <div class="form-group">
                            <label for="name">Product Short Description</label>
                            <textarea type="text" class="form-control" id="product_short_description" name="product_short_description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="name">Product Long Description</label>
                            <textarea type="text" class="form-control" id="product_long_description" name="product_long_description"></textarea>
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
                    url: "{{route('product.get')}}",
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
                    url: "{{route('product.store')}}",
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
                        $('#product_id').val(data.id);
                        $('#old_image').val(data.product_image);
                        getData();
                    }
                });
            });

            //  show edit form for update
            $(document).on('click','.edit',function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $.get("{{route('product.edit')}}", {id:id},
                    function (data) {
                        console.log(data);
                        $('#ModalEdit').modal('show');
                        $('#frmEdit').find('#category_id').val(data.category_id);
                        $('#frmEdit').find('#subcategory_id').val(data.subcategory_id);
                        $('#frmEdit').find('#brand_id').val(data.brand_id);
                        $('#frmEdit').find('#product_name').val(data.product_name);
                        $('#frmEdit').find('#product_size').val(data.product_size);
                        $('#frmEdit').find('#product_color').val(data.product_color);
                        $('#frmEdit').find('#product_price').val(data.product_price);
                        $('#frmEdit').find('#product_quantity').val(data.product_quantity);
                        $('#frmEdit').find('#product_short_description').val(data.product_short_description);
                        $('#frmEdit').find('#product_long_description').val(data.product_long_description);
                        $('#frmEdit').find('#old_image').val(data.product_image);
                        $('#frmEdit').find('#publication_status').val(data.publication_status);
                        $('#frmEdit').find('#product_id').val(data.id);
                        $('#frmEdit').find('#img_edit').attr('src','{{asset("upload/product")}}/'+data.product_image);
                    }
                );
            });

            //update data to database
            $('#frmEdit').on('submit',function(e){
                e.preventDefault();
                var request = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{route('product.update')}}",
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
                            url: "{{route('product.destroy')}}",
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
