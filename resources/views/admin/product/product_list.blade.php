@foreach ($products as $key => $product)
    <tr>
        <td>{{++$key}}</td>
        <td>{{$product->category_name}}</td>
        <td>{{$product->subcategory_name}}</td>
        <td>{{ $product->brand_name }}</td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->product_size }}</td>
        <td>{{ $product->product_color }}</td>
        <td>{{ $product->product_price }}</td>
        <td><img src="{{asset('Upload/Product/'.$product->product_image)}}" width="40" height="40" alt="{{$product->product_name}}"></td>
        <td>{{$product->publication_status}}</td>
        <td>
            <a href="#" class="btn btn-success btn-sm edit" data-id="{{$product->id}}">Edit</a>
            <a href="#" class="btn btn-danger btn-sm delete" data-id="{{$product->id}}">Delete</a>
        </td>
    </tr>
@endforeach
