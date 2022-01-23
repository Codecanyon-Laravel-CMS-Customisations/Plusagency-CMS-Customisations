@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product Tabs</h3>
        <p>Here you can set tabs that will appear on all products. To set tabs for individual products go the product edit screen.</p>
    </div>
    <div class="card-body">
        @if ( ! is_null( $product_tabs ) )
            @foreach( json_decode( $product_tabs ) as $tab )
                <p>{{ $tab->title }} - 
                    <a href="{{ route( 'plugins.tabs.edit', [ 'tab' => $tab->title, 'language' => 'en' ] ) }}" class="btn btn-info btn-sm d-inline-block mr-3 ml-3">Edit</a> 
                    <a href="{{ route( 'plugins.tabs.destroy', [ 'tab' => $tab->title, 'language' => 'en' ] ) }}" class="btn btn-danger btn-sm">Delete</a> </p>
            @endforeach
        @endif

       <form action="{{ route( 'plugins.tabs.store' ) }}" method="post">
           @csrf
           <input type="hidden" name="language" value="en">
           <div class="form-group">
               <button class="btn btn-warning btn-sm btn-block" type="button" id="btn-new-tab">Create New Tab</button>
                <div id="new-tab-form" style="display: none;">
                    <div class="form-group">
                        <label for="">Tab Title:</label>
                        <input type="text" name="title" class="form-control" id="new-tab-ttile" required>
                    </div>
                    <div class="form-group">
                        <label for="">Is Global Tab?</label>
                        <select id="new-tab-global" name="global" class="form-control" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group" id="new-tab-product-group" style="display: none;">
                        <label for="">Select product where tab will be shown</label>
                        <select name="product_id" id="" class="form-control">
                            @foreach( $products as $product )
                                <option value="{{ $product->id }}">{{ $product->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tab Type:</label>
                        <select id="new-tab-type" name="type" class="form-control" required>
                            <option value="content">Display tab content</option>
                            <option value="link">Redirect to another link</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div id="new-tab-content-group">
                            <label for="">Tab Content</label>
                            <textarea name="content" id="new-tab-content"></textarea>
                            <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
                            <script>
                                CKEDITOR.replace( 'content' );
                            </script>
                        </div>
                        <div id="new-tab-link-group" style="display: none;">
                            <label for="">Redirect Link</label>
                            <input type="url" name="link" class="form-control" id="new-tab-link">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Save Tab</button>
                    </div>
                </div>
           </div>
       </form>
    </div>
</div>
@endsection

@section('scripts')

    <script>
        $( document ).ready( function() {

            $( '#btn-new-tab' ).click( () => {
                $( '#new-tab-form' ).css( 'display', 'block' );
            } );

            $( '#new-tab-type' ).change( () => {
                switch ( $( '#new-tab-type' ).val() ) {
                    case 'link':
                        $( '#new-tab-content-group' ).css( 'display', 'none' );
                        $( '#new-tab-link-group' ).css( 'display', 'block' );
                        break;
                    case 'content':
                        $( '#new-tab-content-group' ).css( 'display', 'block' );
                        $( '#new-tab-link-group' ).css( 'display', 'none' );
                        break;
                }
            } );

            $( '#new-tab-global' ).change( () => {
                switch ( $( '#new-tab-global' ).val() ) {
                    case '1':
                        $( '#new-tab-product-group' ).css( 'display', 'none' );
                        break;
                    case '0':
                        $( '#new-tab-product-group' ).css( 'display', 'block' );
                        break;
                }
            } );

        } );
    </script>
@endsection