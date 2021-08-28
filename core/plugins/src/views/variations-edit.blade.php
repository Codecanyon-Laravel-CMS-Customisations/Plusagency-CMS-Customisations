@extends('admin.layout')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product Variations</h3>
    </div>
    <div class="card-body">
        <form id="ajaxForm" class="" action="{{route('admin.product.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden"  name="product_id" value="{{$variation->id}}">
            <input type="hidden" name="is_variation" value="1">
            {{-- <div class="form-group">
                <label for="">Select Product</label>
                <select name="parent_id" id="" class="form-control">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" @if( $parent_id == $product->id ) selected @endif>{{ $product->title }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="form-group">
                <label for="">Variation Title **</label>
                <input type="text" class="form-control" name="title" placeholder="Enter title" value="{{ $variation->title }}">
                <p id="errtitle" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
                <label for="">Variation Thumbnail</label>
                <input type="file" class="form-control" name="thumbnail">
                @if(json_decode($variation->variation_data)->thumbnail)
                    <img src="{{ asset('assets/' . json_decode($variation->variation_data)->thumbnail) }}" alt="" width="150" style="border-radius: 50%; @if(isset($_GET['variation']) && $_GET['variation'] == $variation->id) border: 1px solid black; @endif">
                @endif
            </div>

            <div class="form-group">
                <label for=""> Current Price **</label>
                <input type="number" class="form-control ltr" name="current_price"  placeholder="Enter Current Price" value="{{ $variation->current_price }}">
                <p id="errcurrent_price" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
                <label for="">Previous Price </label>
                <input type="number" class="form-control ltr" name="previous_price" placeholder="Enter Previous Price" value="{{ $variation->previous_price }}">
                <p id="errprevious_price" class="mb-0 text-danger em"></p>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group" id="attributes-form-group">
                        <label for="">Product Attributes</label>
                        <input type="hidden" name="attributes" id="attributes" value="{{ $variation->attributes }}">
                        <button type="button" class="btn btn-warning btn-sm mb-3" id="add-attribute">Add Attribute</button>
                        <div id="attributes-form" class="form-group" style="display: none;">
                            <input type="hidden" name="edit" value="hidden" id="attribute-edit">
                            <input type="text" class="form-control" id="attribute-name" placeholder="Attribute Name">
                            <input type="text" class="form-control" id="attribute-value" placeholder="Attribute Value">
                            <button class="btn btn-success btn-sm" id="save-attribute">Save Atribute</button>
                        </div>
                        <ul style="display: none;" id="attributes-list"></ul>
                    </div>
                </div>
            </div>

            <h3>Custom Fields</h3>
            @if ( ! is_null( $product_fields ) )
                @foreach ( json_decode( $product_fields ) as $field )
                @php
                    $fields = collect(json_decode( $variation->custom_fields ));
                    $value = $fields->filter( function($f) use ($field) {
                    return $f->name == $field->name;
                });

                foreach ($value as $v) {
                    $value = $v->value;
                }
                @endphp
                    <div class="form-group">
                        <label for="">{{ $field->name }}</label>
                        @switch( $field->type )
                                @case( 'text' )
                                <input type="text" class="form-control" name="{{ Str::slug($field->name) }}" value="{{ $value }}">
                                @break

                                @case( 'number' )
                                <input type="number" class="form-control" name="{{ Str::slug($field->name) }}" value="{{ $value }}">
                                @break

                                @case( 'textarea' )
                                <textarea name="{{ Str::slug($field->name) }}" id="" cols="30" rows="10" class="form-control">{{ $value }}</textarea>
                                @break

                                @case( 'color' )
                                <input type="color" class="form-control" name="{{ Str::slug($field->name) }}" value="{{ $value }}">
                                @break

                                @case( 'date' )
                                <input type="date" class="form-control" name="{{ Str::slug($field->name) }}" value="{{ $value }}">
                                @break

                                @case( 'select' )
                                <select name="{{ Str::slug($field->name) }}" class="form-control" id="">
                                    @if ( ! is_null($field->options) ) 
                                    @foreach( json_decode( $field->options ) as $option)
                                        <option value="{{ $option }}" @if($option == $value) selected @endif>{{ $option }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @break

                                @case( 'radio' )
                                <br>
                                @if ( ! is_null($field->options) ) 
                                @foreach( json_decode( $field->options ) as $option)
                                    <input type="radio" name="{{ Str::slug( $field->name ) }}" value="{{ $option }}" @if($option == $value) checked @endif>
                                    <label for="">{{ $option }}</label><br>
                                @endforeach
                                @endif
                                @break

                                @case( 'checkbox' )
                                <br>
                                @if ( ! is_null($field->options) )                                                                 
                                @foreach( json_decode( $field->options ) as $option)
                                    <input type="checkbox" name="{{ Str::slug( $field->name ) }}" value="{{ $option }}" @if($option == $value) checked @endif>
                                    <label for="">{{ $option }}</label><br>
                                @endforeach
                                @endif
                                @break

                                            
                                            
                        @endswitch
                    </div>
                @endforeach
            @endif

            <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                    <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
    
@endsection


@section('scripts')
<script>
    let currently_editing = '';
    $(document).ready(function() {
        
        update_attributes();
        
       $('#add-attribute').click(function() {
            $('#attribute-name').val('');
            $('#attribute-value').val('');
            $('#attribute-name').removeAttr('disabled')
            $('#attribute-edit').val('0');
            $('#attributes-form').css('display', 'block');
       });

       $('#save-attribute').click(function() {
            const attributes = JSON.parse($('#attributes').val());
            if ($('#attribute-edit').val() == '1') {
                attributes.find(attribute => attribute.name == currently_editing ).value = $('#attribute-value').val();
                attributes.find(attribute => attribute.name == currently_editing ).name = $('#attribute-name').val();
            } else {
                attributes.push({
                    name: $('#attribute-name').val(),
                    value: $('#attribute-value').val(),
                    visible: 1,
                    global: 1
                })
            }
            $('#attributes').val(JSON.stringify(attributes));
            update_attributes();
            hide_attributes_form();
            alert('Attribute saved')
        })
    });

    function update_attributes() {
        const attributes = JSON.parse($('#attributes').val());
        let html = '';
        attributes.forEach( attribute => {
            html += `<li class="mb-3">${attribute.name} - <button type="button" class="btn btn-info btn-sm d-inline-block" onclick="edit_attribute( '${attribute.name}', '${attribute.value}' )">Edit</button></li>`;
        } )

        if (attributes.length > 0) {
            $('#attributes-list').css('display', 'block');
            $('#attributes-list').html(html);
        }
    }

    function edit_attribute(name, value) {
        currently_editing = name;
        $('#attribute-name').val(name);
        // $('#attribute-name').attr('disabled', 'disabled');
        $('#attribute-value').val(value);
        $('#attribute-edit').val('1');
        $('#attributes-form').css('display', 'block');
        $('#attributes-form-group')[0].scrollIntoView({
            behavior: "smooth", // or "auto" or "instant"
            block: "start" // or "end"
        });
    }

    function hide_attributes_form() {
        $('#attribute-name').val();
        $('#attribute-value').val();
        $('#attributes-form').css('display', 'none');
    }
</script>
@endsection