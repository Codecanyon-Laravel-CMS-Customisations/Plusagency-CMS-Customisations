@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Global Product Attributes</h3>
    </div>
    <div class="card-body">

       <form action="{{ route( 'plugins.attributes.update', ['attribute' => $attribute->name] ) }}" method="post">
           @csrf
                <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Attribute Name" value="{{ $attribute->name }}">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="value" placeholder="Attribute Value" value="{{ $attribute->value }}">
                </div>
        <div class="form-goup">
            <button type="submit" class="btn btn-success">Save Attribute</button>
        </div>
       </form>
    </div>
</div>
@endsection

@section('scripts')
@endsection