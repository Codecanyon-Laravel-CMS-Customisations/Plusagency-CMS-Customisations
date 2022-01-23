<table>
    <thead>
        <tr>
            <th>Is_woo</th>
            <th>Id</th>
            <th>Type</th>
            <th>SKU</th>
            <th>Name</th>
            <th>Published</th>
            <th>Is featured?</th>
            <th>Short Description</th>
            <th>Description</th>
            <th>Tags</th>
            <th>Categories</th>
            <th>Regular Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>0</td>
                <td>{{ $product->id }}</td>
                <td>{{ $product->type }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->status }}</td>
                <td>{{ $product->is_feature }}</td>
                <td>{{ $product->summary }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->tags }}</td>
                <td>{{ $product->category->name }}></td>
                <td>{{ $product->current_price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>