@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit {{ $field->name }} Field</h3>
    </div>
    <div class="card-body">

       <form action="{{ route( 'plugins.fields.update', [ 'field' => $field->name, 'language' => 'en'] ) }}" method="post">
           @csrf
           <input type="hidden" name="language" value="en">
           <div class="form-group">
               {{-- <button class="btn btn-warning btn-sm btn-block" type="button" id="btn-new-field">Create New Field</button> --}}
                <div id="new-field-form">
                    <div class="form-group">
                        <label for="">Field Name:</label>
                        <input type="text" name="name" class="form-control" id="new-field-ttile" required value="{{ $field->name }}">
                    </div>
                    <div class="form-group">
                        <label for="">Field Type:</label>
                        <select name="type" id="new-field-type" class="form-control" required>
                            <option value="text" @if( $field->type == 'text' ) selected @endif>Text box</option>
                            <option value="number" @if( $field->type == 'number' ) selected @endif>Number</option>
                            <option value="select" @if( $field->type == 'select' ) selected @endif>Select</option>
                            <option value="textarea" @if( $field->type == 'textarea' ) selected @endif>Textarea</option>
                            <option value="radio" @if( $field->type == 'radio' ) selected @endif>Radio Button</option>
                            <option value="checkbox" @if( $field->type == 'checkbox' ) selected @endif>Checkbox</option>
                            <option value="date" @if( $field->type == 'date' ) selected @endif>Date Picker</option>
                            <option value="color" @if( $field->type == 'color' ) selected @endif>Color Picker</option>
                        </select>
                    </div>
                    <div class="form-group" id="new-field-select-group" @if( $field->type != 'select')style="display: none;" @endif>
                        <input type="hidden" name="select_options" id="select-options" value="{{ $field->type == 'select' ? $field->options : '' }}">
                        <ul id="select-options-ul"></ul>
                        <label for="">Select Options</label>
                        <input type="text" id="select-option" class="form-control" placeholder="New Option">
                        <button type="button" class="btn btn-info btn-sm" id="add-select-option">Add Option</button>
                    </div>
                    <div class="form-group" id="new-field-radio-group" @if( $field->type != 'radio')style="display: none;" @endif>
                        <input type="hidden" name="radio_options" id="radio-options" value="{{ $field->type == 'radio' ? $field->options : '' }}">
                        <ul id="radio-options-ul"></ul>
                        <label for="">Radio Options</label>
                        <input type="text" id="radio-option" class="form-control" placeholder="New Option">
                        <button type="button" class="btn btn-info btn-sm" id="add-radio-option">Add Option</button>
                    </div>
                    <div class="form-group" id="new-field-checkbox-group" @if( $field->type != 'checkbox')style="display: none;" @endif>
                        <input type="hidden" name="checkbox_options" id="checkbox-options" value="{{ $field->type == 'checkbox' ? $field->options : '' }}">
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

            let html = '';

            @if($field->type == 'select')
                let options = JSON.parse( $( '#select-options' ).val() )
                options.forEach( option => {
                    html += `<li class="mb-3">${option} - <button type="button" class="btn btn-danger btn-sm" onclick="remove_select_option('${option}')">remove</button></li>`;
                } );
                $( '#select-options-ul' ).html( html );
            @endif

            @if($field->type == 'radio')
                let options = JSON.parse( $( '#radio-options' ).val() );
                options.forEach( option => {
                    html += `<li class="mb-3">${option} - <button type="button" class="btn btn-danger btn-sm" onclick="remove_radio_option('${option}')">remove</button></li>`;
                } );
                $( '#radio-options-ul' ).html( html );
            @endif

            @if($field->type == 'checkbox')
                let options = JSON.parse( $( '#checkbox-options' ).val() );
                options.forEach( option => {
                    html += `<li class="mb-3">${option} - <button type="button" class="btn btn-danger btn-sm" onclick="remove_checkbox_option('${option}')">remove</button></li>`;
                } );
                $( '#checkbox-options-ul' ).html( html );
            @endif

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