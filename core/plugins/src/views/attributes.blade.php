@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Global Product Attributes</h3>
    </div>
    <div class="card-body">
        @if ( ! is_null( $product_attributes ) )
            @foreach( json_decode( $product_attributes ) as $attribute )
                <p>{{ $attribute->name }} - 
                    <a href="{{ route( 'plugins.attributes.edit', [ 'attribute' => $attribute->name, 'language' => 'en' ] ) }}" class="btn btn-info btn-sm d-inline-block mr-3 ml-3">Edit</a> 
                    <a href="{{ route( 'plugins.attributes.destroy', [ 'attribute' => $attribute->name, 'language' => 'en' ] ) }}" class="btn btn-danger btn-sm">Delete</a> </p>
            @endforeach
        @endif

       <form action="{{ route( 'plugins.attributes.store' ) }}" method="post">
           @csrf
           <input type="hidden" name="language" value="en">
           <div class="row">
            <div class="col-lg-12">
                <div class="form-group" id="attributes-form-group">
                    <label for="">Product Attributes</label>
                    <input type="hidden" name="attributes" id="attributes" value="">
                    <button type="button" class="btn btn-warning btn-sm mb-3" id="add-attribute">Add Attribute</button>
                    <div id="attributes-form" class="form-group" style="display: none;">
                        <input type="hidden" name="edit" value="hidden" id="attribute-edit">
                        <input type="text" class="form-control" id="attribute-name" placeholder="Attribute Name">
                        <input type="text" class="form-control" id="attribute-value" placeholder="Attribute Value">
                        <button type="button" class="btn btn-success btn-sm" id="save-attribute">Save Atribute</button>
                    </div>
                    <ul style="display: none;" id="attributes-list"></ul>
                </div>
            </div>
        </div>
        <div class="form-goup">
            <button type="submit" class="btn btn-success">Save All Attributes</button>
        </div>
       </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currently_editing = '';
    $(document).ready(function() {
        
        // update_attributes();
        
       $('#add-attribute').click(function() {
            $('#attribute-name').val('');
            $('#attribute-value').val('');
            $('#attribute-name').removeAttr('disabled')
            $('#attribute-edit').val('0');
            $('#attributes-form').css('display', 'block');
       });

       $('#save-attribute').click(function() {
        let attributes = [];
           if ($('#attributes').val() != '') {
               attributes = JSON.parse($('#attributes').val());
           }
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