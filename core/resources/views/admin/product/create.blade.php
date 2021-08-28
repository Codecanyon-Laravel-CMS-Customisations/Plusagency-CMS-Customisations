@extends('admin.layout')
@section('content')
@php
$type = request()->input('type');
@endphp
<div class="page-header">
    <h4 class="page-title">Add Product</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="#">
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
            <a href="#">Add Product</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title d-inline-block">Add Product</div>
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

                    <form id="ajaxForm" class="" action="{{route('admin.product.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="type" value="{{request()->input('type')}}">

                        {{-- START: Featured Image --}}
                        <div class="form-group">
                            <label for="">Featured Image ** </label>
                            <br>
                            <div class="thumb-preview" id="thumbPreview1">
                                <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="Feature Image">
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
                                                    <iframe id="lfmIframe2" src="{{url('laravel-filemanager')}}?serial=2" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END: slider Part --}}

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Language **</label>
                                    <select id="language" name="language_id" class="form-control">
                                        <option value="" disabled>Select a language</option>
                                        <?php
                                        $current_url = url()->current();
                                        $p_type     = $_GET['type'];
                                        $p_lang     = $_GET['language'];
                                        ?>
                                        @foreach ($langs as $lang)
                                            <?php
                                            $redirect_url   = "$current_url?language=$lang->code&type=$p_type";
                                            ?>
                                        <option data-link="{{ $redirect_url }}" @if($lang->code == $p_lang) selected @endif value="{{$lang->id}}">{{$lang->name}}</option>
                                        @endforeach
                                    </select>
                                    <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Status **</label>
                                    <select class="form-control ltr" name="status">
                                        <option value="" selected disabled>Select a status</option>
                                        <option value="1">Show</option>
                                        <option value="0">Hide</option>
                                    </select>
                                    <p id="errstatus" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Title **</label>
                                    <input type="text" class="form-control" name="title" value="" placeholder="Enter title">
                                    <p id="errtitle" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="category">Category **</label>
                                    <select  class="form-control categoryData" name="category_id" id="category">
                                        <option value="" selected disabled>Select a category</option>
                                        @foreach ($categories->where('menu_level', 1) as $category)
                                            <?php $sub_cat_1        = $categories->where('parent_menu_id', $category->id); ?>
                                            <?php $sub_cat_1_html   = ''; ?>
                                            @foreach ($sub_cat_1 as $sc1)
                                                <?php $sub_cat_1_html   .= '<option data-kids=\'parent'.$sc1->id.'\'  value=\''.$sc1->id.'\'>'.$sc1->name.'</option>'; ?>
                                            @endforeach
                                        <option  data-sub-cats="{!! $sub_cat_1_html !!}" value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <p id="errcategory_id" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="category">Child Category **</label>
                                    <select  class="form-control" name="sub_category_id" id="scategory">
                                        <option value="" selected disabled>Select a category</option>
{{--                                        @foreach ($scategories as $scategroy)--}}
{{--                                        <option  value="{{$scategroy->id}}">{{$scategroy->name}}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                    {{-- <p id="errcategory_id" class="mb-0 text-danger em"></p> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                @if ($type == 'physical')
                                <div class="form-group">
                                    <label for="">Stock Product **</label>
                                    <input type="number" class="form-control ltr" name="stock" value="" placeholder="Enter Product Stock">
                                    <p id="errstock" class="mb-0 text-danger em"></p>
                                </div>
                                @endif
                                @if ($type == 'digital')
                                <div class="form-group">
                                    <label for="">Type **</label>
                                    <select name="file_type" class="form-control" id="fileType">
                                        <option value="upload" selected>File Upload</option>
                                        <option value="link">File Download Link</option>
                                    </select>
                                    <p id="errfile_type" class="mb-0 text-danger em"></p>
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="category">Sub Child Category **</label>
                                    <select  class="form-control" name="sub_child_category_id" id="sscategory">
                                        <option value="" selected disabled>Select a category</option>
                                    </select>
                                    {{-- <p id="errcategory_id" class="mb-0 text-danger em"></p> --}}
                                </div>
                            </div>
                        </div>
                        @if ($type == 'digital')
                        <div class="row">
                            <div class="col-12">
                                <div id="downloadFile" class="form-group">
                                    <label for="">Downloadable File **</label>
                                    <br>
                                    <input name="download_file" type="file">
                                    <p class="mb-0 text-warning">Only zip file is allowed.</p>
                                    <p id="errdownload_file" class="mb-0 text-danger em"></p>
                                </div>
                                <div id="downloadLink" class="form-group" style="display: none">
                                    <label for="">Downloadable Link **</label>
                                    <input name="download_link" type="text" class="form-control">
                                    <p id="errdownload_link" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            @if ($type == 'physical')
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for=""> Product Sku **</label>
                                    <input type="text" class="form-control" name="sku" value="{{rand(1000000,9999999)}}"  placeholder="Enter Product sku">
                                    <p id="errsku" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            @endif
                            <div class="{{$type == 'physical' ? 'col-lg-6' : 'col-12'}}">
                                <div class="form-group">
                                    <label for="">Tags </label>
                                    <input type="text" class="form-control" name="tags" value="" data-role="tagsinput" placeholder="Enter tags">
                                    <p id="errtags" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>

                        @if ($bex->catalog_mode == 0)
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for=""> Current Price (in {{$abx->base_currency_text}}) **</label>
                                        <input type="number" class="form-control ltr" name="current_price" value=""  placeholder="Enter Current Price">
                                        <p id="errcurrent_price" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Previous Price (in {{$abx->base_currency_text}})</label>
                                        <input type="number" class="form-control ltr" name="previous_price" value="" placeholder="Enter Previous Price">
                                        <p id="errprevious_price" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="summary">Summary </label>
                                    <textarea name="summary" id="summary" class="form-control" rows="4" placeholder="Enter Product Summary"></textarea>
                                    <p id="errsummary" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Description </label>
                                    <textarea class="form-control summernote" name="description" placeholder="Enter description" data-height="300"></textarea>
                                    <p id="errdescription" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <input class="form-control" name="meta_keywords" value="" placeholder="Enter meta keywords" data-role="tagsinput">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description"></textarea>
                                </div>
                            </div>
                        </div>

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
                                        <button class="btn btn-success btn-sm" id="save-attribute">Save Atribute</button>
                                    </div>
                                    <ul style="display: none;" id="attributes-list"></ul>
                                </div>
                            </div>
                        </div>

                        <h3>Custom Fields</h3>
                        @if ( ! is_null( $product_fields ) )
                            @foreach ( json_decode( $product_fields ) as $field )
                                <div class="form-group">
                                    <label for="">{{ $field->name }}</label>
                                    @switch( $field->type )
                                        @case( 'text' )
                                            <input type="text" class="form-control" name="{{ Str::slug($field->name) }}">
                                            @break

                                            @case( 'number' )
                                            <input type="number" class="form-control" name="{{ Str::slug($field->name) }}">
                                            @break

                                            @case( 'textarea' )
                                            <textarea name="{{ Str::slug($field->name) }}" id="" cols="30" rows="10" class="form-control"></textarea>
                                            @break

                                            @case( 'color' )
                                            <input type="color" class="form-control" name="{{ Str::slug($field->name) }}">
                                            @break

                                            @case( 'date' )
                                            <input type="date" class="form-control" name="{{ Str::slug($field->name) }}">
                                            @break

                                            @case( 'select' )
                                            <select name="{{ Str::slug($field->name) }}" class="form-control" id="">
                                                @if ( ! is_null(json_decode( $field->options )) )
                                                @foreach( json_decode( $field->options ) as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @break

                                            @case( 'radio' )
                                            <br>
                                            @if ( ! is_null(json_decode( $field->options )) )
                                            @foreach( json_decode( $field->options ) as $option)
                                                <input type="radio" name="{{ Str::slug( $field->name ) }}" value="{{ $option }}">
                                                <label for="">{{ $option }}</label><br>
                                            @endforeach
                                            @endif
                                            @break

                                            @case( 'checkbox' )
                                            <br>
                                            @if ( ! is_null(json_decode( $field->options )) )
                                            @foreach( json_decode( $field->options ) as $option)
                                                <input type="checkbox" name="{{ Str::slug( $field->name ) }}" value="{{ $option }}">
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
                        <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
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
                $sub_cat_2_html   .= '<option  value=\''.$sc2->id.'\'>'.$sc2->name.'</option>';
            }
            echo "\"parent$kids->id\" : \"$sub_cat_2_html\", ";
        }
        echo "
                }; ";
        ?>
    </script>
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

@if($type == 'digital')
<script>
    $(document).ready(function() {
        $("select[name='file_type']").on('change', function() {
            let type = $(this).val();
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
        });
    });
</script>
@endif


<script>
    $(document).ready(function() {
        // services load according to language selection
        $("select[name='language_id']").on('change', function() {

            $("#category").removeAttr('disabled');

            //let langid = $(this).val();
            let url = $("select[name='language_id']").find("option:selected").attr('data-link');
            window.location.assign(url);
            // console.log(url);
            $.get(url, function(data) {
                // console.log(data);
                document.open();
                document.write(data);
                document.close();
                // let options = `<option value="" disabled selected>Select a category</option>`;
                // for (let i = 0; i < data.length; i++) {
                //     options += `<option value="${data[i].id}">${data[i].name}</option>`;
                // }
                //
                // $(".categoryData").html(options);

            });
        });


        $("select[name='language_id']").on('change', function() {
            $(".request-loader").addClass("show");
            let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
            console.log(url);
            $.get(url, function(data) {
                $(".request-loader").removeClass("show");
                if (data == 1) {
                    $("form input").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form select").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form textarea").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form .summernote").each(function() {
                        $(this).siblings('.note-editor').find('.note-editable').addClass('rtl text-right');
                    });
                } else {
                    $("form input, form select, form textarea").removeClass('rtl');
                    $("form .summernote").siblings('.note-editor').find('.note-editable').removeClass('rtl text-right');
                }
            })
        });

        // translatable portfolios will be available if the selected language is not 'Default'
        $("#language").on('change', function() {
            let language = $(this).val();
            // console.log(language);
            if (language == 0) {
                $("#translatable").attr('disabled', true);
            } else {
                $("#translatable").removeAttr('disabled');
            }
        });
    });

    var today = new Date();
    $("#submissionDate").datepicker({
        autoclose: true,
        endDate : today,
        todayHighlight: true
    });
    $("#startDate").datepicker({
        autoclose: true,
        endDate : today,
        todayHighlight: true
    });
</script>
@endsection
