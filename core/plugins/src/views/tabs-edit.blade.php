@extends('admin.layout')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit {{ $tab->title }} Tab</h3>
    </div>
    <div class="card-body">

       <form action="{{ route( 'plugins.tabs.update', ['tab' => $tab->title] ) }}" method="post">
           @csrf
           <input type="hidden" name="language" value="en">
           <div class="form-group">
                <div id="new-tab-form">
                    <div class="form-group">
                        <label for="">Tab Title:</label>
                        <input type="text" name="title" class="form-control" id="new-tab-ttile" value={{ $tab->title }}>
                    </div>
                    <div class="form-group">
                        <label for="">Is Global Tab?</label>
                        <select id="new-tab-global" name="global" class="form-control" required>
                            <option value="1" @if($tab->global == '1') selected @endif>Yes</option>
                            <option value="0" @if($tab->global == '0') selected @endif>No</option>
                        </select>
                    </div>
                    <div class="form-group" id="new-tab-product-group" @if($tab->global == '1')style="display: none;"@endif>
                        <label for="">Select product where tab will be shown</label>
                        <select name="product_id" id="" class="form-control">
                            @foreach( $products as $product )
                                <option value="{{ $product->id }}" @if($tab->product_id == $product->id) selected @endif>{{ $product->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tab Type:</label>
                        <select id="new-tab-type" name="type" class="form-control">
                            <option value="content" @if($tab->type == 'content') selected @endif >Display tab content</option>
                            <option value="link" @if($tab->type == 'link') selected @endif>Redirect to another link</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div id="new-tab-content-group">
                            <label for="">Tab Content</label>
                            <textarea name="content" id="new-tab-content">{{ $tab->content }}</textarea>
                            <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
                            <script>
                                CKEDITOR.replace( 'content' );
                            </script>
                        </div>
                        <div id="new-tab-link-group" style="display: none;">
                            <label for="">Redirect Link</label>
                            <input type="url" name="link" class="form-control" id="new-tab-link" value="{{ $tab->link }}">
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