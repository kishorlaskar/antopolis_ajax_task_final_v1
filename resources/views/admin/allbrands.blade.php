@extends('admin.master')
@section('body')
    <div class="container">
        <br />
        <h3 align="center">Brands Crud</h3>
        <br />
        <div align="right">
            <button type="button" name="create_brand" id="create_brand" class="btn btn-success btn-sm">Create Brand</button>
        </div>
        <br/>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="brand_table">
                <thead>
                <tr>
                    <th width="10%">Logo</th>
                    <th width="35%">Name</th>
                    <th width="35%">Description</th>
                    <th width="35%">Status</th>
                    <th width="30%">Action</th>
                </tr>
                </thead>
            </table>
        </div>
        <br/>
        <br/>
    </div>

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Brand</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-4" >Brand Name : </label>
                            <div class="col-md-8">
                                <input type="text" name="brand_name" id="brand_name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Brand Description : </label>
                            <div class="col-md-8">
                                <input type="text" name="brand_description" id="brand_description" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Publication Status : </label>
                            <div class="col-md-8">
                                <input type="text" name="publication_status" id="publication_status" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Select Profile Image : </label>
                            <div class="col-md-8">
                                <input type="file" name="brand_image" id="brand_image" />
                                <span id="store_image"></span>
                            </div>
                        </div>
                        <br />
                        <div class="form-group" align="center">
                            <input type="hidden" name="action" id="action" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Confirmation</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){

            $('#brand_table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('brand.index') }}",
                },
                columns:[
                    {
                        data: 'brand_image',
                        name: 'brand_image',
                        render: function(data, type, full, meta){
                            return "<img src={{ URL::to('/') }}/images/" + data + " width='70' class='img-thumbnail' />";
                        },
                        orderable: false
                    },
                    {
                        data: 'brand_name',
                        name: 'brand_name'
                    },
                    {
                        data: 'brand_description',
                        name: 'brand_description'
                    },
                    {
                        data: 'publication_status',
                        name: 'publication_status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });

            $('#create_brand').click(function(){
                $('.modal-title').text("Add New Brand");
                $('#action_button').val("Add");
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                if($('#action').val() == 'Add')
                {
                    $.ajax({
                        url:"{{ route('brand.store') }}",
                        method:"POST",
                        data: new FormData(this),
                        contentType: false,
                        cache:false,
                        processData: false,
                        dataType:"json",
                        success:function(data)
                        {
                            var html = '';
                            if(data.errors)
                            {
                                html = '<div class="alert alert-danger">';
                                for(var count = 0; count < data.errors.length; count++)
                                {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if(data.success)
                            {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#sample_form')[0].reset();
                                $('#brand_table').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html);
                        }
                    })
                }

                if($('#action').val() == "Edit")
                {
                    $.ajax({
                        url:"{{ route('brand.update') }}",
                        method:"POST",
                        data:new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType:"json",
                        success:function(data)
                        {
                            var html = '';
                            if(data.errors)
                            {
                                html = '<div class="alert alert-danger">';
                                for(var count = 0; count < data.errors.length; count++)
                                {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if(data.success)
                            {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#sample_form')[0].reset();
                                $('#store_image').html('');
                                $('#brand_table').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html);
                        }
                    });
                }
            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url:"/brand/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#brand_name').val(html.data.brand_name);
                        $('#brand_description').val(html.data.brand_description);
                        $('#publication_status').val(html.data.publication_status);
                        $('#store_image').html("<img src={{ URL::to('/') }}/images/" + html.data.image + " width='70' class='img-thumbnail' />");
                        $('#store_image').append("<input type='hidden' name='hidden_image' value='"+html.data.image+"' />");
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Edit New Record");
                        $('#action_button').val("Edit");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"brand/destroy/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            $('#brand_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });

        });
    </script>
@endsection
