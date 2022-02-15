@extends('admin.layout')

@section('styles')
    <link href="{{ asset('assets/front/magiczoomplus-trial/magiczoomplus/magiczoomplus.css') }}" rel="stylesheet"
        type="text/css" media="screen" />
    <script src="{{ asset('assets/front/magiczoomplus-trial/magiczoomplus/magiczoomplus.js') }}" type="text/javascript">
    </script>

    <style type="text/css">
        html {
            position: relative;
            min-height: 100%;
        }

        body {
            position: absolute;
            left: 0;
            right: 0;
            min-height: 100%;
            background: #fff;
            margin: 0;
            padding: 0;
            font-size: 100%;
        }

        body,
        td {
            font-family: 'Helvetica Neue', Helvetica, 'Lucida Grande', Tahoma, Arial, Verdana, sans-serif;
            line-height: 1.5em;
            -webkit-text-rendering: geometricPrecision;
            text-rendering: geometricPrecision;
        }

        h1 {
            font-size: 1.5em;
            font-weight: normal;
            color: #555;
        }

        h2 {
            font-size: 1.3em;
            font-weight: normal;
            color: #555;
        }

        h2.caption {
            margin: 2.5em 0 0;
        }

        h3 {
            font-size: 1.1em;
            font-weight: normal;
            color: #555;
        }

        h3.pad {
            margin: 2em 0 1em;
        }

        h4 {
            font-size: 1em;
            font-weight: normal;
            color: #555;
        }

        p.pad {
            margin-top: 1.5em;
        }

        a {
            outline: none;
        }


        .cfg-btn {
            background-color: rgb(55, 181, 114);
            color: #fff;
            border: 0;
            box-shadow: 0 0 1px 0px rgba(0, 0, 0, 0.3);
            outline: 0;
            cursor: pointer;
            width: 200px;
            padding: 10px;
            font-size: 1em;
            position: relative;
            display: inline-block;
            margin: 10px auto;
        }

        .cfg-btn:hover:not([disabled]) {
            background-color: rgb(37, 215, 120);
        }

        .mobile-magic .cfg-btn:hover:not([disabled]) {
            background: rgb(55, 181, 114);
        }

        .cfg-btn[disabled] {
            opacity: .5;
            color: #808080;
            background: #ddd;
        }

        .cfg-btn.btn-preview,
        .cfg-btn.btn-preview:active,
        .cfg-btn.btn-preview:focus {
            font-size: 1em;
            position: relative;
            display: block;
            margin: 10px auto;
        }

        .preview,
        .wizard-settings {
            padding: 10px;
            border: 0;
            min-height: 1px;
        }

        .preview {
            position: relative;
        }

        .api-controls {
            text-align: center;
        }

        .api-controls button,
        .api-controls button:active,
        .api-controls button:focus {
            width: 80px;
            font-size: .7em;
            white-space: nowrap;
        }

        .app-figure {
            width: 80% !important;
            margin: 0px auto;
            border: 0px solid red;
            padding: 20px;
            position: relative;
            text-align: center;
        }

        .selectors {
            margin-top: 10px;
        }

        .selectors .mz-thumb img {
            max-width: 56px;
        }

        .app-code-sample {
            max-width: 80%;
            margin: 30px auto 0;
            text-align: center;
            position: relative;
        }

        .app-code-sample input[type="radio"] {
            display: none;
        }

        .app-code-sample label {
            display: inline-block;
            padding: 2px 12px;
            margin: 0;
            font-size: .8em;
            text-decoration: none;
            cursor: pointer;
            color: #666;
            border: 1px solid rgba(136, 136, 136, 0.5);
            background-color: transparent;
        }

        .app-code-sample label:hover {
            color: #fff;
            background-color: rgb(253, 154, 30);
            border-color: rgb(253, 154, 30);
        }

        .app-code-sample input[type="radio"]:checked+label {
            color: #fff;
            background-color: rgb(110, 110, 110) !important;
            border-color: rgba(110, 110, 110, 0.7) !important;
        }

        .app-code-sample label:first-of-type {
            border-radius: 4px 0 0 4px;
            border-right-color: transparent;
        }

        .app-code-sample label:last-of-type {
            border-radius: 0 4px 4px 0;
            border-left-color: transparent;
        }

        .app-code-sample .app-code-holder {
            padding: 0;
            position: relative;
            border: 1px solid #eee;
            border-radius: 0px;
            background-color: #fafafa;
            margin: 15px 0;
        }

        .app-code-sample .app-code-holder>div {
            display: none;
        }

        .app-code-sample .app-code-holder pre {
            text-align: left;
            white-space: pre-line;
            border: 0px solid #eee;
            border-radius: 0px;
            background-color: transparent;
            padding: 25px 50px 25px 25px;
            margin: 0;
            min-height: 25px;
        }

        .app-code-sample input[type="radio"]:nth-of-type(1):checked~.app-code-holder>div:nth-of-type(1) {
            display: block;
        }

        .app-code-sample input[type="radio"]:nth-of-type(2):checked~.app-code-holder>div:nth-of-type(2) {
            display: block;
        }

        .app-code-sample .app-code-holder .cfg-btn-copy {
            display: none;
            z-index: -1;
            position: absolute;
            top: 10px;
            right: 10px;
            width: 44px;
            font-size: .65em;
            white-space: nowrap;
            margin: 0;
            padding: 4px;
        }

        .copy-msg {
            font: normal 11px/1.2em 'Helvetica Neue', Helvetica, 'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, sans-serif;
            color: #2a4d14;
            border: 1px solid #2a4d14;
            border-radius: 4px;
            position: absolute;
            top: 8px;
            left: 0;
            right: 0;
            width: 200px;
            max-width: 70%;
            padding: 4px;
            margin: 0px auto;
            text-align: center;
        }

        .copy-msg-failed {
            color: #b80c09;
            border-color: #b80c09;
            width: 430px;
        }

        .mobile-magic .app-code-sample .cfg-btn-copy {
            display: none;
        }

        #code-to-copy {
            position: absolute;
            width: 0;
            height: 0;
            top: -10000px;
        }

        .lt-ie9-magic .app-code-sample {
            display: none;
        }

        .wizard-settings {
            background-color: #4f4f4f;
            color: #a5a5a5;
            /* position: absolute; */
            right: 0;
            /* width: 340px; */
            position: relative;
        }

        .wizard-settings .inner {
            width: 100%;
            margin-bottom: 30px;
        }

        .wizard-settings a {
            color: #cc9933;
        }

        .wizard-settings a:hover {
            color: #dfb363;
        }

        .wizard-settings table>tbody>tr>td {
            vertical-align: top;
        }

        .wizard-settings table {
            min-width: 300px;
            max-width: 100%;
            font-size: .8em;
            margin: 0 auto;
        }

        .wizard-settings table caption {
            font-size: 1.5em;
            padding: 16px 8px;
        }

        .wizard-settings table td {
            padding: 4px 8px;
        }

        .wizard-settings table td:first-child {
            white-space: nowrap;
        }

        .wizard-settings table td:nth-child(2) {
            text-align: left;
        }

        .wizard-settings table td .values {
            color: #a08794;
            font-size: 0.8em;
            line-height: 1.3em;
            display: block;
            max-width: 126px;
        }

        .wizard-settings table td .values:before {
            content: '';
            display: block;
        }

        .wizard-settings input,
        .wizard-settings select {
            width: 126px;
        }

        .wizard-settings input {
            padding: 0px 4px;
        }

        .wizard-settings input[disabled] {
            color: #808080;
            background: #a7a7a7;
            border: 1px solid #a7a7a7;
        }

        @media screen and (max-width: 1024px) {

            .api-controls button,
            .api-controls button:active,
            .api-controls button:focus {
                width: 70px;
            }
        }

        @media screen and (max-width: 1023px) {
            .app-figure {
                width: 98% !important;
                margin: 50px auto;
                padding: 0;
            }

            .app-code-sample {
                display: none;
            }

            .wizard-settings {
                width: 100%;
            }
        }

        @media screen and (max-width: 600px) {
            .mz-thumb img {
                max-width: 39px;
            }
        }

        @media screen and (max-width: 560px) {
            .api-controls .sep {
                content: '';
                display: table;
            }
        }

        @media screen and (min-width: 1600px) {
            .preview {
                padding: 10px 160px;
            }
        }

        #app-params-form caption {
            caption-side: top !important;
        }

    </style>

    <script type="text/javascript">
        var mzOptions = {};
        mzOptions = {
            onZoomReady: function() {
                console.log('onReady', arguments[0]);
            },
            onUpdate: function() {
                console.log('onUpdated', arguments[0], arguments[1], arguments[2]);
            },
            onZoomIn: function() {
                console.log('onZoomIn', arguments[0]);
            },
            onZoomOut: function() {
                console.log('onZoomOut', arguments[0]);
            },
            onExpandOpen: function() {
                console.log('onExpandOpen', arguments[0]);
            },
            onExpandClose: function() {
                console.log('onExpandClosed', arguments[0]);
            }
        };
        var mzMobileOptions = {};

        function isDefaultOption(o) {
            return magicJS.$A(magicJS.$(o).byTag('option')).filter(function(opt) {
                return opt.selected && opt.defaultSelected;
            }).length > 0;
        }

        function toOptionValue(v) {
            if (/^(true|false)$/.test(v)) {
                return 'true' === v;
            }
            if (/^[0-9]{1,}$/i.test(v)) {
                return parseInt(v, 10);
            }
            return v;
        }

        function makeOptions(optType) {
            var value = null,
                isDefault = true,
                newParams = Array(),
                newParamsS = '',
                options = {};
            magicJS.$(magicJS.$A(magicJS.$(optType).getElementsByTagName("INPUT"))
                    .concat(magicJS.$A(magicJS.$(optType).getElementsByTagName('SELECT'))))
                .forEach(function(param) {
                    value = ('checkbox' == param.type) ? param.checked.toString() : param.value;

                    isDefault = ('checkbox' == param.type) ? value == param.defaultChecked.toString() :
                        ('SELECT' == param.tagName) ? isDefaultOption(param) : value == param.defaultValue;

                    // if ( null !== value && !isDefault) {
                    options[param.name] = toOptionValue(value);
                    // }
                });
            return options;
        }

        function updateScriptCode() {
            var code = '&lt;script&gt;\nvar mzOptions = ';
            code += JSON.stringify(mzOptions, null, 2).replace(/\"(\w+)\":/g, "$1:") + ';';
            code += '\n&lt;/script&gt;';

            magicJS.$('app-code-sample-script').changeContent(code);
        }

        function updateInlineCode() {
            var code = '&lt;a class="MagicZoom" data-options="';
            code += JSON.stringify(mzOptions).replace(/\"(\w+)\":(?:\"([^"]+)\"|([^,}]+))(,)?/g, "$1: $2$3; ").replace(
                /\{([^{}]*)\}/, "$1").replace(/\s*$/, '');
            code += '"&gt;';

            magicJS.$('app-code-sample-inline').changeContent(code);
        }

        function applySettings(submit = false) {
            MagicZoom.stop('Zoom-1');
            mzOptions = makeOptions('params');
            mzMobileOptions = makeOptions('mobile-params');
            MagicZoom.start('Zoom-1');
            updateScriptCode();
            updateInlineCode();

            MagicZoom.refresh('Zoom-1');

            try {
                prettyPrint();
            } catch (e) {}

            if (submit) {
                //submit data
                var abh_sf = $('#submit-magic-options');
                abh_sf.find('input[name="desktop_options"]').val(JSON.stringify(mzOptions));
                abh_sf.find('input[name="mobile_options"]').val(JSON.stringify(mzMobileOptions));
                abh_sf.submit();
                // console.log(mzOptions, mzMobileOptions);
            }
        }

        function copyToClipboard(src) {
            var
                copyNode,
                range, success;

            if (!isCopySupported()) {
                disableCopy();
                return;
            }
            copyNode = document.getElementById('code-to-copy');
            copyNode.innerHTML = document.getElementById(src).innerHTML;

            range = document.createRange();
            range.selectNode(copyNode);
            window.getSelection().addRange(range);

            try {
                success = document.execCommand('copy');
            } catch (err) {
                success = false;
            }
            window.getSelection().removeAllRanges();
            if (!success) {
                disableCopy();
            } else {
                new magicJS.Message('Settings code copied to clipboard.', 3000,
                    document.querySelector('.app-code-holder'), 'copy-msg');
            }
        }

        function disableCopy() {
            magicJS.$A(document.querySelectorAll('.cfg-btn-copy')).forEach(function(node) {
                node.disabled = true;
            });
            new magicJS.Message('Sorry, cannot copy settings code to clipboard. Please select and copy code manually.',
                3000,
                document.querySelector('.app-code-holder'), 'copy-msg copy-msg-failed');
        }

        function isCopySupported() {
            if (!window.getSelection || !document.createRange || !document.queryCommandSupported) {
                return false;
            }
            return document.queryCommandSupported('copy');
        }
    </script>
@endsection

@section('content')
    <div class="page-header">
        <h4 class="page-title">Magic Zoom Settings</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Settings</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Magic Zoom</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form id="submit-magic-options" action="{{ route('admin.magic-zoom.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="desktop_options" value="">
                    <input type="hidden" name="mobile_options" value="">
                </form>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="preview col">
                                <div class="api-controls">
                                    <button class="cfg-btn" onclick="MagicZoom.start('Zoom-1')">Start</button>
                                    <button class="cfg-btn" onclick="MagicZoom.stop('Zoom-1')">Stop</button>
                                    <button class="cfg-btn" onclick="MagicZoom.refresh('Zoom-1')">Refresh</button>
                                    <button class="cfg-btn" onclick="MagicZoom.prev('Zoom-1')">Prev</button>
                                    <button class="cfg-btn" onclick="MagicZoom.next('Zoom-1')">Next</button>
                                    <button class="cfg-btn" onclick="MagicZoom.zoomIn('Zoom-1')">Zoom In</button>
                                    <button class="cfg-btn" onclick="MagicZoom.zoomOut('Zoom-1')">Zoom Out</button>
                                    <button class="cfg-btn" onclick="MagicZoom.expand('Zoom-1')"
                                        title="Plus version only.">Expand</button>
                                </div>

                                <div class="app-figure" id="zoom-fig">
                                    <a id="Zoom-1" class="MagicZoom"
                                        title="Show your product in stunning detail with Magic Zoom Plus."
                                        href="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=1400"
                                        data-zoom-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=2800"
                                        data-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=800">
                                        <img src="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=400"
                                            srcset="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=800 2x"
                                            alt="" />
                                    </a>
                                    <div class="selectors">
                                        <a data-zoom-id="Zoom-1"
                                            href="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=1400"
                                            data-image="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=400"
                                            data-zoom-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=2800"
                                            data-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=800">
                                            <img srcset="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=120 2x"
                                                src="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-1.jpg?h=60" />
                                        </a>
                                        <a data-zoom-id="Zoom-1"
                                            href="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-2.jpg?h=1400"
                                            data-image="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-2.jpg?h=400"
                                            data-zoom-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-2.jpg?h=2800"
                                            data-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-2.jpg?h=800">
                                            <img srcset="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-2.jpg?h=120 2x"
                                                src="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-2.jpg?h=60" />
                                        </a>
                                        <a data-zoom-id="Zoom-1"
                                            href="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-3.jpg?h=1400"
                                            data-image="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-3.jpg?h=400"
                                            data-zoom-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-3.jpg?h=2800"
                                            data-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-3.jpg?h=800">
                                            <img srcset="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-3.jpg?h=120 2x"
                                                src="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-3.jpg?h=60" />
                                        </a>
                                        <a data-zoom-id="Zoom-1"
                                            href="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-4.jpg?h=1400"
                                            data-image="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-4.jpg?h=400"
                                            data-zoom-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-4.jpg?h=2800"
                                            data-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-4.jpg?h=800">
                                            <img srcset="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-4.jpg?h=120 2x"
                                                src="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-4.jpg?h=60" />
                                        </a>
                                        <a data-zoom-id="Zoom-1"
                                            href="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-5.jpg?h=1400"
                                            data-image="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-5.jpg?h=400"
                                            data-zoom-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-5.jpg?h=2800"
                                            data-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-5.jpg?h=800">
                                            <img srcset="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-5.jpg?h=120 2x"
                                                src="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-5.jpg?h=60" />
                                        </a>
                                        <a data-zoom-id="Zoom-1"
                                            href="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-6.jpg?h=1400"
                                            data-image="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-6.jpg?h=400"
                                            data-zoom-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-6.jpg?h=2800"
                                            data-image-2x="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-6.jpg?h=800">
                                            <img srcset="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-6.jpg?h=120 2x"
                                                src="https://magictoolbox.sirv.com/images/magiczoomplus/colorful-colors-6.jpg?h=60" />
                                        </a>
                                    </div>
                                </div>

                                <div class="app-code-sample">
                                    <input type="radio" name="code-sample-nav" id="code-sample-nav-1"
                                        checked="checked"><label for="code-sample-nav-1">Global settings</label><input
                                        type="radio" name="code-sample-nav" id="code-sample-nav-2"><label
                                        for="code-sample-nav-2">Inline settings</label>
                                    <div class="app-code-holder">
                                        <div>
                                            <pre class="prettyprint" id="app-code-sample-script">
                                        &lt;script&gt;
                                        var mzOptions = {};
                                        &lt;/script&gt;
                                    </pre>
                                            <button class="cfg-btn cfg-btn-copy" autocomplete="off"
                                                onclick="copyToClipboard('app-code-sample-script')">Copy</button>
                                        </div>
                                        <div>
                                            <pre class="prettyprint" id="app-code-sample-inline">
                                        &lt;a class="MagicZoom" data-options=""&gt;
                                    </pre>
                                            <button class="cfg-btn cfg-btn-copy" autocomplete="off"
                                                onclick="copyToClipboard('app-code-sample-inline')">Copy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="code-to-copy"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="wizard-settings col">
                                <div class="settings-controls text-center">
                                    <button class="cfg-btn-------naaaah btn-preview-----naaah btn btn-dark d-inline-block" form="app-params-form"
                                        autocomplete="off" onclick="applySettings();">
                                        <small><strong> TEST SETTINGS</strong></small>
                                    </button>
                                    <button class="cfg-btn-------naaaah btn-preview-----naaah btn btn-success d-inline-block" form="app-params-form"
                                        autocomplete="off" onclick="applySettings(1);">
                                        <small><strong> SAVE SETTINGS</strong></small>
                                    </button>
                                </div>
                                <div class="inner">
                                    <form id="app-params-form" autocomplete="off" onsubmit="return false;">
                                        @php
                                            $digi_s = (array) json_decode($model->desktop_options);
                                            $mobi_s = (array) json_decode($model->mobile_options);
                                        @endphp
                                        <table id="params">
                                            <caption class="text-white">
                                            <small><strong> General settings</strong></small>
                                            </caption>
                                            @foreach ($d_set as $ds)
                                                @php
                                                    // echo json_encode($ds);
                                                    // echo "<hr/>";
                                                    $default = '';
                                                    $value = '';
                                                    try {
                                                        $default = $ds['default'];
                                                    } catch (\Exception $e) {
                                                    }
                                                    try {
                                                        // $value  = $digi_s;
                                                        $value = $digi_s[$ds['key']];
                                                        // var_dump($value);
                                                        // var_dump($ds['key']);
                                                    } catch (\Exception $e) {
                                                    }
                                                @endphp
                                                {{-- {!! var_dump(json_decode($model->desktop_options)) !!} --}}
                                                <tr>
                                                    <td>{{ isset($ds['key']) ? $ds['key'] : '---' }}</td>
                                                    <td>
                                                        @if (isset($ds['options']) && is_array($ds['options']))
                                                            <select
                                                                name="{{ isset($ds['key']) ? $ds['key'] : rand(77, 777) }}">
                                                                @foreach ($ds['options'] as $dso)
                                                                    <option value="{{ $dso }}"
                                                                        @if ($value == $dso) selected @elseif($default == $dso) selected @elseif($loop->first) selected @endif>{{ $dso }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <input type="{{ $ds['type'] }}"
                                                                name="{{ isset($ds['key']) ? $ds['key'] : rand(77, 777) }}"
                                                                value="{{ trim($value) != '' ? $value : $default }}">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>

                                        <table id="mobile-params">
                                            <caption class="text-white">
                                                <small><strong>Special settings for mobile</strong></small>
                                            </caption>
                                            @foreach ($m_set as $ms)
                                                @php
                                                    $default = '';
                                                    $value = '';
                                                    try {
                                                        $default = $ms['default'];
                                                    } catch (\Exception $e) {
                                                    }
                                                    try {
                                                        $value = $mobi_s[$ms['key']];
                                                    } catch (\Exception $e) {
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ isset($ms['key']) ? $ms['key'] : '---' }}</td>
                                                    <td>
                                                        @if (isset($ms['options']) && is_array($ms['options']))
                                                            <select
                                                                name="{{ isset($ms['key']) ? $ms['key'] : rand(77, 777) }}">
                                                                @foreach ($ms['options'] as $mso)
                                                                    <option value="{{ $mso }}"
                                                                        @if ($value == $mso) selected @elseif($default == $mso) selected @elseif($loop->first) selected @endif>{{ $mso }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <input type="{{ $ms['type'] }}"
                                                                name="{{ isset($ms['key']) ? $ms['key'] : rand(77, 777) }}"
                                                                value="{{ trim($value) != '' ? $value : $default }}">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prettify/188.0.0/prettify.min.js"></script>
    <script>
        try {
            prettyPrint();
        } catch (e) {}
    </script>
    <script>
        $(document).ready(function() {
            updateInlineCode();
            applySettings();
        });
    </script>
@endsection
