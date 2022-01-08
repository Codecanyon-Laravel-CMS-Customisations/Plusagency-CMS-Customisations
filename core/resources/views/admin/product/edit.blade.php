@extends('admin.layout')

@if(!empty($data->language) && $data->language->rtl == 1)
@section('styles')
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    .nicEdit-main {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
<div class="page-header">
    <h4 class="page-title">Edit Product</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{route('admin.dashboard')}}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Shop Management</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Manage Products</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Products</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Edit Product</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title d-inline-block">Edit Product</div>
                <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.product.index') . '?language=' . request()->input('language')}}">
                    <span class="btn-label">
                        <i class="fas fa-backward" style="font-size: 12px;"></i>
                    </span>
                    Back
                </a>
            </div>
            <div class="card-body pt-5 pb-5">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">

                    {{-- Featured image upload end --}}
                    <form id="ajaxForm" class="" action="{{route('admin.product.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden"  name="product_id" value="{{$data->id}}">

                        {{-- START: Featured Image --}}
                        <div class="form-group">
                            <label for="">Featured Image ** </label>
                            <br>
                            <div class="thumb-preview" id="thumbPreview1">
                                <img src="{{trim($data->feature_image)}}" alt="Feature Image">
                            </div>
                            <br>
                            <br>


                            <input id="fileInput1" type="hidden" name="featured_image">
                            <button id="chooseImage1" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal1">Choose Image</button>


                            <p class="text-warning mb-0">JPG, PNG, JPEG images are allowed</p>
                            <p id="errfeatured_image" class="mb-0 text-danger em"></p>

                            <!-- Featured Image LFM Modal -->
                            <div class="modal fade lfm-modal" id="lfmModal1" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
                                <i class="fas fa-times-circle"></i>
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <iframe src="{{url('laravel-filemanager')}}?serial=1" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END: Featured Image --}}

                        {{-- START: slider Part --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Slider Images ** </label>
                                    <br>
                                    <div class="slider-thumbs" id="sliderThumbs2">

                                    </div>

                                    <input id="fileInput2" type="hidden" name="slider" value="" />
                                    <button id="chooseImage2" class="choose-image btn btn-primary" type="button" data-multiple="true" data-toggle="modal" data-target="#lfmModal2">Choose Images</button>


                                    <p class="text-warning mb-0">JPG, PNG, JPEG images are allowed</p>
                                    <p id="errslider" class="mb-0 text-danger em"></p>

                                    <!-- slider LFM Modal -->
                                    <div class="modal fade lfm-modal" id="lfmModal2" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
                                        <i class="fas fa-times-circle"></i>
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <iframe id="lfmIframe2" src="{{url('laravel-filemanager')}}?serial=2&product={{$data->id}}" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END: slider Part --}}

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Title **</label>
                                    <input type="text" class="form-control" name="title"  placeholder="Enter title" value="{{$data->title}}">
                                    <p id="errtitle" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Slug **</label>
                                    <input type="text" class="form-control" name="title"  placeholder="Enter Slug" value="{{$data->slug}}">
                                    <p id="errtitle" class="mb-0 text-danger em"></p>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Status **</label>
                                    <select class="form-control ltr" name="status">
                                        <option value="" selected disabled>Select a status</option>
                                        <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Show</option>
                                        <option value="0" {{$data->status == 0 ? 'selected' : ''}}>Hide</option>
                                    </select>
                                    <p id="errstatus" class="mb-0 text-danger em"></p>
                                </div>
                                @if ($data->type == 'physical')
                                    <div class="form-group">
                                        <label for="">Stock Product **</label>
                                        <input type="number" class="form-control ltr" name="stock"  placeholder="Enter Product Stock" value="{{$data->stock}}">
                                        <p id="errstock" class="mb-0 text-danger em"></p>
                                    </div>
                                @endif
                                @if ($data->type == 'digital')
                                    <div class="form-group">
                                        <label for="">Type **</label>
                                        <select name="file_type" class="form-control" id="fileType" onchange="toggleFileUpload();">
                                            <option value="upload" {{!empty($data->download_file) ? 'selected' : ''}}>File Upload</option>
                                            <option value="link" {{!empty($data->download_link) ? 'selected' : ''}}>File Download Link</option>
                                        </select>
                                        <p id="errfile_type" class="mb-0 text-danger em"></p>
                                    </div>
                                @endif
                                @if ($data->type == 'digital')
                                    <div class="form-group">
                                        <div id="downloadFile" class="form-group">
                                            <label for="">Downloadable File **</label>
                                            <br>
                                            <input name="download_file" type="file">
                                            <p class="mb-0 text-warning">Only zip file is allowed.</p>
                                            <p id="errdownload_file" class="mb-0 text-danger em"></p>
                                        </div>
                                        <div id="downloadLink" class="form-group" style="display: none">
                                            <label for="">Downloadable Link **</label>
                                            <input name="download_link" type="text" class="form-control" value="{{$data->download_link}}">
                                            <p id="errdownload_link" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="category">Category **</label>
                                    <select  class="form-control categoryData" name="category_id" id="category">
                                        <option value="" selected disabled>Select a category</option>
{{--                                        @foreach ($categories as $categroy)--}}
{{--                                            @if($categroy->is_child) @continue @endif--}}
{{--                                            <option value="{{$categroy->id}}" {{$data->category_id == $categroy->id ? 'selected' : ''}}>{{$categroy->name}}</option>--}}
{{--                                        @endforeach--}}
                                        @foreach ($categories->where('menu_level', 1) as $category)
                                            <?php $sub_cat_1        = $categories->where('parent_menu_id', $category->id); ?>
                                            <?php $sub_cat_1_html   = ''; ?>
                                            @foreach ($sub_cat_1 as $sc1)
                                                <?php $sc1_select = $data->sub_category_id == $sc1->id ? 'selected' : ''; ?>
                                                <?php $sub_cat_1_html   .= '<option '.$sc1_select.' data-kids=\'parent'.$sc1->id.'\'  value=\''.$sc1->id.'\'>'.$sc1->name.'</option>'; ?>
                                            @endforeach
                                            <option  data-sub-cats="{!! $sub_cat_1_html !!}" value="{{$category->id}}" {{$data->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <p id="errcategory_id" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="category">Child Category **</label>
                                    <select  class="form-control" name="sub_category_id" id="scategory">
                                        <option value="" disabled>Select a category</option>
{{--                                        @foreach ($scategories as $scategroy)--}}
{{--                                        <option value="{{$scategroy->id}}" {{$data->sub_category_id == $scategroy->id ? 'selected' : ''}}>{{$scategroy->name}}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                    {{-- <p id="errcategory_id" class="mb-0 text-danger em"></p> --}}
                                </div>
                                <div class="form-group">
                                    <label for="category">Sub Child Category **</label>
                                    <select  class="form-control" name="sub_child_category_id" id="sscategory">
                                        <option value="" selected disabled>Select a category</option>
                                    </select>
                                    {{-- <p id="errcategory_id" class="mb-0 text-danger em"></p> --}}
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            @if ($data->type == 'physical')
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for=""> Product Sku **</label>
                                    <input type="text" class="form-control ltr" name="sku"  placeholder="Enter Product sku" value="{{$data->sku}}">
                                    <p id="errsku" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            @endif
                            <div class="{{$data->type == 'physical' ? 'col-lg-6' : 'col-lg-12'}}">
                                <div class="form-group">
                                    <label for="">Tags </label>
                                    <input type="text" class="form-control" name="tags" value="{{$data->tags}}" data-role="tagsinput" placeholder="Enter tags">
                                    <p id="errtags" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>

                        @if ($bex->catalog_mode == 0)

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for=""> Current Price (in {{$abx->base_currency_text}}) **</label>
                                        <input type="number" class="form-control ltr" name="current_price" value="{{$data->current_price}}"  placeholder="Enter Current Price">
                                        <p id="errcurrent_price" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Previous Price (in {{$abx->base_currency_text}})</label>
                                        <input type="number" class="form-control ltr" name="previous_price" value="{{$data->previous_price}}" placeholder="Enter Previous Price">
                                        <p id="errprevious_price" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="summary">Summary</label>
                                    <textarea name="summary" id="summary" class="form-control" rows="4" placeholder="Enter Product Summary">{{$data->summary}}</textarea>
                                    <p id="errsubmission_date" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea class="form-control summernote" name="description" placeholder="Enter description" data-height="300">{{replaceBaseUrl($data->description)}}</textarea>
                                    <p id="errdescription" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <input class="form-control" name="meta_keywords" value="{{$data->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$data->meta_description}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="attributes-form-group">
                                    <label for="">Product Attributes</label>
                                    <input type="hidden" name="attributes" id="attributes" value="{{ $data->attributes }}">
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
                                $fields = collect(json_decode( $data->custom_fields ));
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
                                            <input type="text" class="form-control" name="{{ Str::slug($field->name) }}" value="{{ $value ? $value : '' }}">
                                            @break

                                            @case( 'number' )
                                            <input type="number" class="form-control" name="{{ Str::slug($field->name) }}" value="{{ $value ? $value : 0 }}">
                                            @break

                                            @case( 'textarea' )
                                            <textarea name="{{ Str::slug($field->name) }}" id="" cols="30" rows="10" class="form-control">{{ $value ? $value : '' }}</textarea>
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
                    </form>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form">
                <div class="form-group from-show-notify row">
                    <div class="col-12 text-center">
                        <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

@endsection


@section('scripts')

    <script>
        var category    = $('select[name="category_id"]');
        var subCategory1= $('select[name="sub_category_id"]');
        var subCategory2= $('select[name="sub_child_category_id"]');

        category.on('change', function () {
            if (category.find('option:selected').attr('data-sub-cats') != 'undefined' || category.find('option:selected').attr('data-sub-cats') != undefined){
                subCategory1.html(category.find('option:selected').attr('data-sub-cats'));
            }
        });
        subCategory1.on('change', function () {
            var p   = subCategory1.find('option:selected').attr('data-kids');
            if (p != 'undefined' || p != undefined){
                subCategory2.html(kids[p]);
            }
        });

        <?php
        echo "var kids = {";
        foreach ($categories->where('menu_level', 2) as $kids)
        {
            $sub_cat_2        = $categories->where('parent_menu_id', $kids->id);
            $sub_cat_2_html   = count($sub_cat_2) >= 1 ? '<option value=\'\' selected disabled>Select a category</option>' :  '<option value=\'\' selected disabled>No categories found</option>';
            foreach ($sub_cat_2 as $sc2)
            {
                $kids_select    = $data->sub_child_category_id == $sc2->id ? 'selected' : '';
                $sub_cat_2_html   .= '<option '.$kids_select.'  value=\''.$sc2->id.'\'>'.$sc2->name.'</option>';
            }
            echo "\"parent$kids->id\" : \"$sub_cat_2_html\", ";
        }
        echo "
                }; ";
        ?>

        $(document).ready(function() {
            if (category.find('option:selected').attr('data-sub-cats') != 'undefined' || category.find('option:selected').attr('data-sub-cats') != undefined){
                subCategory1.html(category.find('option:selected').attr('data-sub-cats'));
            }
            var p   = subCategory1.find('option:selected').attr('data-kids');
            if (p != 'undefined' || p != undefined){
                subCategory2.html(kids[p]);
            }
        });
    </script>

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

@if($data->type == 'digital')
<script>
    function toggleFileUpload() {
        let type = $("select[name='file_type']").val();
        if (type == 'link') {
            $("#downloadFile input").attr('disabled', true);
            $("#downloadFile").hide();
            $("#downloadLink").show();
            $("#downloadLink input").removeAttr('disabled');
        } else {
            $("#downloadLink input").attr('disabled', true);
            $("#downloadLink").hide();
            $("#downloadFile").show();
            $("#downloadFile input").removeAttr('disabled');
        }
    }

    $(document).ready(function() {
        toggleFileUpload();
        const attributes = JSON.parse($('#attributes').val());
        console.log(attributes);
    });
</script>
@endif

{{-- dropzone --}}
<script>
    // myDropzone is the configuration for the element that has an id attribute
    // with the value my-dropzone (or myDropzone)
    Dropzone.options.myDropzone = {
        acceptedFiles: '.png, .jpg, .jpeg',
        url: "",
        success : function(file, response){
            console.log(response.file_id);

            // Create the remove button
            var removeButton = Dropzone.createElement("<button class='rmv-btn'><i class='fa fa-times'></i></button>");


            // Capture the Dropzone instance as closure.
            var _this = this;

            // Listen to the click event
            removeButton.addEventListener("click", function(e) {
                // Make sure the button click doesn't submit the form:
                e.preventDefault();
                e.stopPropagation();

                _this.removeFile(file);

                rmvimg(response.file_id);
            });

            // Add the button to the file preview element.
            file.previewElement.appendChild(removeButton);

            var content = {};

            content.message = 'Slider images added successfully!';
            content.title = 'Success';
            content.icon = 'fa fa-bell';

            $.notify(content,{
                type: 'success',
                placement: {
                    from: 'top',
                    align: 'right'
                },
                time: 1000,
                delay: 0,
            });
        }
    };

    function rmvimg(fileid) {
        // If you want to the delete the file on the server as well,
        // you can do the AJAX request here.

        $.ajax({
            url: "",
            type: 'POST',
            data: {
                _token: "{{csrf_token()}}",
                fileid: fileid
            },
            success: function(data) {
                var content = {};

                content.message = 'Slider image deleted successfully!';
                content.title = 'Success';
                content.icon = 'fa fa-bell';

                $.notify(content,{
                    type: 'success',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    time: 1000,
                    delay: 0,
                });
            }
        });

    }
</script>


<script>
    var el = 0;

    $(document).ready(function(){
        $.get("{{route('admin.product.images', $data->id)}}", function(data){
            for (var i = 0; i < data.length; i++) {
                $("#imgtable").append('<tr class="trdb" id="trdb'+data[i].id+'"><td><div class="thumbnail"><img style="width:150px;" src="'+data[i].image+'" alt="Ad Image"></div></td><td><button type="button" class="btn btn-danger pull-right rmvbtndb" onclick="rmvdbimg('+data[i].id+')"><i class="fa fa-times"></i></button></td></tr>');
            }
        });
    });

    function rmvdbimg(indb) {
        $(".request-loader").addClass("show");
        $.ajax({
            url: "",
            type: 'POST',
            data: {
                _token: "{{csrf_token()}}",
                fileid: indb
            },
            success: function(data) {
                $(".request-loader").removeClass("show");
                $("#trdb"+indb).remove();
                var content = {};

                content.message = 'Slider image deleted successfully!';
                content.title = 'Success';
                content.icon = 'fa fa-bell';

                $.notify(content,{
                    type: 'success',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    time: 1000,
                    delay: 0,
                });
            }
        });

    }


</script>

@endsection
