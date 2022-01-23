@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product Custom Fields</h3>
    </div>
    <div class="card-body">
        @if ( ! is_null( $product_fields ) )
            @foreach( json_decode( $product_fields ) as $field )
                <p>{{ $field->name }} - 
                    <a href="{{ route( 'plugins.fields.edit', [ 'field' => $field->name, 'language' => 'en' ] ) }}" class="btn btn-info btn-sm d-inline-block mr-3 ml-3">Edit</a> 
                    <a href="{{ route( 'plugins.fields.destroy', [ 'field' => $field->name, 'language' => 'en' ] ) }}" class="btn btn-danger btn-sm">Delete</a> </p>
            @endforeach
        @endif

       <form action="{{ route( 'plugins.fields.store' ) }}" method="post">
           @csrf
           <input type="hidden" name="language" value="en">
           <div class="form-group">
               <button class="btn btn-warning btn-sm btn-block" type="button" id="btn-new-field">Create New Field</button>
                <div id="new-field-form" style="display: none;">
                    <div class="form-group">
                        <label for="">Field Name:</label>
                        <input type="text" name="name" class="form-control" id="new-field-ttile" required>
                    </div>
                    <div class="form-group">
                        <label for="">Product or Category</label>
                        <select name="display" class="form-control" id="display-select">
                            <option value="product">Product</option>
                            <option value="category">Category</option>
                        </select>
                    </div>
                    <div class="form-group" id="products-select">
                        <label for="">Products</label>
                        <select name="id" id="" class="form-control">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="categories-select" style="display: none;">
                        <label for="">Category</label>
                        <select name="id" id="" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Field Type:</label>
                        <select name="type" id="new-field-type" class="form-control" required>
                            <option value="text">Text box</option>
                            <option value="number">Number</option>
                            <option value="select">Select</option>
                            <option value="textarea">Textarea</option>
                            <option value="radio">Radio Button</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="date">Date Picker</option>
                            <option value="color">Color Picker</option>
                        </select>
                    </div>
                    <div class="form-group" id="new-field-select-group" style="display: none;">
                        <input type="hidden" name="select_options" id="select-options" value="">
                        <ul id="select-options-ul"></ul>
                        <label for="">Select Options</label>
                        <input type="text" id="select-option" class="form-control" placeholder="New Option">
                        <button type="button" class="btn btn-info btn-sm" id="add-select-option">Add Option</button>
                    </div>
                    <div class="form-group" id="new-field-radio-group" style="display: none;">
                        <input type="hidden" name="radio_options" id="radio-options" value="">
                        <ul id="radio-options-ul"></ul>
                        <label for="">Radio Options</label>
                        <input type="text" id="radio-option" class="form-control" placeholder="New Option">
                        <button type="button" class="btn btn-info btn-sm" id="add-radio-option">Add Option</button>
                    </div>
                    <div class="form-group" id="new-field-checkbox-group" style="display: none;">
                        <input type="hidden" name="checkbox_options" id="checkbox-options" value="">
                        <ul id="checkbox-options-ul"></ul>
                        <label for="">Checkbox Options</label>
                        <input type="text" id="checkbox-option" class="form-control" placeholder="New Option">
                        <button type="button" class="btn btn-info btn-sm" id="add-checkbox-option">Add Option</button>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Save field</button>
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

            $( '#display-select' ).change( () => {
                if ( $('#display-select').val() == 'product' ) {
                    $('#products-select').css('display', 'block');
                    $('#categories-select').css('display', 'none');
                }
                if ( $('#display-select').val() == 'category' ) {
                    $('#products-select').css('display', 'none');
                    $('#categories-select').css('display', 'block');
                }
            } );

            $( '#btn-new-field' ).click( () => {
                $( '#new-field-form' ).css( 'display', 'block' );
            } );

            $( '#new-field-type' ).change( () => {
                if ( $( '#new-field-type' ).val() != 'select' ) {
                    $( '#new-field-select-group' ).css( 'display', 'none' );
                } else {
                    $( '#new-field-select-group' ).css( 'display', 'block' );
                }

                if ( $( '#new-field-type' ).val() != 'radio' ) {
                    $( '#new-field-radio-group' ).css( 'display', 'none' );
                } else {
                    $( '#new-field-radio-group' ).css( 'display', 'block' );
                }

                if ( $( '#new-field-type' ).val() != 'checkbox' ) {
                    $( '#new-field-checkbox-group' ).css( 'display', 'none' );
                } else {
                    $( '#new-field-checkbox-group' ).css( 'display', 'block' );
                }

            } );

            $( '#add-select-option' ).click( () => {
                let options = '';
                let html = '';
                if ( $( '#select-options' ).val() == '' ) {
                    options = []
                } else {
                    options = JSON.parse( $( '#select-options' ).val() );
                }
                options.push( $( '#select-option' ).val() );
                $( '#select-options' ).val( JSON.stringify( options ) );
                options.forEach( option => {
                    html += `<li class="mb-3">${option} - <button type="button" class="btn btn-danger btn-sm" onclick="remove_select_option('${option}')">remove</button></li>`;
                } );
                $( '#select-options-ul' ).html( html );
                $( '#select-option' ).val( '' );
            } )

            $( '#add-radio-option' ).click( () => {
                let options = '';
                let html = '';
                if ( $( '#radio-options' ).val() == '' ) {
                    options = []
                } else {
                    options = JSON.parse( $( '#radio-options' ).val() );
                }
                options.push( $( '#radio-option' ).val() );
                $( '#radio-options' ).val( JSON.stringify( options ) );
                options.forEach( option => {
                    html += `<li class="mb-3">${option} - <button type="button" class="btn btn-danger btn-sm" onclick="remove_radio_option('${option}')">remove</button></li>`;
                } );
                $( '#radio-options-ul' ).html( html );
                $( '#radio-option' ).val( '' );
            } )

            $( '#add-checkbox-option' ).click( () => {
                let options = '';
                let html = '';
                if ( $( '#checkbox-options' ).val() == '' ) {
                    options = []
                } else {
                    options = JSON.parse( $( '#checkbox-options' ).val() );
                }
                options.push( $( '#checkbox-option' ).val() );
                $( '#checkbox-options' ).val( JSON.stringify( options ) );
                options.forEach( option => {
                    html += `<li class="mb-3">${option} - <button type="button" class="btn btn-danger btn-sm" onclick="remove_checkbox_option('${option}')">remove</button></li>`;
                } );
                $( '#checkbox-options-ul' ).html( html );
                $( '#checkbox-option' ).val( '' );
            } )

        } );

        function remove_select_option( value ) {
            let html = '';
            let options = JSON.parse(  $( '#select-options' ).val() ).filter( option => {
                return option != value;
            } );
            $( '#select-options' ).val( JSON.stringify( options ) );
            options.forEach( option => {
                html += `<li>${option} - <button type="button" class="btn btn-danger btn-sm" onclick="remove_select_option('${option}')">remove</button></li>`;
            } );
            $( '#select-options-ul' ).html( html );
        }

        function remove_radio_option( value ) {
            let html = '';
            let options = JSON.parse(  $( '#radio-options' ).val() ).filter( option => {
                return option != value;
            } );
            $( '#radio-options' ).val( JSON.stringify( options ) );
            options.forEach( option => {
                html += `<li>${option} - <button type="button" class="btn btn-danger btn-sm" onclick="remove_radio_option('${option}')">remove</button></li>`;
            } );
            $( '#radio-options-ul' ).html( html );
        }

        function remove_checkbox_option( value ) {
            let html = '';
            let options = JSON.parse(  $( '#checkbox-options' ).val() ).filter( option => {
                return option != value;
            } );
            $( '#checkbox-options' ).val( JSON.stringify( options ) );
            options.forEach( option => {
                html += `<li>${option} - <button type="button" class="btn btn-danger btn-sm" onclick="remove_checkbox_option('${option}')">remove</button></li>`;
            } );
            $( '#checkbox-options-ul' ).html( html );
        }
    </script>
@endsection