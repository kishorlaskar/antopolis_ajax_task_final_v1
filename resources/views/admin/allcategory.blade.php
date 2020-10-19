@extends('admin.master')
@section('body')
<div class="container">
    <br />
    <h3 align="center">Categories Crud</h3>
    <br />
    <div class="row">
        <div class="col-md-8">
               <table id="datatable" class="table table-bordered table-striped">
                   <thead>
                     <tr>
                         <th>Id</th>
                         <th>Category Name</th>
                         <th>Category Description</th>
                         <th>Publication Status</th>
                         <th>Action</th>
                     </tr>
                   </thead>
                   <tbody></tbody>
               </table>
        </div>
        <div class="col-md-4">
                  <form method="post">
                      @csrf
                      <div class="form-group myId">
                          <lable>Id</lable>
                          <input type="number" id="id" name="id" class="form-control" readonly="readonly">
                      </div>
                      <div class="form-group ">
                          <lable>Category Name</lable>
                          <input type="text" id="category_name" name="category_name" class="form-control">
                      </div>
                      <div class="form-group">
                          <lable>Category Description</lable>
                          <textarea  id="category_description" name="category_description" class="form-control"></textarea>
                      </div>
                      <div class="form-group">
                          <lable>Publication Status</lable>
                          <input type="text" id="publication_status" name="publication_status" class="form-control">
                      </div>
                      <button type="button" id="save"   onclick="saveData()">Save</button>
                      <button type="button" id="update" onclick="updateData()">Update</button>
                  </form>
        </div>
    </div>
</div>
<script>
    $('#datatable').DataTable();
    $('#save').show();
    $('#update').hide();
    $('.myId').hide();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function viewData()
    {
      $.ajax({
          type:"GET",
          dataType: "json",
          url:{{ route('category.index') }},
          success:function(response){
              var rows="";
              $.each(response.data,function(key,value)
              {
                     rows = rows+"<tr>";
                     rows = rows+"<td>"+value.id+"<td>";
                     rows = rows+"<td>"+value.category_name+"<td>";
                     rows = rows+"<td>"+value.category_description+"<td>";
                     rows = rows+"<td>"+value.publication_status+"<td>";
                     rows = rows+"<td width='180'>";
                     rows = rows+"<button type='button' class='btn btn-warning' onclick='editData("+value.id+","+value.category_name+","+value.category_description+","+value.publication_status+")'>Edit</button>";
                     rows = rows+"<button type='button' class='btn btn-danger' onclick='deleteData("+value+")'>Delete</button>";
                     rows = rows+"</td></tr>";
              });
              $('tbody').html(rows);
          }

      })
    }
    viewData();
    function saveData()
    {
              var category_name = $('#category_name').val();
              var category_description = $('#category_description').val();
              var publication_status = $('#publication_status').val();
              $.ajax({
                  type: "POST",
                  dataType: 'json',
                  data: {
                      category_name: category_name,
                      category_description: category_description,
                      publication_status: publication_status
                  },
                  url:{{ route('category.store') }}
                      success: function (response)
    {
                  {
                      viewData();
                      clearData();
                      $('#save').show();
                  }


              })
    }
    function clearData()
    {
         $('#id').val('');
         $('category_name').val('');
         $('category_description').val('');
         $('publication_status').val('');
    }
    function editData(id)
    {
        $('#save').hide();
        $('#update').show();
        $('.myId').show();
        $.ajax({
            type: "GET",
            dataType: 'json',
            url:{{ route('category.edit') }},
            success: function (response)
            {
                $('#id').val(response.id);
                $('#category_name').val(response.category_name);
                $('#category_description').val(response.category_description);
                $('#publication_status').val(response.publication_status);
            },
            error: function (response)
            {
                console.log('Error:', data);
                $('#save').html('Save Changes');
            }
        })

    }
    function update()
    {
        var id = $('#id').val();
        var category_name = $('#category_name').val();
        var category_description = $('#category_description').val();
        var publication_status = $('#publication_status').val();
        $.ajax({
            type: "PUT",
            dataType: "json",
            data:{category_name:category_name,category_description:category_description,publication_status:publication_status}
            url:{{ route('category.update') }},
            success:function(response)
            {
                viewData();
                clearData();
                $('#save').show();
                $('#update').hide();
                $('.myId').hide();
            }
        })
    }
    function deleteData($id)
    {
        $.ajax({
            type: "DELETE",
            dataType: "json",
            url:{{ route('category.destroy') }},
            success:function(response)
            {
                viewData();
            }
        })
    }
</script>
@endsection

