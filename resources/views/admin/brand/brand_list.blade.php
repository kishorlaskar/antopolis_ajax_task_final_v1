@foreach ($brands as $key => $brand)
    <tr>
        <td>{{++$key}}</td>
        <td>{{$brand->brand_name}}</td>
        <td>{{$brand->brand_description}}</td>
        <td><img src="{{asset('Upload/Brand/'.$brand->brand_image)}}" width="40" height="40" alt="{{$brand->brand_name}}"></td>
        <td>{{$brand->publication_status}}</td>
        <td>
            <a href="#" class="btn btn-success btn-sm edit" data-id="{{$brand->id}}">Edit</a>
            <a href="#" class="btn btn-danger btn-sm delete" data-id="{{$brand->id}}">Delete</a>
        </td>
    </tr>
    @endforeach
