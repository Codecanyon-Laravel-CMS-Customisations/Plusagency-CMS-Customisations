@extends('admin.layout')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product CSV Import</h3>
        <div class="float-right">
            <a href="{{ route('plugins.importer.export') }}" class="btn btn-warning">Export Products</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route( 'plugins.importer.store' ) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Upload file</label>
                <input type="file" class="form-control" accept=".xls,.xlsx" name="file">
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">Import File</button>
            </div>
        </form>
    </div>
</div>

@endsection
