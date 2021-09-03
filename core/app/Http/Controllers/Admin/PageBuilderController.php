<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Page;
use App\Home;

class PageBuilderController extends Controller
{

    public function replace_content_inside_delimiters($start, $end, $new, $html) {
        $startDelimiterLength = strlen($start);
        $endDelimiterLength = strlen($end);
        $startFrom = $contentStart = $contentEnd = 0;
        $contents = [];
        while (false !== ($contentStart = strpos($html, $start, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($html, $end, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $content = substr($html,$contentStart, $contentEnd - $contentStart);
            $contents[] =  $content;
            $startFrom = $contentEnd + $endDelimiterLength;
        }

        if(!empty($contents)) {
            foreach($contents as $content) {
                if(!empty($content)) {
                    $html = str_replace($content,$new,$html);
                }
            }
        }

        return $html;
    }


    public function save(Request $request)
    {
        if ($request->type == 'page') {
            $data = Page::findOrFail($request->id);
        } elseif ($request->type == 'themeHome') {
            $data = Home::findOrFail($request->id);
        }

        // Replace with 'Base URL' Shortcode
        $html = str_replace(url('/'), "{base_url}", $request->html);
        $html = "<div class='pagebuilder-content'>" . $html . "</div>";


        // replace HTML with 'service category' short code
        $html = $this->replace_content_inside_delimiters("<service-category-section>", "</service-category-section>", '[pagebuilder-service-category][/pagebuilder-service-category]', $html);
        // replace HTML with 'Services' short code
        $html = $this->replace_content_inside_delimiters("<services-section>", "</services-section>", '[pagebuilder-services][/pagebuilder-services]', $html);
        // replace HTML with 'Portfolios' short code
        $html = $this->replace_content_inside_delimiters("<portfolios-section>", "</portfolios-section>", '[pagebuilder-portfolios][/pagebuilder-portfolios]', $html);
        // replace HTML with 'FAQ' short code
        $html = $this->replace_content_inside_delimiters("<faq-section>", "</faq-section>", '[pagebuilder-faq][/pagebuilder-faq]', $html);
        // replace HTML with 'Team' short code
        $html = $this->replace_content_inside_delimiters("<team-section>", "</team-section>", '[pagebuilder-team][/pagebuilder-team]', $html);
        // replace HTML with 'Statistics' short code
        $html = $this->replace_content_inside_delimiters("<statistics-section>", "</statistics-section>", '[pagebuilder-statistics][/pagebuilder-statistics]', $html);
        // replace HTML with 'Testimonial' short code
        $html = $this->replace_content_inside_delimiters("<testimonial-section>", "</testimonial-section>", '[pagebuilder-testimonial][/pagebuilder-testimonial]', $html);
        // replace HTML with 'Packages' short code
        $html = $this->replace_content_inside_delimiters("<packages-section>", "</packages-section>", '[pagebuilder-packages][/pagebuilder-packages]', $html);
        // replace HTML with 'Blogs' short code
        $html = $this->replace_content_inside_delimiters("<blogs-section>", "</blogs-section>", '[pagebuilder-blogs][/pagebuilder-blogs]', $html);
        // replace HTML with 'Approach' short code
        $html = $this->replace_content_inside_delimiters("<approach-section>", "</approach-section>", '[pagebuilder-approach][/pagebuilder-approach]', $html);
        // replace HTML with 'Partners' short code
        $html = $this->replace_content_inside_delimiters("<partner-section>", "</partner-section>", '[pagebuilder-partner][/pagebuilder-partner]', $html);

        $data->html = $html;

        $css = str_replace(url('/'), "{base_url}", $request->css);
        $data->css = $css;

        $components = str_replace(url('/'), "{base_url}", $request->components);
        $data->components = $components;

        $styles = str_replace(url('/'), "{base_url}", $request->styles);
        $data->styles = $styles;

        $data->save();

        return "success";
    }

    public function content(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        if ($request->type == 'page') {
            $data = Page::findOrFail($request->id);
        } elseif ($request->type == 'themeHome') {
            // if the theme doesn't exist for that language, then create one
            $theme = Home::where('language_id', $lang->id)->where('theme', $request->theme);
            if ($theme->count() > 0) {
                $data = $theme->first();
            } else {
                $theme = new Home;
                $theme->language_id = $lang->id;
                $theme->theme = $request->theme;
                $theme->save();
                $data = $theme;
            }
        }

        $data['id'] = $data->id;
        $data['lang'] = $lang;
        $rtl = $lang->rtl;
        $data['rtl'] = $rtl;

        $bs = $lang->basic_setting;
        $data['abs'] = $bs;
        $be = $lang->basic_extended;
        $data['abe'] = $be;
        $bex = $lang->basic_extra;
        $version = $be->theme_version;

        $introsec = "";
        $approachsec = "";
        $scatsec = "";
        $servicesSec = "";
        $portfoliosSec = "";
        $teamSec = "";
        $statisticSec = "";
        $faqSec = "";
        $testimonialSec = "";
        $packageSec = "";
        $blogSec = "";
        $ctaSec = "";
        $partnerSec = "";

        $categories     = \App\Pcategory::all() //;
        ->where('show_in_menu', 1)
        ->where('language_id', $lang->id)
        ->where('status',1); //->get();
        $products       = \App\Product::withoutGlobalScope('variation')->where('status',1);
        $categories1    = $categories->where('menu_level', '1');
        $categories2    = $categories->where('menu_level', '2');
        $categories3    = $categories->where('menu_level', '3');


        $product_categories = $lang->pcategories;
        $product_child_categories = $lang->pcategories->where('is_child', '1')->where('menu_level', '3')->where('parent_menu_id', '!=', NULL);

        if ($version == 'lawyer' || $version == 'gym' || $version == 'construction' || $version == 'logistic' || $version == 'cleaning' || $version == 'bookworm') {
            $servicesLimit = 3;
        } else {
            $servicesLimit = false;
        }

        if ($version == 'lawyer' || $version == 'default' || $version == 'dark' || $version == 'gym' || $version == 'construction' || $version == 'logistic' || $version == 'cleaning' || $version == 'bookworm') {
            $portfoliosLimit = 4;
        } elseif ($version == 'car') {
            $portfoliosLimit = 3;
        } else {
            $portfoliosLimit = false;
        }

        if ($version == 'lawyer' || $version == 'gym' || $version == 'car' || $version == 'construction' || $version == 'logistic' || $version == 'cleaning' || $version == 'bookworm') {
            $membersLimit = 3;
        } elseif($version == 'default' || $version == 'dark') {
            $membersLimit = 4;
        } else {
            $membersLimit = false;
        }

        if ($version == 'lawyer' || $version == 'bookworm') {
            $testimonialsLimit = 3;
        } elseif($version == 'default' || $version == 'dark' || $version == 'construction') {
            $testimonialsLimit = 2;
        } elseif ($version == 'gym') {
            $testimonialsLimit = 1;
        } else {
            $testimonialsLimit = false;
        }

        if ($version == 'lawyer' || $version == 'default' || $version == 'dark' || $version == 'gym' || $version == 'car' || $version == 'construction' || $version == 'logistic' || $version == 'cleaning' || $version == 'bookworm') {
            $packagesLimit = 3;
        } else {
            $packagesLimit = false;
        }

        if ($version == 'lawyer' || $version == 'default' || $version == 'dark' || $version == 'gym' || $version == 'construction' || $version == 'logistic' || $version == 'cleaning' || $version == 'bookworm') {
            $blogsLimit = 3;
        } elseif ($version == 'car') {
            $blogsLimit = 1;
        } else {
            $blogsLimit = false;
        }


        if (!empty($lang->points)) {
            $points = $lang->points()->orderBy('serial_number', 'ASC')->get();
        } else {
            $points = [];
        }

        if (!empty($lang->scategories)) {
            $scats = $lang->scategories()->where('status', 1)->where('feature', 1)->orderBy('serial_number', 'ASC')
            ->when($servicesLimit, function ($query, $servicesLimit) {
                return $query->limit($servicesLimit);
            })->get();
        } else {
            $scats = [];
        }

        if (!empty($lang->services)) {
            $services = $lang->services()->where('feature', 1)->orderBy('serial_number', 'ASC')
            ->when($servicesLimit, function ($query, $servicesLimit) {
                return $query->limit($servicesLimit);
            })->get();
        } else {
            $services = [];
        }

        if (!empty($lang->portfolios)) {
            $portfolios = $lang->portfolios()->where('feature', 1)->orderBy('serial_number', 'ASC')
            ->when($portfoliosLimit, function ($query, $portfoliosLimit) {
                return $query->limit($portfoliosLimit);
            })->get();
        } else {
            $portfolios = [];
        }

        if (!empty($lang->members)) {
            $members = $lang->members()->where('feature', 1)
            ->when($membersLimit, function ($query, $membersLimit) {
                return $query->limit($membersLimit);
            })->get();
        } else {
            $members = [];
        }

        if (!empty($lang->statistics)) {
            $statistics = $lang->statistics()->orderBy('serial_number', 'ASC')->get();
        } else {
            $statistics = [];
        }

        if (!empty($lang->faqs)) {
            $faqs = $lang->faqs()->orderBy('serial_number', 'ASC')->get();
        } else {
            $faqs = [];
        }

        if (!empty($lang->testimonials)) {
            $testimonials = $lang->testimonials()->orderBy('serial_number', 'ASC')
            ->when($testimonialsLimit, function ($query, $testimonialsLimit) {
                return $query->limit($testimonialsLimit);
            })->get();
        } else {
            $testimonials = [];
        }

        if (!empty($lang->packages)) {
            $packages = $lang->packages()->orderBy('serial_number', 'ASC')
            ->where('feature', 1)
            ->when($packagesLimit, function ($query, $packagesLimit) {
                return $query->limit($packagesLimit);
            })->get();
        } else {
            $packages = [];
        }

        if (!empty($lang->blogs)) {
            $blogs = $lang->blogs()->orderBy('serial_number', 'ASC')
            ->when($blogsLimit, function ($query, $blogsLimit) {
                return $query->limit($blogsLimit);
            })->get();
        } else {
            $blogs = [];
        }

        if (!empty($lang->partners)) {
            $partners = $lang->partners()->orderBy('serial_number', 'ASC')->limit(4)->get();
        } else {
            $partners = [];
        }

        $bookworm_blocks = [];



        // FAQ section (All Versions)
        $faqSec = "<div class='container pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 60px 0px;'>
            <div class='faq-section' style='padding: 0px;'>
                <div class='row justify-content-center text-center' style='margin-bottom: 60px;'>
                    <div class='col-lg-6'>
                        <span class='section-title'>F.A.Q</span>
                        <h2 class='section-summary' style='margin-top: 20px;'>Frequently Asked Questions</h2>
                    </div>
                </div>
                <faq-section>
                    <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                        <div class='non-editable-notice'>
                            <h3>Non-Editable Area</h3>
                            Manage From <br><strong>Content Management > FAQ</strong>
                        </div>
                        <div class='row' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                            <div class='col-lg-6'>
                                <div class='accordion' id='accordionExample1'>";

                for ($i = 0; $i < ceil(count($faqs) / 2); $i++) {
                    $faqSec .= "<div class='card'>
                                            <div class='card-header' id='heading" . $faqs[$i]->id . "'>
                                                <h2 class='mb-0'>
                                                    <button class='btn btn-link collapsed btn-block text-left' type='button' data-toggle='collapse' data-target='#collapse" . $faqs[$i]->id . "' aria-expanded='false' aria-controls='collapse" . $faqs[$i]->id . "'>" .
                        convertUtf8($faqs[$i]->question)
                        . "</button>
                                                </h2>
                                            </div>
                                            <div id='collapse" . $faqs[$i]->id . "' class='collapse' aria-labelledby='heading" . $faqs[$i]->id . "' data-parent='#accordionExample1'>
                                                <div class='card-body'>" .
                        convertUtf8($faqs[$i]->answer) .
                        "</div>
                                            </div>
                                        </div>";
                }

                $faqSec .= "</div>
                            </div>
                            <div class='col-lg-6'>
                                <div class='accordion' id='accordionExample2'>";
                for ($i = ceil(count($faqs) / 2); $i < count($faqs); $i++) {
                    $faqSec .= "<div class='card'>
                                        <div class='card-header' id='heading" . $faqs[$i]->id . "'>
                                            <h2 class='mb-0'>
                                                <button class='btn btn-link collapsed btn-block text-left' type='button' data-toggle='collapse' data-target='#collapse" . $faqs[$i]->id . "' aria-expanded='false' aria-controls='collapse" . $faqs[$i]->id . "'>" . convertUtf8($faqs[$i]->question) .
                        "</button>
                                            </h2>
                                        </div>
                                        <div id='collapse" . $faqs[$i]->id . "' class='collapse' aria-labelledby='heading" . $faqs[$i]->id . "' data-parent='#accordionExample2'>
                                            <div class='card-body'>" .
                        convertUtf8($faqs[$i]->answer) .
                        "</div>
                                        </div>
                                    </div>";
                }
                $faqSec .= "</div>
                            </div>
                        </div>
                    </div>
                </faq-section>
            </div>
        </div>";

        if ($version == 'bookworm') {
            /** Categories */
                $category_1 = '
                    <div class="container space-1">
                        <header class="mb-5 d-md-flex justify-content-between align-items-center">
                            <h2 class="font-size-7 mb-3 mb-md-0">Featured Categories</h2>
                            <a href="#" class="h-primary d-block">All Categories <i class="glyph-icon flaticon-next"></i></a>
                        </header>
                        <ul class="list-unstyled my-0 row row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-wd-5">';
                            foreach ( $categories->where('is_child', '0') as $category ) {
                                $category_1 .= '<li class="product-category col mb-4 mb-xl-0">
                                    <div class="product-category__inner bg-indigo-light px-6 py-5">
                                        <div class="product-category__icon font-size-12 text-primary-indigo"><i class="glyph-icon flaticon-gallery"></i></div>
                                        <div class="product-category__body">
                                            <h3 class="text-truncate font-size-3">'. $category->name .'</h3>
                                            <a href="/products?search=&category_id='.$category->id.'&type=new" class="stretched-link text-dark">Shop Now</a>
                                        </div>
                                    </div>
                                </li>';
                            }

                        $category_1 .= '</ul>
                    </div>
                ';
                $category_2 = '
                    <div class="container">
                        <header class="mb-5 d-md-flex justify-content-between align-items-center">
                           <h2 class="mb-4 font-size-7 mb-md-0">Featured Categories</h2>
                           <a href="#" class="d-flex h-primary">All Categories<span class="ml-2 flaticon-next font-size-3"></span></a>
                        </header>
                        <ul class="px-5 pb-2 mb-5 overflow-auto bg-gray-200 rounded-md nav justify-content-between py-md-3 flex-nowrap flex-xl-wrap overflow-xl-visible" role="tablist">';
                            $counter    = 1;
                            $uuid_arr   = [];
                            foreach ($categories->where('is_child', '0') as $category) {
                                $active = $counter == 1 ? 'active' : '';
                                $uuid   = uniqid();
                                array_push($uuid_arr, $uuid);
                                $counter++;
                                $category_2 .= ' <li class="flex-shrink-0 nav-item flex-xl-shrink-1">
                                <a class="nav-link font-weight-medium '.$active.' nav-link-caret category-'.$category->id.'-'.$uuid_arr[$counter-2].'" data-toggle="pill" href=".category-'.$category->id.'-'.$uuid_arr[$counter-2].'-content" role="tab" aria-controls="category-'.$category->id.'-content" aria-selected="true">
                                    <div class="text-center">
                                        <figure class="mb-0 d-md-block text-primary-indigo">
                                           <i class="glyph-icon flaticon-gallery font-size-12"></i>
                                        </figure>
                                        <span class="tabtext font-size-3 font-weight-medium text-dark">'. $category->name.'</span>
                                    </div>
                                </a>
                            </li>';
                            }
                        $category_2 .= '</ul>
                    </div>
                    <div class="container">
                        <div class="tab-content">';
                            $counter = 1;
                            foreach($categories->where('is_child', '0') as $category) {
                                $active = $counter == 1 ? 'active' : '';
                                $counter++;
                                $category_2 .= '<div class="tab-pane fade '. $active .' show category-'.$category->id.'-'.$uuid_arr[$counter-2].'-content" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                <div class="pt-2">
                                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-wd-6 ">';
                                        foreach ( $category->products->where('show_in_page_builder', '1') as $product ) {
                                            $title = strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title;
                                            $category_2 .= '<div class="col">
                                            <div class="mb-5 products">
                                                <div class="product product__space border rounded-md bg-white">
                                                    <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                            <div class="woocommerce-loop-product__thumbnail">
                                                                <a href="'. route('front.product.details',$product->slug) .'" class="d-block"><img src="'. trim($product->feature_image) .'" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"></a>
                                                            </div>
                                                            <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                                <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="' . route('front.product.details',$product->slug) . '">'. $title .'</a></h2>
                                                                <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>' . $product->current_price . '</span>
                                                                </div>
                                                            </div>
                                                            <div class="product__hover d-flex align-items-center">
                                                                <a data-href="'.route('add.cart',$product->id).'" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                                                    <span class="product__add-to-cart">ADD TO CART</span>
                                                                    <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                                                </a>
                                                                <a href="'.route('front.product.checkout',$product->slug).'" class="mr-1 h-p-bg btn btn-outline-dark border-0">
                                                                    <i class="flaticon-switch"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                        }

                                    $category_2 .= '</div>
                                </div>
                            </div>';
                            }

                        $category_2 .= '</div>
                    </div>
                ';
                $category_4 = '
                    <div class="container space-2">
                        <header class="mb-5 d-md-flex justify-content-between align-items-center">
                            <h2 class="font-size-7 mb-3 mb-md-0">Featured Categories</h2>
                            <a href="#" class="h-primary h-primary d-block">All Categories <i class="glyph-icon flaticon-next"></i></a>
                        </header>
                        <div class="row no-gutters row-cols-1 row-cols-lg-3 border-top border-left">';
                            foreach( $categories->where('is_child', '0') as $category ) {
                                $category_4 .= '<div class="col">
                                <div class="position-relative">
                                    <div class="border-bottom border-right p-4 p-lg-7">
                                        <h6 class="font-size-3 mb-3 pb-1">'. $category->name .'</h6>
                                        <ul class="list-unstyled mb-0">';
                                            foreach( $category->products->where('show_in_page_builder', '1') as $product ) {
                                                $category_4 .= '<li class="font-weight-normal pb-1 mb-1">
                                                <a class="link-black-100" href="'. route('front.product.details',$product->slug) .'">'. $product->title .'</a>
                                            </li>';
                                            }

                                        $category_4 .= '</ul>
                                        <div class="d-flex d-md-block justify-content-end position-md-absolute bottom-0 right-md-30">
                                            <span class="flaticon-cook text-tangerine__1 font-size-17"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            }

                        $category_4 .= '</div>
                    </div>
                ';
                $category_5 = '
                    <div class="container space-1">
                        <header class="d-md-flex justify-content-between align-items-center mb-6">
                            <h2 class="font-size-7 mb-4 mb-lg-0">Featured Categories</h2>
                            <a href="#" class="d-flex h-primary">All Categories<span class="flaticon-next font-size-3 ml-2"></span></a>
                        </header>
                        <ul class="nav justify-content-between flex-nowrap overflow-auto">';
                        foreach ( $categories->where('is_child', '0') as $category ) {
                            $category_5 .= '
                                <li class="nav-item flex-shrink-0">
                                    <a class="nav-link font-weight-medium" href="/products?search=&category_id='.$category->id.'&type=new">
                                        <div class="text-center">
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="bg-indigo-light height-100 width-100 rounded-circle">
                                                    <figure class="d-flex justify-content-center mb-0 text-primary-indigo">
                                                        <i class="glyph-icon flaticon-gallery font-size-12 text-lh-2"></i>
                                                    </figure>
                                                </div>
                                            </div>
                                            <span class="tabtext font-size-3 font-weight-medium text-dark">'. $category->name .'</span>
                                        </div>
                                    </a>
                                </li>
                            ';
                        }

                        $category_5 .= '</ul>
                    </div>
                ';


                $child_category_1 = '
                    <div class="container space-1">
                        <header class="mb-5 d-md-flex justify-content-between align-items-center">
                            <h2 class="font-size-7 mb-3 mb-md-0">Featured Categories</h2>
                            <a href="#" class="h-primary d-block">All Categories <i class="glyph-icon flaticon-next"></i></a>
                        </header>
                        <ul class="list-unstyled my-0 row row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-wd-5">';
                            foreach ( $categories2 as $category ) {
                                $child_category_1 .= '<li class="product-category col mb-4 mb-xl-0">
                                    <div class="product-category__inner bg-indigo-light px-6 py-5">
                                        <div class="product-category__icon font-size-12 text-primary-indigo"><i class="glyph-icon flaticon-gallery"></i></div>
                                        <div class="product-category__body">
                                            <h3 class="text-truncate font-size-3">'. $category->name .'</h3>
                                            <a href="/products?search=&sub_category_id='.$category->id.'&type=new" class="stretched-link text-dark">Shop Now</a>
                                        </div>
                                    </div>
                                </li>';
                            }

                        $child_category_1 .= '</ul>
                    </div>
                ';

                $child_category_2 = '
                    <div class="container">
                        <header class="mb-5 d-md-flex justify-content-between align-items-center">
                           <h2 class="mb-4 font-size-7 mb-md-0">Featured Categories</h2>
                           <a href="#" class="d-flex h-primary">All Categories<span class="ml-2 flaticon-next font-size-3"></span></a>
                        </header>
                        <ul class="px-5 pb-2 mb-5 overflow-auto bg-gray-200 rounded-md nav justify-content-between py-md-3 flex-nowrap flex-xl-wrap overflow-xl-visible" role="tablist">';
                            $counter = 1;
                            $uuid_arr       = [];
                            foreach ($categories2 as $category) {
                                $products_m2 = \App\Product::query()->where('sub_category_id', '=', $category->id)->where('show_in_page_builder', '1');
                                if($products_m2->count() < 1) continue;
                                if($products_m2->count() >= 1) $active = $counter == 1 ? 'active' : '';$counter++;
                                $uuid   = uniqid();
                                array_push($uuid_arr, $uuid);
                                $child_category_2 .= ' <li class="flex-shrink-0 nav-item flex-xl-shrink-1">
                                <a class="nav-link font-weight-medium '.$active.' nav-link-caret child-category-'.$category->id.'" data-toggle="pill" href=".child-category-'.$category->id.'-'.$uuid_arr[$counter-2].'-content" role="tab" aria-controls="child-category-'.$category->id.'-content" aria-selected="true">
                                    <div class="text-center">
                                        <figure class="mb-0 d-md-block text-primary-indigo">
                                           <i class="glyph-icon flaticon-gallery font-size-12"></i>
                                        </figure>
                                        <span class="tabtext font-size-3 font-weight-medium text-dark">'.$category->name.'</span>
                                    </div>
                                </a>
                            </li>';
                            }
                        $child_category_2 .= '</ul>
                    </div>
                    <div class="container">
                        <div class="tab-content">';
                            $counter = 1;
                            foreach($categories2 as $category) {
                                $products_m2 = \App\Product::query()->where('sub_category_id', '=', $category->id)->where('show_in_page_builder', '1');
                                if($products_m2->count() < 1) continue;
                                if($products_m2->count() >= 1) $active = $counter == 1 ? 'active' : '';$counter++;
                                $child_category_2 .= '<div class="tab-pane fade '. $active .' show child-category-'.$category->id.'-'.$uuid_arr[$counter-2].'-content" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                <div class="pt-2">
                                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-wd-6 ">';
                                        foreach ( $products_m2->get() as $product ) {
                                            $title = strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title;
                                            $child_category_2 .= '<div class="col">
                                            <div class="mb-5 products">
                                                <div class="product product__space border rounded-md bg-white">
                                                    <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                            <div class="woocommerce-loop-product__thumbnail">
                                                                <a href="'. route('front.product.details',$product->slug) .'" class="d-block"><img src="'. trim($product->feature_image) .'" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"></a>
                                                            </div>
                                                            <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                                <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="' . route('front.product.details',$product->slug) . '">'. $title .'</a></h2>
                                                                <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>' . $product->current_price . '</span>
                                                                </div>
                                                            </div>
                                                            <div class="product__hover d-flex align-items-center">
                                                                <a data-href="'.route('add.cart',$product->id).'" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                                                    <span class="product__add-to-cart">ADD TO CART</span>
                                                                    <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                                                </a>
                                                                <a href="'.route('front.product.checkout',$product->slug).'" class="mr-1 h-p-bg btn btn-outline-dark border-0">
                                                                    <i class="flaticon-switch"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                        }

                                    $child_category_2 .= '</div>
                                </div>
                            </div>';
                            }

                        $child_category_2 .= '</div>
                    </div>
                ';





                $child_category_4 = '
                    <div class="container space-2">
                        <header class="mb-5 d-md-flex justify-content-between align-items-center">
                            <h2 class="font-size-7 mb-3 mb-md-0">Featured Categories</h2>
                            <a href="#" class="h-primary h-primary d-block">All Categories <i class="glyph-icon flaticon-next"></i></a>
                        </header>
                        <div class="row no-gutters row-cols-1 row-cols-lg-3 border-top border-left">';
                            foreach( $categories2 as $category ) {
                                $child_category_4 .= '<div class="col">
                                <div class="position-relative">
                                    <div class="border-bottom border-right p-4 p-lg-7">
                                        <h6 class="font-size-3 mb-3 pb-1">'. $category->name .'</h6>
                                        <ul class="list-unstyled mb-0">';
                                            foreach( $category->products_sub_1->where('show_in_page_builder', '1') as $product ) {
                                                $child_category_4 .= '<li class="font-weight-normal pb-1 mb-1">
                                                <a class="link-black-100" href="'. route('front.product.details',$product->slug) .'">'. $product->title .'</a>
                                            </li>';
                                            }

                                        $child_category_4 .= '</ul>
                                        <div class="d-flex d-md-block justify-content-end position-md-absolute bottom-0 right-md-30">
                                            <span class="flaticon-cook text-tangerine__1 font-size-17"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            }

                        $child_category_4 .= '</div>
                    </div>
                ';

                $child_category_5 = '
                    <div class="container space-1">
                        <header class="d-md-flex justify-content-between align-items-center mb-6">
                            <h2 class="font-size-7 mb-4 mb-lg-0">Featured Categories</h2>
                            <a href="#" class="d-flex h-primary">All Categories<span class="flaticon-next font-size-3 ml-2"></span></a>
                        </header>
                        <ul class="nav justify-content-between flex-nowrap overflow-auto">';
                        foreach ( $categories2 as $category ) {
                            $child_category_5 .= '
                                <li class="nav-item flex-shrink-0">
                                    <a class="nav-link font-weight-medium" href="/products?search=&sub_category_id='.$category->id.'&type=new">
                                        <div class="text-center">
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="bg-indigo-light height-100 width-100 rounded-circle">
                                                    <figure class="d-flex justify-content-center mb-0 text-primary-indigo">
                                                        <i class="glyph-icon flaticon-gallery font-size-12 text-lh-2"></i>
                                                    </figure>
                                                </div>
                                            </div>
                                            <span class="tabtext font-size-3 font-weight-medium text-dark">'. $category->name .'</span>
                                        </div>
                                    </a>
                                </li>
                            ';
                        }

                        $child_category_5 .= '</ul>
                    </div>
                ';










                array_push( $bookworm_blocks, [
                    'title' => 'Category #v1',
                    'section' => 'BookWorm Categories',
                    'content' => $category_1
                ] );
                array_push( $bookworm_blocks,  [
                    'title' => 'Category #v2',
                    'section' => 'BookWorm Categories',
                    'content' => $category_2
                ]);
                array_push( $bookworm_blocks,  [
                    'title' => 'Category #v4',
                    'section' => 'BookWorm Categories',
                    'content' => $category_4
                ] );
                array_push( $bookworm_blocks, [
                    'title' => 'Category #v5',
                    'section' => 'BookWorm Categories',
                    'content' => $category_5
                ] );




                array_push( $bookworm_blocks, [
                    'title' => 'Child Category #v1',
                    'section' => 'BookWorm Categories',
                    'content' => $child_category_1
                ] );
                array_push( $bookworm_blocks,  [
                    'title' => 'Child Category #v2',
                    'section' => 'BookWorm Categories',
                    'content' => $child_category_2
                ]);
                array_push( $bookworm_blocks,  [
                    'title' => 'Child Category #v4',
                    'section' => 'BookWorm Categories',
                    'content' => $child_category_4
                ] );
                array_push( $bookworm_blocks, [
                    'title' => 'Child Category #v5',
                    'section' => 'BookWorm Categories',
                    'content' => $child_category_5
                ] );
            /** */

            /** Tabs */

                $tab_1 = '
                    <div class="tabs-block tabs-v1">
                        <header class="mb-4 container pt-5">
                            <h2 class="font-size-7 text-center">Featured Books</h2>
                        </header>
                        <div class="container">
                            <ul class="nav justify-content-md-center nav-gray-700 mb-5 flex-nowrap flex-md-wrap overflow-auto overflow-md-visible featuredBooks" role="tablist">';
                            $uuid_arr       = [];
                                foreach( $categories  as $category ) {
                                    $active = $category->id == 1 ? 'active' : '';
                                    $uuid   = uniqid();
                                    $uuid_arr[$category->id]    = $uuid;
                                    $tab_1 .= '
                                    <li class="nav-item mx-5 mb-1 flex-shrink-0 flex-md-shrink-1">
                                        <a class="nav-link px-0 '. $active .' featured-'. $category->id .'-tab" data-toggle="tab" href=".featured-'. $category->id .'-'.$uuid_arr[$category->id].'" role="tab" aria-controls="featured" aria-selected="true">'. $category->name .'</a>
                                    </li>
                                    ';
                                }

                            $tab_1 .= '</ul>
                            <div class="tab-content featuredBooksContent">';
                                foreach( $categories as $category ) {
                                    $active = $category->id == 1 ? 'active' : '';
                                    $tab_1 .= '
                                    <div class="tab-pane fade show '. $active .' featured-'. $category->id .'-'.$uuid_arr[$category->id].'" role="tabpanel" aria-labelledby="featured-tab">
                                        <ul class="products list-unstyled row no-gutters row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-wd-6 border-top border-left my-0">';
                                            foreach ( $category->products->where('show_in_page_builder', '1') as $product ) {
                                                $title = strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title;
                                                $tab_1 .= '
                                                <li class="product col">
                                                    <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                                        <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                            <div class="woocommerce-loop-product__thumbnail">
                                                                <a href="'. route('front.product.details',$product->slug) .'" class="d-block"><img src="'. trim($product->feature_image) .'" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                                            </div>
                                                            <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                                <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="'. route('front.product.details',$product->slug) .'">'. $title .'</a></h2>
                                                                <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>'. $product->current_price .'</span>
                                                                </div>
                                                            </div>
                                                            <div class="product__hover d-flex align-items-center">
                                                                <a data-href="'.route('add.cart',$product->id).'" class="text-uppercase text-dark h-dark font-weight-medium mr-auto" data-toggle="tooltip" data-placement="right" title="ADD TO CART">
                                                                    <span class="product__add-to-cart">ADD TO CART</span>
                                                                    <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                                                </a>
                                                                <a href="'. route('front.product.checkout',$product->slug) .'" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                                    <i class="flaticon-switch"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                ';
                                            }
                                        $tab_1 .= '</ul>
                                    </div>
                                    ';
                                }

                            $tab_1 .='</div>
                        </div>
                    </div>
                ';

                $tab_3 = '
                   <div class="container">
                        <header class="d-md-flex justify-content-between mb-5">
                            <h2 class="font-size-7">Featured Books</h2>
                            <ul class="nav nav-gray-700 flex-nowrap flex-md-wrap overflow-auto overflow-md-visible" role="tablist">';
                            $uuid_arr       = [];
                                foreach($categories as $category) {
                                    $active = $category->id == 1 ? 'active' : '';
                                    $uuid   = uniqid();
                                    $uuid_arr[$category->id]    = $uuid;
                                    $tab_3 .= '<li class="nav-item mx-4 flex-shrink-0 flex-md-shrink-1">
                                    <a class="nav-link pb-1 px-0 '.$active.' '.$category->slug.'-pill-tab" data-toggle="tab" href=".'.$category->slug.'-'.$uuid_arr[$category->id].'-pill" role="pill" aria-controls="'.$category->slug.'-pill" aria-selected="true">'.$category->name.'</a>
                                </li>';
                                }

                            $tab_3 .= '</ul>
                        </header>
                        <div class="tab-content pills-tabcontent">';
                                foreach ($categories as $category ) {
                                    $active = $category->id == 1 ? 'active' : '';
                                    $show = $category->id == 1 ? 'show' : '';
                                    $tab_3 .= '<div class="tab-pane fade '.$show.' '.$active.' '.$category->slug.'-'.$uuid_arr[$category->id].'-pill" role="tabpanel" aria-labelledby="history-pill-tab">
                                        <div class="row">
                                            <div class="col-lg-8 mb-5 mb-md-0">
                                                <ul class="products row row-cols-2 row-cols-lg-2 row-cols-xl-3 row-cols-wd-4 list-unstyled mb-0">';
                                                    foreach( $category->products->where('show_in_page_builder', '1') as $product ) {
                                                        $title = strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title;
                                                        $tab_3 .= '<li class="col">
                                                        <div class="mb-5">
                                                            <div class="product product__space border rounded-md bg-white">
                                                                <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                                                    <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                                        <div class="woocommerce-loop-product__thumbnail">
                                                                            <a href="'.route('front.product.details',$product->slug).'" class="d-block"><img src="'.trim($product->feature_image).'" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"></a>
                                                                        </div>
                                                                        <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                                            <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="'.route('front.product.details',$product->slug).'">'.$title.'</a></h2>
                                                                            <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>'.$product->current_price.'</span>
                                                                            </div>
                                                                            <div class="product__rating d-none align-items-center font-size-2">
                                                                                <div class="text-yellow-darker mr-2">
                                                                                    <small class="fas fa-star"></small>
                                                                                    <small class="fas fa-star"></small>
                                                                                    <small class="fas fa-star"></small>
                                                                                    <small class="far fa-star"></small>
                                                                                    <small class="far fa-star"></small>
                                                                                </div>
                                                                                <div class="">(3,714)</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product__hover d-flex align-items-center">
                                                                            <a data-href="'.route('add.cart',$product->id).'" class="text-uppercase text-dark h-dark font-weight-medium mr-auto" data-toggle="tooltip" data-placement="right" data-original-title="ADD TO CART">
                                                                                <span class="product__add-to-cart">ADD TO CART</span>
                                                                                <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                                                            </a>
                                                                            <a href="'.route('front.product.checkout',$product->slug).'" class="mr-1 h-p-bg btn btn-outline-dark border-0">
                                                                                <i class="flaticon-switch"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>';
                                                    }

                                                $tab_3 .= '</ul>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="banner py-6 py-lg-0 px-3 px-md-4 px-xl-8 d-flex h-100 align-items-center rounded-md bg-primary-home-v3">
                                                    <div class="banner__body">
                                                        <div class="banner__image pb-1 mb-5">
                                                            <img src="https://placehold.it/350x282" class="img-fluid">
                                                        </div>
                                                        <h3 class="banner_text m-0">
                                                            <span class="d-block mb-1 font-size-10 font-weight-regular text-white">Get Extra</span>
                                                            <span class="d-block mb-3 font-size-12 font-weight-medium text-white">Sale -25%</span>
                                                            <span class="d-block mb-5 text-uppercase font-size-4 font-weight-regular text-gray-400">On Order Over $100</span>
                                                        </h3>
                                                        <a href="#" class="btn btn-warning btn-wide rounded-md">View More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }

                        $tab_3 .= '</div>
                    </div>
                ';

                $tab_4 = '
                    <div class="container">
                        <header class="mb-5 d-md-flex justify-content-between align-items-center">
                            <h2 class="font-size-7 mb-3 mb-md-0">New Releases</h2>
                            <ul class="nav nav-gray-700 flex-nowrap flex-md-wrap overflow-auto overflow-md-visible">';
                                $uuid_arr   = [];
                                foreach( $categories as $category ) {
                                    $active = $category->id == 1 ? 'active' : '';
                                    $uuid   = uniqid();
                                    $uuid_arr[$category->id]    = $uuid;
                                    $tab_4 .= '<li class="nav-item mx-4 flex-shrink-0 flex-md-shrink-1">
                                    <a class="nav-link pb-1 px-0 '.$active.' tab4-'.$category->id.'-tab" data-toggle="tab" href=".tab4-'.$category->id.'-'.$uuid_arr[$category->id].'" role="tab" aria-controls="tab4-'.$category->id.'" aria-selected="true">'.$category->name.'</a>
                                </li>';
                                }

                            $tab_4 .= '</ul>
                        </header>
                        <div class="tab-content NewReleases">';
                            foreach ( $categories as $category ) {
                                $active = $category->id == 1 ? 'active' : '';
                                $show = $category->id == 1 ? 'show' : '';
                                $tab_4 .= '<div class="tab-pane fade '.$show.' '.$active.' tab4-'.$category->id.'-'.$uuid_arr[$category->id].'" role="tabpanel" aria-labelledby="tab4-'.$category->id.'-tab">
                                <div class="row no-gutters">
                                    <div class="col-xl-4 border-right-0 border bg-gray-200 px-1">
                                        <div class="banner px-lg-8 px-3 py-4 py-xl-0 d-flex h-100 align-items-center justify-content-center">
                                            <div class="banner__body">
                                                <div class="banner__image pb-1 mb-5">
                                                    <img class="img-fluid" src="https://placehold.it/350x282">
                                                </div>
                                                <h3 class="banner_text m-0">
                                                    <span class="d-block mb-1 font-size-10 font-weight-regular">Get Extra</span>
                                                    <span class="d-block mb-3 font-size-12 text-primary font-weight-medium">Sale -25%</span>
                                                    <span class="d-block mb-5 text-uppercase font-size-7 font-weight-regular text-gray-400">On Order Over $100</span>
                                                </h3>
                                                <a href="#" class="btn btn-primary btn-wide rounded-0">View More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <ul class="products list-unstyled row no-gutters row-cols-2 row-cols-lg-3 row-cols-wd-4 border-top border-left my-0">';
                                            foreach($category->products->where('show_in_page_builder', '1') as $product) {
                                                $title = strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title;
                                                $tab_4 .= '<li class="product col">
                                                <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                                    <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                        <div class="woocommerce-loop-product__thumbnail">
                                                            <a href="'.route('front.product.details',$product->slug).'" class="d-block"><img src="'.trim($product->feature_image).'" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"></a>
                                                        </div>
                                                        <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                            <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="'.route('front.product.details',$product->slug).'">'.$title.'</a></h2>
                                                            <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>'.$product->current_price.'</span>
                                                            </div>
                                                        </div>
                                                        <div class="product__hover d-flex align-items-center">
                                                            <a data-href="'.route('add.cart',$product->id).'" class="text-uppercase text-dark h-dark font-weight-medium mr-auto" data-toggle="tooltip" data-placement="right" title="ADD TO CART">
                                                                <span class="product__add-to-cart">ADD TO CART</span>
                                                                <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                                            </a>
                                                            <a href="'.route('front.product.checkout',$product->slug).'" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                                <i class="flaticon-switch"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>';
                                            }
                                        $tab_4 .= '</ul>
                                    </div>
                                </div>
                            </div>';
                            }

                        $tab_4 .= '</div>
                    </div>
                ';

                $tab_5 = '
                    <div class="container">
                        <header class="d-md-flex justify-content-between mb-5 pt-5">
                            <h2 class="font-size-26">New Releases</h2>
                            <ul class="nav nav-gray-700 flex-nowrap flex-md-wrap overflow-auto overflow-md-visible" role="tablist">';
                                $uuid_arr   = [];
                                foreach($categories as $category) {
                                    $active = $category->id == 1 ? 'active' : '';
                                    $uuid   = uniqid();
                                    $uuid_arr[$category->id]    = $uuid;
                                    $tab_5 .= '
                                    <li class="nav-item mx-4 flex-shrink-0 flex-md-shrink-1">
                                        <a class="nav-link pb-1 px-0 '.$active.' Sale-pill-tab-'.$category->id.'" data-toggle="tab" href=".Sale-pill-'.$category->id.'-'.$uuid_arr[$category->id].'" role="pill" aria-controls="Sale-pill-'.$category->id.'" aria-selected="true">'.$category->name.'</a>
                                    </li>
                                    ';
                                }

                            $tab_5 .= '</ul>
                        </header>
                        <div class="tab-content pills-tabcontent">';
                            foreach( $categories as $category ) {
                                $active = $category->id == 1 ? 'active' : '';
                                $show = $category->id == 1 ? 'show' : '';
                                $tab_5 .= '<div class="tab-pane fade '.$show.' '.$active.' Sale-pill-'.$category->id.'-'.$uuid_arr[$category->id].'" role="tabpanel" aria-labelledby="Sale-pill-tab">
                                <ul class="products row row-cols-2 row-cols-md-3 list-unstyled mb-0">';
                                    foreach( $category->products->where('show_in_page_builder', '1') as $product ) {
                                        $title = strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title;
                                        $tab_5 .= '<li class="col">
                                        <div class="product product__space border bg-white mb-5">
                                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                                <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                    <div class="woocommerce-loop-product__thumbnail">
                                                        <a href="'.route('front.product.details',$product->slug).'" class="d-block"><img src="'.trim($product->feature_image).'" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"></a>
                                                    </div>
                                                    <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                        <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="'.route('front.product.details',$product->slug).'">'.$title.'</a></h2>
                                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>'.$product->current_price.'</span>
                                                        </div>
                                                        <div class="product__rating d-none align-items-center font-size-2">
                                                            <div class="text-yellow-darker mr-2">
                                                                <small class="fas fa-star"></small>
                                                                <small class="fas fa-star"></small>
                                                                <small class="fas fa-star"></small>
                                                                <small class="far fa-star"></small>
                                                                <small class="far fa-star"></small>
                                                            </div>
                                                            <div class="">(3,714)</div>
                                                        </div>
                                                    </div>
                                                    <div class="product__hover d-flex align-items-center">
                                                        <a data-href="'.route('add.cart',$product->id).'" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                                            <span class="product__add-to-cart">ADD TO CART</span>
                                                            <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                                        </a>
                                                        <a href="'.route('front.product.checkout',$product->slug).'" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                            <i class="flaticon-switch"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>';
                                    }
                                $tab_5 .= '</ul>
                            </div>';
                            }

                        $tab_5 .= '</div>
                    </div>
                ';

                $tab_6 = '
                    <div class="container">
                        <header class="d-md-flex justify-content-between align-items-center mb-5 pt-5">
                            <h2 class="font-size-7 mb-4 mb-md-0">Books</h2>
                            <ul class="nav justify-content-md-center nav-gray-700 flex-nowrap flex-md-wrap overflow-auto overflow-md-visible"  role="tablist">';
                                $uuid_arr   = [];
                                foreach ( $categories as $category ) {
                                    $active = $category->id == 1 ? 'active' : '';
                                    $uuid   = uniqid();
                                    $uuid_arr[$category->id]    = $uuid;
                                    $tab_6 .= '<li class="nav-item mx-5 mb-1 flex-shrink-0 flex-md-shrink-1">
                                    <a class="nav-link px-0 '.$active.' One-tab-'.$category->id.'" data-toggle="tab" href=".One-'.$category->id.'-'.$uuid_arr[$category->id].'" role="tab" aria-controls="One" aria-selected="true">'.$category->name.'</a>
                                </li>';
                                }

                            $tab_6 .= '</ul>
                        </header>
                        <div class="tab-content">';
                                foreach($categories as $category) {
                                    $active = $category->id == 1 ? 'active' : '';
                                    $show = $category->id == 1 ? 'show' : '';
                                    $tab_6 .= '<div class="tab-pane fade '.$show.' '.$active.' One-'.$category->id.'-'.$uuid_arr[$category->id].'" aria-labelledby="One-tab">
                                    <ul class="list-unstyled products row row-cols-2 row-cols-lg-4 row-cols-wd-5 mb-0">';
                                        foreach ($category->products->where('show_in_page_builder', '1') as $product) {
                                            $title = strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title;
                                            $tab_6 .= '<li class="col">
                                            <div class="product border product__space bg-white mb-5 mb-lg-0">
                                                <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                                    <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                        <div class="woocommerce-loop-product__thumbnail">
                                                            <a href="'.route('front.product.details',$product->slug).'" class="d-block"><img src="'.trim($product->feature_image).'" class="d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                                        </div>
                                                        <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                            <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="'.route('front.product.details',$product->slug).'">'.$title.'</a></h2>
                                                            <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>'.$product->current_price.'</span>
                                                            </div>

                                                        </div>
                                                        <div class="product__hover d-flex align-items-center">
                                                            <a data-href="'.route('add.cart',$product->id).'" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                                                <span class="product__add-to-cart">ADD TO CART</span>
                                                                <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                                            </a>
                                                            <a href="'.route('front.product.checkout',$product->slug).'" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                                <i class="flaticon-switch"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>';
                                        }

                                    $tab_6 .= '</ul>
                                </div>
                                ';
                                }

                        $tab_6 .= '</div>
                    </div>
                ';

                $tab_7 = '
                    <div class="bg-gray-200 space-2 space-lg-3">
                        <div class="container ">
                            <div class="d-md-flex justify-content-between">
                                <header class="mb-4">
                                    <h2 class="font-size-7">Featured Books</h2>
                                </header>
                                <ul class="nav justify-content-md-center nav-gray-700 mb-5 flex-nowrap flex-lg-wrap overflow-auto overflow-lg-visible" role="tablist">';
                                    $uuid_arr   = [];
                                    foreach ($categories as $category) {
                                        $active = $category->id == 1 ? 'active' : '';
                                        $uuid   = uniqid();
                                        $uuid_arr[$category->id]    = $uuid;
                                        $tab_7 .= '<li class="nav-item mx-5 mb-1 flex-shrink-0 flex-lg-shrink-1">
                                        <a class="nav-link px-0 '.$active.' example7-'.$category->id.'-tab" data-toggle="tab" href=".example7-'.$category->id.'-'.$uuid_arr[$category->id].'" role="tab" aria-controls="example1" aria-selected="true">'.$category->name.'</a>
                                    </li>';
                                    }

                                $tab_7 .= '</ul>
                            </div>
                            <div class="tab-content featuredBooksContent">';
                                    foreach ( $categories as $category ) {
                                        $active = $category->id == 1 ? 'active' : '';
                                        $show = $category->id == 1 ? 'show' : '';
                                        $tab_7 .= '<div class="tab-pane fade '.$show.' '.$active.' example7-'.$category->id.'-'.$uuid_arr[$category->id].'" role="tabpanel" aria-labelledby="example7-'.$category->id.'-tab">
                                        <ul class="products list-unstyled row no-gutters row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-wd-6 border-top border-left my-0">';
                                            foreach($category->products->where('show_in_page_builder', '1') as $product) {
                                                $title = strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title;
                                                $tab_7 .= '<li class="product col">
                                                <div class="product__inner overflow-hidden bg-white p-3 p-md-4d875">
                                                    <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                        <div class="woocommerce-loop-product__thumbnail">
                                                            <a href="'.route('front.product.details',$product->slug).'" class="d-block"><img src="'.trim($product->feature_image).'" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                                        </div>
                                                        <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                            <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="'.route('front.product.details',$product->slug).'">'.$title.'</a></h2>
                                                            <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>'.$product->current_price.'</span>
                                                            </div>
                                                        </div>
                                                        <div class="product__hover d-flex align-items-center">
                                                            <a data-href="'.route('add.cart',$product->id).'" class="text-uppercase text-dark h-dark font-weight-medium mr-auto" data-toggle="tooltip" data-placement="right" title="ADD TO CART">
                                                                <span class="product__add-to-cart">ADD TO CART</span>
                                                                <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                                            </a>
                                                            <a href="'.route('front.product.checkout',$product->slug).'" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                                <i class="flaticon-switch"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>';
                                            }
                                        $tab_7 .= '</ul>
                                    </div>';
                                    }

                            $tab_7 .= '</div>
                        </div>
                    </div>
                ';

                $tab_8 ='
                    <div class="bg-gray-200 space-2 space-lg-3">
                        <div class="container ">
                            <div class="d-md-flex justify-content-between">
                                <header class="mb-4">
                                    <h2 class="font-size-7">Featured Books</h2>
                                </header>
                                <ul class="nav justify-content-md-center nav-gray-700 mb-5 flex-nowrap flex-lg-wrap overflow-auto overflow-lg-visible" role="tablist">';
                                        $uuid_arr   = [];
                                        foreach ($categories as $category) {
                                            $active = $category->id == 1 ? 'active' : '';
                                            $uuid   = uniqid();
                                            $uuid_arr[$category->id]    = $uuid;
                                            $tab_8 .= '<li class="nav-item mx-5 mb-1 flex-shrink-0 flex-lg-shrink-1">
                                            <a class="nav-link px-0 '.$active.' example8-'.$category->id.'-tab" data-toggle="tab" href=".example8-'.$category->id.'-'.$uuid_arr[$category->id].'" role="tab" aria-controls="example8-'.$category->id.'" aria-selected="true">'.$category->name.'</a>
                                        </li>';
                                        }

                                $tab_8 .= '</ul>
                            </div>
                            <div class="tab-content featuredBooksContent">';
                            foreach ($categories as $category ) {
                                $active = $category->id == 1 ? 'active' : '';
                                $show = $category->id == 1 ? 'show' : '';
                                $tab_8 .= '<div class="tab-pane fade '.$show.' '.$active.' example8-'.$category->id.'-'.$uuid_arr[$category->id].'" role="tabpanel" aria-labelledby="example8-'.$category->id.'-tab">
                                <ul class="products list-unstyled row no-gutters row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-wd-6 border-top border-left my-0">';
                                    foreach( $category->products->where('show_in_page_builder', '1') as $product ) {
                                        $title = strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title;
                                        $tab_8 .= '<li class="product col">
                                        <div class="product__inner overflow-hidden bg-white p-3 p-md-4d875">
                                            <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                <div class="woocommerce-loop-product__thumbnail">
                                                    <a href="'.route('front.product.details',$product->slug).'" class="d-block"><img src="'.trim($product->feature_image).'" class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description"></a>
                                                </div>
                                                <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                    <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="'.route('front.product.details',$product->slug).'">'.$title.'</a></h2>
                                                    <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                        <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>'.$product->current_price.'</span>
                                                    </div>
                                                </div>
                                                <div class="product__hover d-flex align-items-center">
                                                    <a data-href="'.route('add.cart',$product->id).'" class="text-uppercase text-dark h-dark font-weight-medium mr-auto" data-toggle="tooltip" data-placement="right" title="ADD TO CART">
                                                        <span class="product__add-to-cart">ADD TO CART</span>
                                                        <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                                    </a>
                                                    <a href="'.route('front.product.checkout',$product->slug).'" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                        <i class="flaticon-switch"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>';
                                    }

                                $tab_8 .= '</ul>
                            </div>';
                            }

                            $tab_8 .= '</div>
                        </div>
                    </div>
                ';

                array_push( $bookworm_blocks, [
                    'title' => 'Tabs #v1',
                    'section' => 'BookWorm Tabs',
                    'content' => $tab_1
                ] );

                array_push( $bookworm_blocks, [
                    'title' => 'Tabs #v3',
                    'section' => 'BookWorm Tabs',
                    'content' => $tab_3
                ] );

                array_push( $bookworm_blocks, [
                    'title' => 'Tabs #v4',
                    'section' => 'BookWorm Tabs',
                    'content' => $tab_4
                ] );

                array_push( $bookworm_blocks, [
                    'title' => 'Tabs #v5',
                    'section' => 'BookWorm Tabs',
                    'content' => $tab_5
                ] );

                array_push( $bookworm_blocks, [
                    'title' => 'Tabs #v6',
                    'section' => 'BookWorm Tabs',
                    'content' => $tab_6
                ] );

                array_push( $bookworm_blocks, [
                    'title' => 'Tabs With BG Color',
                    'section' => 'BookWorm Tabs',
                    'content' => $tab_7
                ] );

                array_push( $bookworm_blocks, [
                    'title' => 'Tabs With BG Color #2',
                    'section' => 'BookWorm Tabs',
                    'content' => $tab_8
                ] );

            /** */

            /** Icon Blocks */

                $bookworm_blocks[] = [
                    'title' => 'Icon Blocks #v1',
                    'section' => 'BookWorm Icon Blocks',
                    'content' => '
                        <div class="site-features  space-1d625">
                            <div class="container">
                                <ul class="list-unstyled my-0 list-features d-flex align-items-center justify-content-xl-between overflow-auto overflow-xl-visible">
                                    <li class="flex-shrink-0 flex-xl-shrink-1 list-feature">
                                        <div class="media">
                                            <div class="feature__icon font-size-14 text-primary-green text-lh-xs">
                                                <i class="glyph-icon flaticon-delivery"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3">Free Delivery</h4>
                                                <p class="feature__subtitle m-0">Orders over $100</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0 flex-xl-shrink-1 separator mx-4 mx-xl-0 border-left h-fixed-80" aria-hidden="true" role="presentation"></li>
                                    <li class="flex-shrink-0 flex-xl-shrink-1 list-feature">
                                        <div class="media">
                                            <div class="feature__icon font-size-14 text-primary-green text-lh-xs">
                                                <i class="glyph-icon flaticon-credit"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3">Secure Payment</h4>
                                                <p class="feature__subtitle m-0">100% Secure Payment</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0 flex-xl-shrink-1 separator mx-4 mx-xl-0 border-left h-fixed-80" aria-hidden="true" role="presentation"></li>
                                    <li class="flex-shrink-0 flex-xl-shrink-1 list-feature">
                                        <div class="media">
                                            <div class="feature__icon font-size-14 text-primary-green text-lh-xs">
                                                <i class="glyph-icon flaticon-warranty"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3">Money Back Guarantee</h4>
                                                <p class="feature__subtitle m-0">Within 30 Days</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="flex-shrink-0 flex-xl-shrink-1 separator mx-4 mx-xl-0 border-left h-fixed-80" aria-hidden="true" role="presentation"></li>
                                    <li class="flex-shrink-0 flex-xl-shrink-1 list-feature">
                                        <div class="media">
                                            <div class="feature__icon font-size-14 text-primary-green text-lh-xs">
                                                <i class="glyph-icon flaticon-help"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3">24/7 Support</h4>
                                                <p class="feature__subtitle m-0">Within 1 Business Day</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    '
                ];

                $bookworm_blocks[] = [
                    'title' => 'Icon Blocks #v2',
                    'section' => 'BookWorm Icon Blocks',
                    'content' => '
                        <div class="site-features border-top space-1d625 bg-primary-home-v3">
                            <div class="container">
                                <ul class="list-unstyled my-0 row list-features flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visible">
                                    <li class="col py-2 border-right border-color-white-o list-feature d-flex flex-shrink-0 flex-xl-shrink-1 min-width-400-d-lg">
                                        <div class="media px-3 px-wd-4 m-auto">
                                            <div class="feature__icon font-size-14 text-primary-yellow text-lh-xs">
                                                <i class="glyph-icon flaticon-delivery"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3 text-white">Free Delivery</h4>
                                                <p class="feature__subtitle m-0 text-white">Orders over $100</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col py-2 border-right border-color-white-o list-feature d-flex flex-shrink-0 flex-xl-shrink-1 min-width-400-d-lg">
                                        <div class="media px-3 px-wd-4 m-auto">
                                            <div class="feature__icon font-size-14 text-primary-yellow text-lh-xs">
                                                <i class="glyph-icon flaticon-credit"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3 text-white">Secure Payment</h4>
                                                <p class="feature__subtitle m-0 text-white">100% Secure Payment</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col py-2 border-right border-color-white-o list-feature d-flex flex-shrink-0 flex-xl-shrink-1 min-width-400-d-lg">
                                        <div class="media px-3 px-wd-4 m-auto">
                                            <div class="feature__icon font-size-14 text-primary-yellow text-lh-xs">
                                                <i class="glyph-icon flaticon-warranty"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3 text-white">Money Back Guarantee</h4>
                                                <p class="feature__subtitle m-0 text-white">Within 30 Days</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col py-2 list-feature d-flex flex-shrink-0 flex-xl-shrink-1 min-width-400-d-lg">
                                        <div class="media px-3 px-wd-4 m-auto">
                                            <div class="feature__icon font-size-14 text-primary-yellow text-lh-xs">
                                                <i class="glyph-icon flaticon-help"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3 text-white">24/7 Support</h4>
                                                <p class="feature__subtitle m-0 text-white">Within 1 Business Day</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    '
                ];

                $bookworm_blocks[] = [
                    'title' => 'Icon Blocks #v3',
                    'section' => 'BookWorm Icon Blocks',
                    'content' => '
                        <div class="site-features space-1d625 bg-dark-1">
                            <div class="container">
                                <ul class="list-unstyled my-0 list-features overflow-auto overflow-lg-visible d-flex align-items-center justify-content-between">
                                    <li class="list-feature flex-shrink-0 flex-shrink-lg-1">
                                        <div class="media d-block d-lg-flex text-center text-lg-left pr-5 pr-xl-0">
                                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-3 mb-lg-0">
                                                <i class="glyph-icon flaticon-delivery"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3 text-white">Free Delivery</h4>
                                                <p class="feature__subtitle m-0 text-white">Orders over $100</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="separator border-xl-left h-fixed-80 opacity-sm" aria-hidden="true" role="presentation"></li>
                                    <li class="list-feature flex-shrink-0 flex-shrink-lg-1">
                                        <div class="media d-block d-lg-flex text-center text-lg-left pr-5 pr-xl-0">
                                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-3 mb-lg-0">
                                                <i class="glyph-icon flaticon-credit"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3 text-white">Secure Payment</h4>
                                                <p class="feature__subtitle m-0 text-white">100% Secure Payment</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="separator border-xl-left h-fixed-80 opacity-sm" aria-hidden="true" role="presentation"></li>
                                    <li class="list-feature flex-shrink-0 flex-shrink-lg-1">
                                        <div class="media d-block d-lg-flex text-center text-lg-left pr-5 pr-xl-0">
                                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-3 mb-lg-0">
                                                <i class="glyph-icon flaticon-warranty"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3 text-white">Money Back Guarantee</h4>
                                                <p class="feature__subtitle m-0 text-white">Within 30 Days</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="separator border-xl-left h-fixed-80 opacity-sm" aria-hidden="true" role="presentation"></li>
                                    <li class="list-feature flex-shrink-0 flex-shrink-lg-1">
                                        <div class="media d-block d-lg-flex text-center text-lg-left pr-5 pr-xl-0">
                                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-3 mb-lg-0">
                                                <i class="glyph-icon flaticon-help"></i>
                                            </div>
                                            <div class="media-body ml-4">
                                                <h4 class="feature__title font-size-3 text-white">24/7 Support</h4>
                                                <p class="feature__subtitle m-0 text-white">Within 1 Business Day</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    '
                ];

                $bookworm_blocks[] = [
                    'title' => 'Icon Blocks #v4',
                    'section' => 'BookWorm Icon Blocks',
                    'content' => '
                        <div class="site-features border-bottom space-1d625">
                            <div class="container">
                                <ul class="list-unstyled my-0 list-features d-md-flex align-items-center justify-content-between">
                                    <li class="list-feature">
                                        <div class="media d-md-block d-xl-flex text-center text-xl-left pr-lg-5 pr-xl-0">
                                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-md-3 mb-lg-0">
                                                <i class="glyph-icon flaticon-delivery"></i>
                                            </div>
                                            <div class="media-body ml-xl-4">
                                                <h4 class="feature__title font-size-3 text-dark">Free Delivery</h4>
                                                <p class="feature__subtitle m-0 text-dark">Orders over $100</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="separator border-xl-left h-fixed-80" aria-hidden="true" role="presentation"></li>
                                    <li class="list-feature">
                                        <div class="media  d-md-block d-xl-flex text-center text-xl-left pr-lg-5 pr-xl-0">
                                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-md-3 mb-lg-0">
                                                <i class="glyph-icon flaticon-credit"></i>
                                            </div>
                                            <div class="media-body ml-xl-4">
                                                <h4 class="feature__title font-size-3 text-dark">Secure Payment</h4>
                                                <p class="feature__subtitle m-0 text-dark">100% Secure Payment</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="separator border-xl-left h-fixed-80" aria-hidden="true" role="presentation"></li>
                                    <li class="list-feature">
                                        <div class="media  d-md-block d-xl-flex text-center text-xl-left pr-lg-5 pr-xl-0">
                                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-md-3 mb-lg-0">
                                                <i class="glyph-icon flaticon-warranty"></i>
                                            </div>
                                            <div class="media-body ml-xl-4">
                                                <h4 class="feature__title font-size-3 text-dark">Money Back Guarantee</h4>
                                                <p class="feature__subtitle m-0 text-dark">Within 30 Days</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="separator border-xl-left h-fixed-80" aria-hidden="true" role="presentation"></li>
                                    <li class="list-feature">
                                        <div class="media d-md-block d-xl-flex text-center text-xl-left pr-lg-5 pr-xl-0">
                                            <div class="feature__icon font-size-14 text-primary text-lh-xs mb-md-3 mb-lg-0">
                                                <i class="glyph-icon flaticon-help"></i>
                                            </div>
                                            <div class="media-body ml-xl-4">
                                                <h4 class="feature__title font-size-3 text-dark">24/7 Support</h4>
                                                <p class="feature__subtitle m-0 text-dark">Within 1 Business Day</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    '
                ];

                $bookworm_blocks[] = [
                    'title' => 'Icon Blocks #v5',
                    'section' => 'BookWorm Icon Blocks',
                    'content' => '
                        <div class="site-features space-2">
                            <div class="container">
                                <ul class="list-unstyled my-0 list-features overflow-auto d-flex align-items-center justify-content-between">
                                    <li class="list-feature py-2 py-md-0 flex-shrink-0 flex-xl-shrink-1">
                                        <div class="media flex-column align-items-center pr-5 pr-lg-0">
                                            <div class="feature__icon font-size-14 text-tangerine text-lh-xs mb-3">
                                                <i class="glyph-icon flaticon-delivery"></i>
                                            </div>
                                            <div class="media-body text-center ml-4 ml-lg-0">
                                                <h4 class="feature__title font-size-3 text-dark">Free Delivery</h4>
                                                <p class="feature__subtitle m-0 text-dark">Orders over $100</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-feature py-2 py-md-0 flex-shrink-0 flex-xl-shrink-1">
                                        <div class="media flex-column align-items-center pr-5 pr-lg-0">
                                            <div class="feature__icon font-size-14 text-tangerine text-lh-xs mb-3">
                                                <i class="glyph-icon flaticon-credit"></i>
                                            </div>
                                            <div class="media-body text-center">
                                                <h4 class="feature__title font-size-3 text-dark">Secure Payment</h4>
                                                <p class="feature__subtitle m-0 text-dark">100% Secure Payment</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-feature py-2 py-md-0 flex-shrink-0 flex-xl-shrink-1">
                                        <div class="media flex-column align-items-center pr-5 pr-lg-0">
                                            <div class="feature__icon font-size-14 text-tangerine text-lh-xs mb-3">
                                                <i class="glyph-icon flaticon-warranty"></i>
                                            </div>
                                            <div class="media-body text-center">
                                                <h4 class="feature__title font-size-3 text-dark">Money Back Guarantee</h4>
                                                <p class="feature__subtitle m-0 text-dark">Within 30 Days</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-feature py-2 py-md-0 flex-shrink-0 flex-xl-shrink-1">
                                        <div class="media flex-column align-items-center pr-5 pr-lg-0">
                                            <div class="feature__icon font-size-14 text-tangerine text-lh-xs mb-3">
                                                <i class="glyph-icon flaticon-help"></i>
                                            </div>
                                            <div class="media-body text-center">
                                                <h4 class="feature__title font-size-3 text-dark">24/7 Support</h4>
                                                <p class="feature__subtitle m-0 text-dark">Within 1 Business Day</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    '
                ];

            /** */

            $bookworm_blocks[] = [
                'title' => 'Banner #v1',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="d-block">
                            <div class="banners d-md-flex">
                                <div class="slider-banner flex-grow-1 mr-md-3 mr-xl-5 bg-gray-200 p-6 mb-4d875 position-relative overflow-hidden" style="height:250px;">
                                    <div class="z-index-2 position-relative">
                                        <h2 class="slider-banner__title font-size-4 text-lh-md">
                                            <span class="slider-banner__title--1 d-block font-weight-bold">Best Seller</span>
                                            <span class="slider-banner__title--2">Books</span>
                                        </h2>
                                        <a href="#" class="slider-banner__btn text-primary-green text-uppercase font-weight-medium">Purchase</a>
                                    </div>
                                    <img src="https://placehold.it/285x240" class="img-fluid position-absolute bottom-n60 right-n60">
                                </div>
                                <div class="slider-banner flex-grow-1 ml-md-3 ml-xl-0 bg-gray-200 p-6 position-relative overflow-hidden" style="height:250px;">
                                    <div class="z-index-2 position-relative">
                                        <h2 class="slider-banner__title font-size-4 text-lh-md">
                                            <span class="slider-banner__title--1 d-block font-weight-bold">Featured Book</span>
                                            <span class="slider-banner__title--2">of the Month</span>
                                        </h2>
                                        <a href="#" class="slider-banner__btn text-primary-green text-uppercase font-weight-medium">Purchase</a>
                                    </div>
                                    <img src="https://placehold.it/250x225" class="img-fluid position-absolute bottom-0 right-n60">
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v2',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="bg-secondary-gray-800 px-6 py-5 rounded">
                            <div class="media d-block d-lg-flex">
                                <div class="media-body align-self-center mb-4 mb-lg-0">
                                    <p class="banner__pretitle text-uppercase text-gray-400 font-weight-bold">Available Once a Year</p>
                                    <h2 class="banner__title font-size-10 font-weight-bold text-white mb-4">Get 50% off on orders over $139</h2>
                                    <a href="#" class="banner_btn btn btn-wide btn-primary-green text-white">Explore Books</a>
                                </div>
                                <img src="https://placehold.it/450x235" class="img-fluid">
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v3',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                            <div class="col">
                                <div class="mb-5 mb-xl-0 position-relative">
                                    <div class="bg-red-1 height-md-250">
                                        <div class="p-5 pl-lg-6 pr-lg-5 pt-lg-5 pb-lg-5">
                                            <div>
                                                <h2 class="font-size-26 mt-lg-1 text-white text-lh-md">
                                                    <span class="hero__title-line-1 font-weight-bold d-block">Coloring Books</span>
                                                    <span class="hero__title-line-2 font-weight-normal d-block">for adults</span>
                                                </h2>
                                                <a class="h6 font-weight-medium text-white" href="#">Shop Now</a>
                                            </div>
                                            <div class="d-flex d-md-block justify-content-end position-md-absolute bottom-md-30 right-md-30">
                                                <img src="https://placehold.it/150x160" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-5 mb-lg-0 position-relative">
                                    <div class="bg-blue height-md-250">
                                        <div class="p-5 pl-lg-6 pr-lg-5 pt-lg-5 pb-lg-5">
                                            <div class="mb-3 mb-lg-0">
                                                <h2 class="font-size-26 mt-lg-1 text-white text-lh-md">
                                                    <span class="hero__title-line-1 font-weight-bold d-block">New Books</span>
                                                    <span class="hero__title-line-2 font-weight-normal d-block">Available</span>
                                                </h2>
                                                <a class="h6 font-weight-medium text-white" href="#">Shop Now<s/a>
                                            </div>
                                            <div class="d-flex d-md-block justify-content-end position-md-absolute right-md-30 bottom-md-30">
                                                <img src="https://placehold.it/150x160" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="position-relative">
                                    <div class="bg-yellow-1 height-md-250">
                                        <div class="p-5 pl-lg-6 pr-lg-5 pt-lg-5 pb-lg-5">
                                            <div class="mb-4 mb-lg-0">
                                                <h2 class="font-size-26 mt-lg-1 text-white text-lh-md">
                                                    <span class="hero__title-line-1 font-weight-bold d-block">Monthly Selected</span>
                                                    <span class="hero__title-line-2 font-weight-normal d-block">Books<s/span>
                                                </h2>
                                                <a class="h6 font-weight-medium text-white" href="#">Shop Now<s/a>
                                            </div>
                                            <div class="d-flex d-md-block justify-content-end position-md-absolute bottom-md-30 right-md-30">
                                                <img src="https://placehold.it/150x160" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v4',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="row row-cols-lg-2">
                            <div class="col">
                                <div class="bg-gray-200 p-5 mb-5 min-height-450">
                                    <div class="mb-2">
                                        <span class="font-weight-medium h6 text-gray-400">BEST SELLER</span>
                                    </div>
                                    <h6 class="font-weight-bold font-size-7">Books</h6>
                                    <a href="#" class="stretched-link link-black-100 text-dark font-weight-medium">
                                        <span class="product__add-to-cart d-inline-block">Shop Now</span>
                                    </a>
                                    <div class="d-flex justify-content-end mt-4">
                                        <img src="https://placehold.it/230x250" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="bg-gray-200 p-5 min-height-450">
                                    <div class="mb-2">
                                        <span class="font-weight-medium h6 text-gray-400">DEAL OF THE WEEK</span>
                                    </div>
                                    <h6 class="font-weight-bold font-size-7">Made For You</h6>
                                    <a href="#" class="stretched-link link-black-100 text-dark font-weight-medium">
                                        <span class="product__add-to-cart d-inline-block">Shop Book</span>
                                    </a>
                                    <div class="d-flex justify-content-end my-3">
                                        <img src="https://placehold.it/230x200" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                                    </div>
                                    <div class="d-flex align-items-stretch justify-content-between">
                                        <div class="py-2d75 text-primary-home-v3">
                                            <span class="font-weight-medium font-size-3">114</span>
                                            <span class="font-size-2">Days</span>
                                        </div>
                                        <div class="py-2d75 text-primary-home-v3">
                                            <span class="font-weight-medium font-size-3">03</span>
                                            <span class="font-size-2">Hours</span>
                                        </div>
                                        <div class="py-2d75 text-primary-home-v3">
                                            <span class="font-weight-medium font-size-3">60</span>
                                            <span class="font-size-2">Mins</span>
                                        </div>
                                        <div class="py-2d75 text-primary-home-v3">
                                            <span class="font-weight-medium font-size-3">25</span>
                                            <span class="font-size-2">Secs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v5',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="row row-cols-1 row-cols-md-2 mb-5 mb-lg-0">
                            <div class="col">
                                <div class="bg-primary p-3d25 mb-5 mb-md-0 min-height-300 d-flex position-relative">
                                    <div class="border__1 d-flex align-items-center justify-content-center w-100">
                                        <div class="text-center px-2 py-8 px-md-0 py-md-0">
                                            <h6 class="font-weight-bold text-white mb-3">GET FREE NEXTDAY DELIVERY</h6>
                                            <div class="text-lh-sm mb-3">
                                                <div class="font-size-7 text-white font-weight-bold">On orders of $35 </div>
                                                <span class="font-size-7 text-white font-weight-bold">or more.</span>
                                            </div>
                                            <div class="mb-4 mb-md-0">
                                                <a href="#" class="stretched-link text-white h-border-bottom-white h6 font-weight-medium" tabindex="0">Start Shopping</a>
                                            </div>
                                        </div>
                                        <div class="position-absolute bottom-0 left-0 ml-6 mb-1">
                                            <i class="flaticon-delivery font-size-17 text-red-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="bg-gray-780 p-3d25 mb-5 mb-md-0 min-height-300 d-flex position-relative">
                                    <div class="border__1 d-flex align-items-center justify-content-center w-100">
                                        <div class="text-center">
                                            <h6 class="font-weight-bold text-white mb-0">SUMMER SALE </h6>
                                            <span class="font-weight-bold font-size-12 text-gray-260">50%</span>
                                            <div class="">
                                                <a href="#" class="stretched-link text-white h-border-bottom-white h6 font-weight-medium" tabindex="0">Shop now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v6',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="bg-img-hero img-fluid height-300 mb-5 mb-lg-0" style="background-image: url(https://placehold.it/639x300);">
                                    <div class="p-5 px-lg-9 space-top-1 space-top-lg-3">
                                        <h2 class="font-size-7 mb-2 pb-1 text-lh-1dot4">
                                            <span class="hero__title-line-1 font-weight-bold d-block">Feature Book</span>
                                            <span class="hero__title-line-2 font-weight-normal d-block">of the month</span>
                                        </h2>
                                        <a href="#" class="text-uppercase link-black-100 text-dark font-weight-medium">
                                            <span class="product__add-to-cart d-inline-block">Purchase</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="bg-img-hero img-fluid height-300 mb-5 mb-lg-0" style="background-image: url(https://placehold.it/350x300);">
                                    <div class="p-5 pl-lg-6 pt-3 pt-lg-5">
                                        <h2 class="font-size-7 mb-2 pb-1 text-lh-1dot4">
                                            <span class="hero__title-line-1 font-weight-bold d-block">Best Seller</span>
                                            <span class="hero__title-line-2 font-weight-normal d-block">Books</span>
                                        </h2>
                                        <a href="#" class="text-uppercase link-black-100 text-dark font-weight-medium">
                                            <span class="product__add-to-cart d-inline-block">Purchase</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="bg-gray-780 p-3 height-300">
                                    <div class="m-1">
                                        <div class="border__1">
                                            <div class="p-5 pb-8 pb-md-12 pl-lg-5 pt-lg-5 pb-lg-8 pl-xl-7 pt-xl-8 pb-xl-5">
                                                <div class="">
                                                    <h6 class="font-weight-bold text-white font-size-7 mb-0">Summer Sale</h6>
                                                    <span class="font-weight-bold font-size-15 text-gray-260 text-lh-sm">50%</span>
                                                    <div class="">
                                                        <a href="#" class="text-white h-border-bottom-white h6 font-weight-medium pb-1" tabindex="0">PURCHASE</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v7',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="bg-gray-200 space-2">
                        <div class="container">
                            <div class="pt-5 pt-lg-0  h-100">
                                <div class="bg-white p-6 h-100">
                                    <h6 class="font-size-7">Girl, <span class="text-primary font-weight-normal">Wash Your Face</span></h6>
                                    <div class="mb-2">
                                        <span class="font-size-3 text-secondary-gray-700">Rachel Hollis</span>
                                    </div>
                                    <div class="price d-flex align-items-center font-weight-medium font-size-3 mb-2">
                                        <ins class="text-decoration-none mr-2"><span class="woocommerce-Price-amount amount font-size-3 font-weight-medium text-dark"><span class="woocommerce-Price-currencySymbol">$</span>15</span></ins>
                                        <del class="font-size-1 font-weight-regular text-gray-700"><span class="woocommerce-Price-amount amount font-size-1 text-primary-home-v3 opacity-md"><span class="woocommerce-Price-currencySymbol">$</span>78,96</span></del>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <span class="d-inline-block product__add-to-cart">ADD TO CART</span>
                                    </div>
                                    <div>
                                        <img src="https://placehold.it/185x210" class="img-fluid mx-auto d-block mx-auto" alt="image-description">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v8',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="row row-cols-md-2 row-cols-xl-3 row-cols-wd-4">
                            <div class="col">
                                <div class="bg-punch-light rounded-md mb-4 mb-xl-0">
                                    <div class="pr-4 pl-5 py-8 position-relative">
                                        <div class="position-relative z-index-2">
                                            <div class="font-size-4 font-weight-medium position-relative z-index-2">Coloring Books</div>
                                            <div class="font-size-4 mb-2 position-relative z-index-2">for adults</div>
                                            <a href="#" class="stretched-link h-primary">Shop Now</a>
                                        </div>
                                        <img src="https://placehold.it/130x150" class="position-absolute bottom-0 mb-4 mr-4 right-0 d-block attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="bg-punch-light rounded-md mb-4 mb-xl-0">
                                    <div class="pr-4 pl-5 py-8 position-relative">
                                        <div class="position-relative z-index-2">
                                            <div class="font-size-4 font-weight-medium position-relative z-index-2">Best</div>
                                            <div class="font-size-4 mb-2 position-relative z-index-2">Cookbooks</div>
                                            <a href="#" class="stretched-link h-primary">Shop Now</a>
                                        </div>
                                        <img src="https://placehold.it/130x150" class="position-absolute bottom-0 mb-4 mr-4 right-0 d-block attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="bg-punch-light rounded-md mb-4 mb-xl-0">
                                    <div class="pr-4 pl-5 py-8 position-relative">
                                        <div class="position-relative z-index-2">
                                            <div class="font-size-4 font-weight-medium position-relative z-index-2">New Books</div>
                                            <div class="font-size-4 mb-2 position-relative z-index-2">Available</div>
                                            <a href="#" class="stretched-link h-primary">Shop Now</a>
                                        </div>
                                        <img src="https://placehold.it/130x150" class="position-absolute bottom-0 mb-4 mr-4 right-0 d-block attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description">
                                    </div>
                                </div>
                            </div>
                            <div class="col d-xl-none d-wd-block">
                                <div class="bg-punch-light rounded-md mb-4 mb-xl-0">
                                    <div class="pr-4 pl-5 py-8 position-relative">
                                        <div class="font-size-4 font-weight-medium position-relative z-index-2">Monthly Selected</div>
                                        <div class="font-size-4 mb-2 position-relative z-index-2">Books</div>
                                        <a href="#" class="stretched-link h-primary">Shop Now</a>
                                        <img src="https://placehold.it/130x150" class="position-absolute bottom-0 mb-4 mr-4 right-0 d-block attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v9',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="bg-gray-200 space-2">
                        <div class="container-fluid px-3 px-md-5 px-xl-8d75">
                            <div class="row row-cols-md-2 row-cols-xl-3">
                                <div class="col">
                                    <div class="position-relative">
                                        <div class="bg-white height-md-300 mb-5 mb-xl-0">
                                            <div class="p-4 py-lg-6 px-lg-7">
                                                <div class="my-xl-1">
                                                    <div class="position-relative z-index-2">
                                                        <div class="mb-2">
                                                            <span class="font-weight-medium h6 text-gray-400">BEST SELLER</span>
                                                        </div>
                                                        <h6 class="font-weight-bold font-size-7">Books</h6>
                                                        <a href="#" class="link-black-100 text-dark font-weight-medium">
                                                            <span class="product__add-to-cart d-inline-block">Shop Now</span>
                                                        </a>
                                                    </div>
                                                    <div class="d-flex justify-content-end d-md-block position-md-absolute bottom-md-30 right-md-30">
                                                        <img src="https://placehold.it/180x223" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="position-relative">
                                        <div class="bg-white height-md-300 mb-5 mb-lg-0">
                                            <div class="p-4 py-lg-6 px-lg-7">
                                                <div class="my-xl-1">
                                                    <div class="position-relative z-index-2">
                                                        <h2 class="font-size-26 mt-lg-1 text-lh-md">
                                                            <span class="hero__title-line-1 font-weight-bold d-block">New Books</span>
                                                            <span class="hero__title-line-2 font-weight-normal d-block">Available</span>
                                                        </h2>
                                                        <a href="#" class="link-black-100 text-dark font-weight-medium">
                                                            <span class="product__add-to-cart d-inline-block">Shop Now</span>
                                                        </a>
                                                    </div>
                                                    <div class="d-flex justify-content-end d-md-block position-md-absolute bottom-md-30 right-md-30">
                                                        <img src="https://placehold.it/180x223" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="position-relative">
                                        <div class="bg-white height-md-300">
                                            <div class="py-4 px-5 pl-lg-7">
                                                <div class="ml-lg-1">
                                                    <div class="position-relative z-index-2">
                                                        <div class="mb-2">
                                                            <span class="font-weight-medium h6 text-gray-400">DEAL OF THE WEEK</span>
                                                        </div>
                                                        <h6 class="font-weight-bold font-size-7">Made For You</h6>
                                                        <a href="#" class="link-black-100 text-dark font-weight-medium">
                                                            <span class="product__add-to-cart d-inline-block">Shop Book</span>
                                                        </a>
                                                    </div>
                                                    <div class="position-md-absolute bottom-md-30 right-md-30">
                                                        <div class="d-flex justify-content-end d-md-block">
                                                            <img src="https://placehold.it/180x223" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                                                        </div>
                                                    </div>
                                                    <div class="position-md-absolute bottom-md-30">
                                                        <div class="d-flex align-items-stretch">
                                                            <div class="py-2d75 text-primary-home-v3 mr-4">
                                                                <span class="font-weight-medium font-size-3">114</span>
                                                                <span class="font-size-2">Days</span>
                                                            </div>
                                                            <div class="py-2d75 text-primary-home-v3 mr-4">
                                                                <span class="font-weight-medium font-size-3">03</span>
                                                                <span class="font-size-2">Hours</span>
                                                            </div>
                                                            <div class="py-2d75 text-primary-home-v3 mr-4">
                                                                <span class="font-weight-medium font-size-3">60</span>
                                                                <span class="font-size-2">Mins</span>
                                                            </div>
                                                            <div class="py-2d75 text-primary-home-v3">
                                                                <span class="font-weight-medium font-size-3">25</span>
                                                                <span class="font-size-2">Secs</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v10',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="bg-punch-light px-3 px-md-5">
                        <div class="space-1 space-md-3 bg-white">
                            <div class="container">
                                <div class="row row-cols-md-2 row-cols-xl-3 row-cols-wd-4">
                                    <div class="col">
                                        <div class="bg-punch-light rounded-md mb-4 mb-xl-0">
                                            <div class="pr-4 pl-5 py-8 position-relative">
                                                <div class="font-size-4 font-weight-medium position-relative z-index-2">Coloring Books</div>
                                                <div class="font-size-4 mb-2 position-relative z-index-2">for adults</div>
                                                <a href="#" class="stretched-link h-primary">Shop Now</a>
                                                <img src="https://placehold.it/130x150" class="position-absolute bottom-0 mb-4 mr-4 right-0 d-block attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="bg-punch-light rounded-md mb-4 mb-xl-0">
                                            <div class="pr-4 pl-5 py-8 position-relative">
                                                <div class="font-size-4 font-weight-medium position-relative z-index-2">Best</div>
                                                <div class="font-size-4 mb-2 position-relative z-index-2">Cookbooks</div>
                                                <a href="#" class="stretched-link h-primary">Shop Now</a>
                                                <img src="https://placehold.it/130x150" class="position-absolute bottom-0 mb-4 mr-4 right-0 d-block attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="bg-punch-light rounded-md mb-4 mb-xl-0">
                                            <div class="pr-4 pl-5 py-8 position-relative">
                                                <div class="font-size-4 font-weight-medium position-relative z-index-2">New Books</div>
                                                <div class="font-size-4 mb-2 position-relative z-index-2">Available</div>
                                                <a href="#" class="stretched-link h-primary">Shop Now</a>
                                                <img src="https://placehold.it/130x150" class="position-absolute bottom-0 mb-4 mr-4 right-0 d-block attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-xl-none d-wd-block">
                                        <div class="bg-punch-light rounded-md mb-4 mb-xl-0">
                                            <div class="pr-4 pl-5 py-8 position-relative">
                                                <div class="font-size-4 font-weight-medium position-relative z-index-2">Monthly Selected</div>
                                                <div class="font-size-4 mb-2 position-relative z-index-2">Books</div>
                                                <a href="#" class="stretched-link h-primary">Shop Now</a>
                                                <img src="https://placehold.it/130x150" class="position-absolute bottom-0 mb-4 mr-4 right-0 d-block attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="image-description">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v11',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="bg-img-hero img-fluid height-500" style="background-image: url(https://placehold.it/685x500);">
                            <div class="px-6 space-top-3 space-bottom-4 mb-4 mb-lg-0">
                                <div class="pt-lg-4 pb-lg-3">
                                    <p class="banner__pretitle text-uppercase text-gray-400 font-weight-bold">THE BOOKWORM EDITORS’</p>
                                    <h2 class="hero__title font-size-10 mb-4 pb-1">
                                        <span class="hero__title-line-1 font-weight-regular d-block mb-1">Featured Books of</span>
                                        <span class="hero__title-line-2 d-block font-weight-regular">The <span class="font-weight-bold">February</span></span>
                                    </h2>
                                    <a href="#" class="banner_btn rounded-0 btn btn-wide btn-primary text-white">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v12',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="row row-cols-2">
                            <div class="col">
                                <div class="bg-img-hero img-fluid pt-4 space-bottom-3 px-5" style="background-image: url(https://placehold.it/330x235);">
                                    <div class="mb-4">
                                        <div class="mb-1">
                                            <span class="font-weight-medium h6 text-gray-400">BEST SELLER</span>
                                        </div>
                                        <h6 class="font-weight-bold font-size-4 pb-1">Books</h6>
                                        <a href="#" class="link-black-100 text-dark font-weight-medium">
                                            <span class="product__add-to-cart d-inline-block">Shop Now</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="bg-img-hero img-fluid pt-4 space-bottom-1 px-5" style="background-image: url(https://placehold.it/330x235);">
                                    <div class="mb-3 mb-lg-6 mb-xl-3">
                                        <div class="mb-1">
                                            <span class="font-weight-medium h6 text-gray-400">DEAL OF THE WEEK</span>
                                        </div>
                                        <h6 class="font-weight-bold font-size-4">Made For You</h6>
                                        <div class="pb-1">
                                            <a href="#" class="link-black-100 text-dark font-weight-medium">
                                                <span class="product__add-to-cart d-inline-block">Shop Now</span>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-stretch justify-content-between">
                                            <div class="py-2d75">
                                                <span class="font-weight-medium font-size-3">114</span>
                                                <span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline">Days</span>
                                            </div>
                                            <div class="py-2d75">
                                                <span class="font-weight-medium font-size-3">03</span>
                                                <span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline">Hours</span>
                                            </div>
                                            <div class="py-2d75">
                                                <span class="font-weight-medium font-size-3">60</span>
                                                <span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline">Mins</span>
                                            </div>
                                            <div class="py-2d75">
                                                <span class="font-weight-medium font-size-3">25</span>
                                                <span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline">Secs</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v13',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="row row-cols-2">
                            <div class="col">
                                <div class="mb-5">
                                    <div class="bg-img-hero img-fluid bg-gradient-gray-780" style="background-image: url(https://placehold.it/330x235);">
                                        <div class="p-3 mb-5 mb-md-0">
                                            <div class="m-1">
                                                <div class="border__1">
                                                    <div class="p-3 px-lg-5 py-md-5">
                                                        <div class="text-center my-lg-1">
                                                            <h6 class="font-weight-bold text-white mb-0">SUMMER SALE </h6>
                                                            <span class="font-weight-bold font-size-12 text-gray-260">50%</span>
                                                            <div class="">
                                                                <a href="#" class="text-white h-border-bottom-white h6 font-weight-medium pb-1" tabindex="0">Shop now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="bg-primary p-3 mb-5 mb-md-0">
                                    <div class="m-1">
                                        <div class="position-relative">
                                            <div class="border__1">
                                                <div class="py-md-5">
                                                    <div class="text-center mb-lg-1">
                                                        <h6 class="font-weight-bold text-white mb-3">GET FREE NEXTDAY DELIVERY</h6>
                                                        <div class="text-lh-sm mb-3">
                                                            <div class="font-size-4 text-white font-weight-bold">On orders of $35 </div>
                                                            <span class="font-size-4 text-white font-weight-bold">or more.</span>
                                                        </div>
                                                        <div class="">
                                                            <a href="#" class="text-white h-border-bottom-white h6 font-weight-medium" tabindex="0">Start Shopping</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-none d-md-block position-absolute bottom-n14 left-20">
                                                <i class="flaticon-delivery font-size-15 text-red-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v14',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="row row-cols-1 row-cols-lg-2">
                            <div class="col">
                                <div class="bg-gray-200 min-height-300 mb-5 mb-lg-0">
                                    <div class="p-5 pl-lg-8 pr-lg-5 pt-lg-10 pb-lg-5">
                                        <div class="mt-lg-2">
                                            <h2 class="font-size-26 mt-lg-1 text-lh-md">
                                                <span class="hero__title-line-1 font-weight-bold d-block">Feature Book</span>
                                                <span class="hero__title-line-2 font-weight-normal d-block">of the month</span>
                                            </h2>
                                        <div>
                                                <a href="#" class="text-dark font-weight-medium">
                                                    <span class="product__add-to-cart d-inline-block">PURCHASE</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex d-md-block justify-content-end position-md-absolute bottom-md-40 right-md-55">
                                            <img src="https://placehold.it/180x203" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="bg-gray-200 min-height-300">
                                    <div class="p-5 pl-lg-8 pr-lg-5 pt-lg-10 pb-lg-5">
                                        <div class="mt-lg-2">
                                            <h2 class="font-size-26 mt-lg-1 text-lh-md">
                                                <span class="hero__title-line-1 font-weight-bold d-block">Best Seller</span>
                                                <span class="hero__title-line-2 font-weight-normal d-block">Books</span>
                                            </h2>
                                        <div>
                                                <a href="#" class="text-dark font-weight-medium">
                                                    <span class="product__add-to-cart d-inline-block">PURCHASE</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex d-md-block justify-content-end position-md-absolute bottom-md-40 right-md-55">
                                            <img src="https://placehold.it/180x203" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v16',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="bg-gray-200 rounded-md py-4 py-lg-7 px-5 pl-lg-7 pr-lg-6 pb-lg-6 space-bottom-xl-2 mb-5">
                            <div class="pb-xl-3 mb-xl-1">
                                <div class="ml-xl-1">
                                    <div class="mb-2">
                                        <span class="font-weight-medium h6 text-gray-400">BEST SELLER</span>
                                    </div>
                                    <h6 class="font-weight-bold font-size-7">Books</h6>
                                    <a href="#" class="link-black-100 text-dark font-weight-medium">
                                        <span class="product__add-to-cart d-inline-block">Shop Now</span>
                                    </a>
                                    <div class="d-flex justify-content-end">
                                        <img src="https://placehold.it/230x250" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v17',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="bg-primary p-3 mb-5 mb-lg-0 rounded-md">
                            <div class="m-1">
                                <div class="position-relative">
                                    <div class="border__1 rounded-md">
                                        <div class="py-5 space-lg-2">
                                            <div class="text-center mb-lg-1 py-lg-4 py-xl-2">
                                                <h6 class="font-weight-bold text-white mb-3">GET FREE NEXTDAY DELIVERY</h6>
                                                <div class="text-lh-sm mb-3">
                                                    <div class="font-size-7 text-white font-weight-bold">On orders of $35 </div>
                                                    <span class="font-size-7 text-white font-weight-bold">or more.</span>
                                                </div>
                                                <div class="">
                                                    <a href="#" class="text-white h-border-bottom-white h6 font-weight-medium" tabindex="0">Start Shopping</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-none d-md-block position-absolute bottom-n14 left-30">
                                        <i class="flaticon-delivery font-size-17 text-red-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Banner #v18',
                'section' => 'BookWorm Banners',
                'content' => '
                    <div class="container">
                        <div class="position-relative">
                            <div class="bg-gray-200 height-md-470 pt-4 pl-5 pl-lg-7 pt-lg-7 rounded-md">
                                <div class="ml-lg-1">
                                    <div class="space-bottom-1 space-bottom-md-6">
                                        <div class="mb-2">
                                            <span class="font-weight-medium h6 text-gray-400">DEAL OF THE WEEK</span>
                                        </div>
                                        <h6 class="font-weight-bold font-size-7">Made For You</h6>
                                        <a href="#" class="link-black-100 text-dark font-weight-medium">
                                            <span class="product__add-to-cart d-inline-block">Shop Book</span>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-end d-md-block position-md-absolute bottom-md-65 right-0">
                                        <img src="https://placehold.it/250x250" class="img-fluid attachment-shop_catalog size-shop_catalog wp-post-image" alt="image-description">
                                    </div>
                                    <div class="d-flex align-items-stretch pb-1">
                                        <div class="py-2d75 text-primary-home-v3 mr-5">
                                            <span class="font-weight-medium font-size-3">114</span>
                                            <span class="font-size-2">Days</span>
                                        </div>
                                        <div class="py-2d75 text-primary-home-v3 mr-5">
                                            <span class="font-weight-medium font-size-3">03</span>
                                            <span class="font-size-2">Hours</span>
                                        </div>
                                        <div class="py-2d75 text-primary-home-v3 mr-5">
                                            <span class="font-weight-medium font-size-3">60</span>
                                            <span class="font-size-2">Mins</span>
                                        </div>
                                        <div class="py-2d75 text-primary-home-v3">
                                            <span class="font-weight-medium font-size-3">25</span>
                                            <span class="font-size-2">Secs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Deals list #v1',
                'section' => 'BookWorm Deals List',
                'content' => '
                    <div class="container space-1">
                        <div class="products">
                            <div class="product product__card product__card-v2">
                                <div class="px-md-5 py-md-6 p-4 border border-primary border-width-2">
                                    <div class="woocommerce-loop-product__thumbnail py-8 position-relative">
                                        <div class="width-100 height-100 bg-primary rounded-circle d-flex align-items-center flex-wrap justify-content-center text-white position-absolute right-0 top-0">
                                            <div class="text-center">
                                                <div>Save</div>
                                                <div class="font-size-5">$49</div>
                                            </div>
                                        </div>
                                        <a href="#" class="d-block"><img src="https://placehold.it/200x327" class="attachment-shop_catalog size-shop_catalog wp-post-image d-block mx-auto"></a>
                                    </div>
                                    <div class="woocommerce-loop-product__body">
                                        <div class="mb-3">
                                            <div class="text-uppercase font-size-1 mb-1 text-truncate"><a href="#">Kindle Edition</a></div>
                                            <h2 class="woocommerce-loop-product__title font-size-3 text-lh-md mb-2 text-height-2 crop-text-2 h-dark"><a href="#">Dark in Death: An Eve Dallas Novel (In Death, Book 46)</a></h2>
                                            <div class="font-size-2 text-gray-700 mb-1 text-truncate"><a href="#" class="text-gray-700">Nora Roberts</a></div>
                                            <div class="price d-flex align-items-center font-weight-medium font-size-22">
                                                <ins class="text-decoration-none mr-2"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>79</span></ins>
                                                <del class="font-size-1 font-weight-regular text-gray-700"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>99</span></del>
                                            </div>
                                        </div>
                                        <div class="countdown-timer mb-5">
                                            <h5 class="countdown-timer__title font-size-3 mb-3">Hurry Up! <span class="font-weight-regular">Offer ends in:</span></h5>
                                            <div class="d-flex align-items-stretch justify-content-between">
                                                <div class="py-2d75 d-md-flex align-items-center">
                                                    <span class="font-weight-medium font-size-3">114</span>
                                                    <span class="font-size-2 ml-md-2 ml-wd-2 d-xl-block d-wd-inline">Days</span>
                                                </div>
                                                <div class="border-left pr-3 pr-md-0"> </div>
                                                <div class="py-2d75 d-md-flex align-items-center">
                                                    <span class="font-weight-medium font-size-3">03</span>
                                                    <span class="font-size-2 ml-md-2 ml-wd-2 d-xl-block d-wd-inline">Hours</span>
                                                </div>
                                                <div class="border-left pr-3 pr-md-0"> </div>
                                                <div class="py-2d75 d-md-flex align-items-center">
                                                    <span class="font-weight-medium font-size-3">60</span>
                                                    <span class="font-size-2 ml-md-2 ml-wd-2 d-xl-block d-wd-inline">Mins</span>
                                                </div>
                                                <div class="border-left pr-3 pr-md-0"> </div>
                                                <div class="py-2d75 d-md-flex align-items-center">
                                                    <span class="font-weight-medium font-size-3">25</span>
                                                    <span class="font-size-2 ml-md-2 ml-wd-2 d-xl-block d-wd-inline">Secs</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="deal-progress">
                                            <div class="d-flex justify-content-between font-size-2 mb-2d75">
                                                <span>Already Sold: 14</span>
                                                <span>Available: 3</span>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width:82%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="17"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
            ];

            $bookworm_blocks[] = [
                'title' => 'Clients #v1',
                'section' => 'BookWorm Clients',
                'content' => '
                <div class="clients-block clients-v1">
                    <div class="container">
                        <div class="space-1 space-lg-2">
                            <div class="d-lg-flex align-items-center justify-content-between">
                                <div class="text-center mb-5 mb-lg-0">
                                    <img class="img-fluid" src="../../assets/img/150x32/img1.png" alt="Image-Description">
                                </div>
                                <div class="text-center mb-5 mb-lg-0">
                                    <img class="img-fluid" src="../../assets/img/150x32/img2.png" alt="Image-Description">
                                </div>
                                <div class="text-center mb-5 mb-lg-0">
                                    <img class="img-fluid" src="../../assets/img/150x32/img3.png" alt="Image-Description">
                                </div>
                                <div class="text-center mb-5 mb-lg-0">
                                    <img class="img-fluid" src="../../assets/img/150x32/img4.png" alt="Image-Description">
                                </div>
                                <div class="text-center mb-5 mb-lg-0">
                                    <img class="img-fluid" src="../../assets/img/150x32/img6.png" alt="Image-Description">
                                </div>
                                <div class="text-center mb-5 mb-lg-0">
                                    <img class="img-fluid" src="../../assets/img/150x32/img5.png" alt="Image-Description">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                '
            ];
        }


        // For Default & Dark Version
        if ($version == 'default' || $version == 'dark' || $version == 'bookworm') {
            // intro Section (Default Version)
            $introsec = "<div class='pb-mb30'>
                <div class='container " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                    <div class='row'>
                        <div class='col-lg-6 " . ($rtl == 1 ? 'pl-lg-0' : 'pr-lg-0') . "'>
                        <div class='intro-txt'>
                            <span class='section-title'>" . convertUtf8($bs->intro_section_title) . "</span>
                            <h2 class='section-summary'>" . convertUtf8($bs->intro_section_text) . " </h2>";
            if (!empty($bs->intro_section_button_url) && !empty($bs->intro_section_button_text)) {
                $introsec .= "<a href='" . $bs->intro_section_button_url . "' class='intro-btn' target='_blank'><span>" . convertUtf8($bs->intro_section_button_text) . "</span></a>";
            }
            $introsec .= "</div>
                        </div>
                        <div class='col-lg-6 " . ($rtl == 1 ? 'pr-lg-0' : 'pl-lg-0') . " px-md-3 px-0'>
                            <div class='intro-bg' style='background-image: url(" . url('assets/front/img/' . $bs->intro_bg) . ");background-size: cover;'>
                                <a id='play-video' class='video-play-button' href='" . $bs->intro_section_video_link . "'>
                                    <span></span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>";


            $approachsec = "<div class='approach-section " . ($rtl == 1 ? 'pb-rtl' : '') . " pb-mb30'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-6'>
                            <div class='approach-summary'>
                                <span class='section-title'>" . convertUtf8($bs->approach_title) . "</span>
                                <h2 class='section-summary'>" . convertUtf8($bs->approach_subtitle) . "</h2>";
                                if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text)) {
                                    $approachsec .= "<a href='" . $bs->approach_button_url . "' class='boxed-btn' target='_blank'><span>" . convertUtf8($bs->approach_button_text) . "</span></a>";
                                }
                            $approachsec .= "</div>
                        </div>
                        <div class='col-lg-6'>
                            <approach-section>
                                <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                    <div class='non-editable-notice'>
                                        <h3>Non-Editable Area</h3>
                                        Manage From <br><strong>Content Management > Home Page Section > Approach Section</strong>
                                    </div>

                                    <ul class='approach-lists'>";
                                    foreach ($points as $key => $point) {
                                        $approachsec .= "<li class='single-approach' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                                            <div class='approach-icon-wrapper'><i class='" . $point->icon . "'></i></div>
                                            <div class='approach-text'>
                                                <h4>" . convertUtf8($point->title) . "</h4>
                                                <p>";
                                                if (strlen($point->short_text) > 150) {
                                                    $approachsec .= mb_substr($point->short_text,0,150,'utf-8') . "<span style='display: none;'>" . mb_substr($point->short_text,150,null,'utf-8') . "</span>
                                                   <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                } else {
                                                    $approachsec .= $point->short_text;
                                                }
                                                $approachsec .= "</p>
                                            </div>
                                        </li>";
                                    }
                                    $approachsec .= "</ul>
                                </div>
                            </approach-section>
                        </div>
                    </div>
                </div>
            </div>";


            // Service Categories Section (Default Version)
            $scatsec = "<div class='pb-mb30'>
                <div class='container " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                    <div class='service-categories'>
                        <div class='row justify-content-center text-center premade'>
                            <div class='col-lg-6'>
                                <span class='section-title'>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2 class='section-summary'>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                        <service-category-section>
                            <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                <div class='non-editable-notice'>
                                    <h3>Non-Editable Area</h3>
                                    Manage From <br><strong>Content Management > Services > Category</strong>
                                </div>

                                <div class='row premade'>";
                                foreach ($scats as $key => $scategory) {
                                    $scatsec .= "<div class='col-xl-3 col-lg-4 col-sm-6'>
                                                    <div class='single-category'>";
                                    if (!empty($scategory->image)) {
                                        $scatsec .= "<div class='img-wrapper'>
                                                                <img class='lazy' data-src='" . url("assets/front/img/service_category_icons/$scategory->image") . "' alt=''>
                                                            </div>";
                                    }
                                    $scatsec .= "<div class='text'>
                                                            <h4>" . convertUtf8($scategory->name) . "</h4>
                                                            <p>";
                                                            if (strlen($scategory->short_text) > 112) {
                                                                $scatsec .= mb_substr($scategory->short_text,0,112,'utf-8') . "<span style='display: none;'>" . mb_substr($scategory->short_text,112,null,'utf-8') . "</span>
                                                               <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                            } else {
                                                                $scatsec .= $scategory->short_text;
                                                            }
                                                            $scatsec .= "</p>
                                                            <a href='" . route('front.services', ['category' => $scategory->id]) . "' class='readmore'>" . __('View Services') . "</a>
                                                        </div>
                                                    </div>
                                                </div>";
                                }
                                $scatsec .= "</div>
                            </div>
                        </service-category-section>
                    </div>
                </div>
            </div>";


            // Featured Services Section (Default Version)
            $servicesSec = "<section class='services-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center text-center'>
                        <div class='col-lg-6'>
                            <span class='section-title'>" . convertUtf8($bs->service_section_title) . "</span>
                            <h2 class='section-summary'>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                        </div>
                    </div>
                    <services-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Services</strong>
                            </div>

                            <div class='row premade'>";
                            foreach ($services as $service) {
                                $servicesSec .= "<div class='col-lg-4 col-md-6 col-sm-8'>
                                        <div class='services-item mt-30'>
                                            <div class='services-thumb'>
                                                <img class='lazy' data-src='" . url('assets/front/img/services/' . $service->main_image) . "' alt='service' />
                                            </div>
                                            <div class='services-content'>
                                                <a class='title'";
                                                if ($service->details_page_status == 1) {
                                                    $servicesSec .= "href='" . route('front.servicedetails', [$service->slug]) . "'";
                                                }
                                                $servicesSec .= "><h4>" . convertUtf8($service->title) . "</h4></a>
                                                <p>";
                                                if (strlen($service->summary) > 120) {
                                                    $servicesSec .= mb_substr($service->summary,0,120,'utf-8') . "<span style='display: none;'>" . mb_substr($service->summary,120,null,'utf-8') . "</span>
                                                   <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                } else {
                                                    $servicesSec .= $service->summary;
                                                }
                                                $servicesSec .= "</p>";
                                                if ($service->details_page_status == 1) {
                                                    $servicesSec .= "<a href='" . route('front.servicedetails', [$service->slug]) . "'>" . __('Read More') . " <i class='fas fa-plus'></i></a>";
                                                }
                                            $servicesSec .= "</div>
                                        </div>
                                    </div>";
                            }
                            $servicesSec .= "</div>
                        </div>
                    </services-section>
                </div>
            </section>";



            // Featured Portfolios Section (Default Version)
            $portfoliosSec = "<div class='case-section pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center text-center'>
                        <div class='col-lg-6'>
                            <span class='section-title'>" . convertUtf8($bs->portfolio_section_title) . "</span>
                            <h2 class='section-summary'>" . convertUtf8($bs->portfolio_section_text) . "</h2>
                        </div>
                    </div>
                </div>
                <div class='row' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                    <div class='col-md-12'>
                    <portfolios-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Portfolios</strong>
                            </div>

                            <div class='row case-carousel'>";
                foreach ($portfolios as $key => $portfolio) {
                    $portfoliosSec .= "<div class='col-lg-3 mx-0 single-case single-case-bg-1 lazy' data-bg='" . url('assets/front/img/portfolios/featured/' . $portfolio->featured_image) . "'>
                                        <div class='outer-container'>
                                            <div class='inner-container'>
                                            <h4>";
                    $portfoliosSec .= strlen($portfolio->title) > 36 ? mb_substr($portfolio->title, 0, 36, 'utf-8') . '...' : $portfolio->title . "</h4>";
                    if (!empty($portfolio->service)) {
                        $portfoliosSec .= "<p>" . $portfolio->service->title . "</p>";
                    }

                    $portfoliosSec .= "<a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "' class='readmore-btn'><span>" . __('Read More') . "</span></a>;

                                            </div>
                                        </div>
                                    </div>";
                }
                $portfoliosSec .= "</div>
                        </div>
                    </portfolios-section>
                    </div>
                </div>
            </div>";




            // Team Section (Default Version)
            $teamSec = "<div class='team-section section-padding pb-mb30 lazy " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $bs->team_bg) . ");background-size:cover;'>
                <div class='team-content'>
                <div class='container'>
                    <div class='row justify-content-center text-center'>
                        <div class='col-lg-6'>
                            <span class='section-title'>" . convertUtf8($bs->team_section_title) . "</span>
                            <h2 class='section-summary'>" . convertUtf8($bs->team_section_subtitle) . "</h2>
                        </div>
                    </div>
                    <team-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Team Section</strong>
                            </div>

                            <div class='team-carousel common-carousel row'>";
                foreach ($members as $key => $member) {
                    $teamSec .= "<div class='single-team-member col-lg-3 mx-0'>
                                <div class='team-img-wrapper'>
                                    <img class='lazy' data-src='" . url('assets/front/img/members/' . $member->image) . "' alt=''>
                                    <div class='social-accounts'>
                                        <ul class='social-account-lists'>";
                    if (!empty($member->facebook)) {
                        $teamSec .= "<li class='single-social-account'><a href='" . $member->facebook . "'><i class='fab fa-facebook-f'></i></a></li>";
                    }
                    if (!empty($member->twitter)) {
                        $teamSec .= "<li class='single-social-account'><a href='" . $member->twitter . "'><i class='fab fa-twitter'></i></a></li>";
                    }
                    if (!empty($member->linkedin)) {
                        $teamSec .= "<li class='single-social-account'><a href='" . $member->linkedin . "'><i class='fab fa-linkedin-in'></i></a></li>";
                    }
                    if (!empty($member->instagram)) {
                        $teamSec .= "<li class='single-social-account'><a href='" . $member->instagram . "'><i class='fab fa-instagram'></i></a></li>";
                    }
                    $teamSec .= "</ul>
                                    </div>
                                </div>
                                <div class='member-info'>
                                    <h5 class='member-name'>" . convertUtf8($member->name) . "</h5>
                                    <small>" . convertUtf8($member->rank) . "</small>
                                </div>
                                </div>";
                }
                $teamSec .= "</div>
                        </div>
                    </team-section>
                </div>
                </div>
            </div>";


            // Statistics Section (Default Version)
            $statisticSec = "<div class='statistics-section pb-mb30 lazy " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $be->statistics_bg) . ");background-size:cover;' id='statisticsSection'>
                <div class='statistics-container' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                    <div class='container'>
                        <statistics-section>
                            <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                <div class='non-editable-notice'>
                                    <h3>Non-Editable Area</h3>
                                    Manage From <br><strong>Content Management > Home Page Sections > Statistics Sections</strong>
                                </div>

                                <div class='row no-gutters'>";
                                foreach ($statistics as $key => $statistic) {
                                    $statisticSec .= "<div class='col-lg-3 col-md-6'>
                                        <div class='round' data-value='1' data-number='" . convertUtf8($statistic->quantity) . "' data-size='200' data-thickness='6' data-fill='{&quot;color&quot;: &quot;#" . $bs->base_color . "&quot;}'>
                                        <strong></strong>
                                        <h5><i class='" . $statistic->icon . "'></i> " . convertUtf8($statistic->title) . "</h5>
                                        </div>
                                    </div>";
                                }
                                $statisticSec .= "</div>
                            </div>
                        </statistics-section>
                    </div>
                </div>
            </div>";




            // Testimonial Section (Default Version)
            $testimonialSec = "<div class='testimonial-section pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center text-center'>
                        <div class='col-lg-6'>
                            <span class='section-title'>" . convertUtf8($bs->testimonial_title) . "</span>
                            <h2 class='section-summary'>" . convertUtf8($bs->testimonial_subtitle) . "</h2>
                        </div>
                    </div>
                    <div class='row' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                        <div class='col-md-12'>
                            <testimonial-section>
                                <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                    <div class='non-editable-notice'>
                                        <h3>Non-Editable Area</h3>
                                        Manage From <br><strong>Content Management > Home Page Sections > Testimonials</strong>
                                    </div>

                                    <div class='testimonial-carousel row'>";
                    foreach ($testimonials as $key => $testimonial) {
                        $testimonialSec .= "<div class='single-testimonial col-6 mx-0'>
                                                <div class='img-wrapper'><img class='lazy' data-src='" . url('assets/front/img/testimonials/' . $testimonial->image) . "' alt=''></div>
                                                <div class='client-desc'>
                                                    <p class='comment'>" . convertUtf8($testimonial->comment) . "</p>
                                                    <h6 class='name'>" . convertUtf8($testimonial->name) . "</h6>
                                                    <p class='rank'>" . convertUtf8($testimonial->rank) . "</p>
                                                </div>
                                            </div>";
                    }
                    $testimonialSec .= "</div>
                                </div>
                            </testimonial-section>
                        </div>
                    </div>
                </div>
            </div>";




            // Featured Package Section (Default Version)
            $packageSec = "<div class='pricing-tables pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                <div class='row justify-content-center text-center'>
                    <div class='col-lg-6'>
                        <span class='section-title'>" . convertUtf8($be->pricing_title) . "</span>
                        <h2 class='section-summary'>" . convertUtf8($be->pricing_subtitle) . "</h2>
                    </div>
                </div>
                <packages-section>
                    <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                        <div class='non-editable-notice'>
                            <h3>Non-Editable Area</h3>
                            Manage From <br><strong>Package Management > Packages</strong>
                        </div>

                        <div class='pricing-carousel common-carousel row'>";
                    foreach ($packages as $key => $package) {
                        $packageSec .= "<div class='single-pricing-table col-lg-4 mx-0'>
                                    <span class='title'>" . convertUtf8($package->title) . "</span>";
                                    if($bex->recurring_billing == 1) {
                                        $packageSec .= "<small>" . ($package->duration == 'monthly' ? __('Monthly') : __('Yearly')) . "</small>";
                                    }
                                    $packageSec .= "<div class='price'>
                                        <h1>" . ($bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '') . $package->price . ($bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '') . "</h1>
                                    </div>
                                    <div class='features'>" . replaceBaseUrl(convertUtf8($package->description)) . "</div>";

                        if ($package->order_status == 1) {
                            $packageSec .= "<a href='" . route('front.packageorder.index', $package->id) . "' class='pricing-btn'>" . __('Place Order') . "</a>";
                        }

                        $packageSec .= "</div>";
                    }
                    $packageSec .= "</div>
                    </div>
                </packages-section>
                </div>
            </div>";




            // Latest Blogs Section (Default Version)
            $blogSec = "<div class='blog-section section-padding pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center text-center'>
                        <div class='col-lg-6'>
                            <span class='section-title'>" . convertUtf8($bs->blog_section_title) . "</span>
                            <h2 class='section-summary'>" . convertUtf8($bs->blog_section_subtitle) . "</h2>
                        </div>
                    </div>
                    <blogs-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Blogs > Blogs</strong>
                            </div>

                            <div class='blog-carousel common-carousel row'>";
                    foreach ($blogs as $key => $blog) {
                        $blogSec .= "<div class='single-blog col-lg-4 mx-0'>
                                        <div class='blog-img-wrapper'>
                                            <img data-src='" . url('assets/front/img/blogs/' . $blog->main_image) . "' alt='' class='lazy'>
                                        </div>
                                        <div class='blog-txt'>";

                        $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$lang->code");
                        $blogDate = $blogDate->translatedFormat('jS F, Y');


                        $blogSec .= "<p class='date'><small>" . __('By') .  " <span class='username'>" . __('Admin') . "</span></small> | <small>" . $blogDate . "</small> </p>

                                        <h4 class='blog-title'><a href='" . route('front.blogdetails', [$blog->slug]) . "'>" . (strlen($blog->title) > 40 ? mb_substr($blog->title, 0, 40, 'utf-8') . '...' : $blog->title) . "</a></h4>


                                        <p class='blog-summary'>" . (strlen(strip_tags($blog->content)) > 100 ? mb_substr(strip_tags($blog->content), 0, 100, 'utf-8') . '...' : strip_tags($blog->content)) . "</p>


                                        <a href='" . route('front.blogdetails', [$blog->slug]) . "' class='readmore-btn'><span>" . __('Read More') . "</span></a>

                                        </div>
                                    </div>";
                    }
                    $blogSec .= "</div>
                        </div>
                    </blogs-section>
                    </div>
                </div>";



            $ctaSec = "<div class='cta-section pb-mb30 lazy " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $bs->cta_bg) . "); background-size:cover;'>
                <div class='container'>
                    <div class='cta-content'>
                        <div class='row'>
                            <div class='col-md-9 col-lg-7'>
                                <h3>" . convertUtf8($bs->cta_section_text) . "</h3>
                            </div>
                            <div class='col-md-3 col-lg-5 contact-btn-wrapper'>
                                <a href='" . $bs->cta_section_button_url . "' class='boxed-btn contact-btn'><span>" . convertUtf8($bs->cta_section_button_text) . "</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";




            // Partners Section (Default Version)
            $partnerSec = "<div class='partner-section pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container " . ($be->theme_version != 'dark' ? 'top-border' : '') . "'>
                    <div class='row' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                        <div class='col-md-12'>
                            <partner-section>
                                <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                    <div class='non-editable-notice'>
                                        <h3>Non-Editable Area</h3>
                                        Manage From <br><strong>Content Management > Home Page Section > Partners</strong>
                                    </div>

                                    <div class='partner-carousel common-carousel row'>";
                    foreach ($partners as $key => $partner) {
                        $partnerSec .= "<a class='single-partner-item d-block col-lg-3 mx-0' href='" . $partner->url . "' target='_blank'>
                                                <div class='outer-container'>
                                                    <div class='inner-container'>
                                                        <img class='lazy' data-src='" . url('assets/front/img/partners/' . $partner->image) . "' alt=''>
                                                    </div>
                                                </div>
                                            </a>";
                    }
                    $partnerSec .= "</div>
                                </div>
                            </partner-section>
                        </div>
                    </div>
                </div>
            </div>";
        }


        // For Gym Version
        if ($version == 'gym') {
            // Intro Section (Gym Version)
            $introsec = "<section class='finlance_about about_v1 gray_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding:60px 0px;'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-6'>
                            <div class='finlance_box_img'>
                                <div class='finlance_img'>
                                    <img src='" . url('assets/front/img/' . $bs->intro_bg) . "' class='img-fluid' alt=''>
                                </div>
                                <div class='play_box'>
                                    <a href='" . $bs->intro_section_video_link . "' class='play_btn'><i class='fas fa-play'></i></a>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-6'>
                            <div class='finlance_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->intro_section_title) . "</span>
                                    <h2>" . convertUtf8($bs->intro_section_text) . "</h2>
                                    <span class='line-circle'></span>
                                </div>";
            if (!empty($bs->intro_section_button_url) && !empty($bs->intro_section_button_text)) {
                $introsec .= "<div class='button_box'>
                                        <a href='" . $bs->intro_section_button_url . "' class='finlance_btn' target='_blank'>" . convertUtf8($bs->intro_section_button_text) . "</a>
                                    </div>";
            }
            $introsec .= "</div>
                        </div>
                    </div>
                </div>
            </section>";


            // Approach Section (Gym Version)
            $approachsec = "<section class='finlance_we_do we_do_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-6'>
                            <div class='finlance_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->approach_title) . "</span>
                                    <h2>" . convertUtf8($bs->approach_subtitle) . "</h2>
                                    <span class='line-circle'></span>
                                </div>";
            if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text)) {
                $approachsec .= "<div class='button_box'>
                                        <a href='" . $bs->approach_button_url . "' class='finlance_btn'>" . convertUtf8($bs->approach_button_text) . "</a>
                                    </div>";
            }
            $approachsec .= "</div>
                        </div>
                        <div class='col-lg-6'>
                            <div class='finlance_icon_box'>
                                <approach-section>
                                    <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                        <div class='non-editable-notice'>
                                            <h3>Non-Editable Area</h3>
                                            Manage From <br><strong>Content Management > Home Page Section > Approach Section</strong>
                                        </div>";

                                        foreach ($points as $key => $point) {
                                            $approachsec .= "<div class='icon_list d-flex'>
                                                <div class='icon'>
                                                    <i class='" . $point->icon . "'></i>
                                                </div>
                                                <div class='text'>
                                                    <h3>" . convertUtf8($point->title) . "</h3>
                                                    <p>";
                                                    if (strlen($point->short_text) > 150) {
                                                        $approachsec .= mb_substr($point->short_text,0,150,'utf-8') . "<span style='display: none;'>" . mb_substr($point->short_text,150, null,'utf-8') . "</span>
                                                        <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                    } else {
                                                        $approachsec .= convertUtf8($point->short_text);
                                                    }
                                                    $approachsec .= "</p>
                                                </div>
                                            </div>";
                                        }
                                    $approachsec .= "</div>
                                </approach-section>	";
            $approachsec .= "</div>
                        </div>
                    </div>
                </div>
            </section>";

            // Service Categories Section (Gym Version)
            $scatsec = "<section class='finlance_service service_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <service-category-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Category</strong>
                            </div>

                            <div class='service_slide service-slick row'>";
                    foreach ($scats as $key => $scat) {
                        $scatsec .= "<div class='grid_item col-lg-4 mx-0'>
                                        <div class='grid_inner_item'>";
                        if (!empty($scat->image)) {
                            $scatsec .= "<div class='finlance_img'>
                                                    <img data-src='" . url('assets/front/img/service_category_icons/' . $scat->image) . "' class='img-fluid lazy' alt=''>
                                                    <div class='service_overlay'>
                                                        <div class='button_box'>
                                                            <a href='" . route('front.services', ['category' => $scat->id]) . "' class='more_icon'><i class='fas fa-angle-double-right'></i></a>
                                                        </div>
                                                    </div>
                                                </div>";
                        }
                        $scatsec .= "<div class='finlance_content'>
                                                <h3><a href='" . route('front.services', ['category' => $scat->id]) . "'>" . convertUtf8($scat->name) . "</a></h3>
                                            </div>
                                            <div class='summary text-center mt-2'>";
                                                if (strlen(convertUtf8($scat->short_text)) > 112) {
                                                    $scatsec .= mb_substr($scat->short_text,0,112,'utf-8') . "<span style='display: none;'>" . mb_substr($scat->short_text,112, null,'utf-8') . "</span>
                                                    <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                }
                                                else {
                                                    $scatsec .= $scat->short_text;
                                                }
                                            $scatsec .= "</div>
                                        </div>
                                    </div>";
                    }
                    $scatsec .= "</div>
                        </div>
                    </service-category-section>
                </div>
            </section>";

            // Featured Services Section (Gym Version)
            $servicesSec = "<section class='finlance_service service_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <services-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Services</strong>
                            </div>

                            <div class='service_slide service-slick row'>";
                    foreach ($services as $key => $service) {
                        $servicesSec .= "<div class='grid_item col-lg-4 mx-0'>
                                        <div class='grid_inner_item'>";
                        if (!empty($service->main_image)) {
                            $servicesSec .= "<div class='finlance_img'>
                                                    <img class='lazy' data-src='" . url('assets/front/img/services/' . $service->main_image) . "' alt='service' />";
                            if ($service->details_page_status == 1) {
                                $servicesSec .= "<div class='service_overlay'>
                                                            <div class='button_box'>
                                                                <a href='" . route('front.servicedetails', [$service->slug]) . "' class='more_icon'><i class='fas fa-angle-double-right'></i></a>
                                                            </div>
                                                        </div>";
                            }
                            $servicesSec .= "</div>";
                        }
                        $servicesSec .= "<div class='finlance_content'>
                                                <h3><a ";
                        if ($service->details_page_status == 1) {
                            $servicesSec .= " href='" . route('front.servicedetails', [$service->slug]) . "'";
                        }
                        $servicesSec .= ">" . convertUtf8($service->title) . "</a></h3>
                                            </div>
                                            <div class='summary text-center mt-2'>";
                                                if (strlen(convertUtf8($service->summary)) > 112) {
                                                    $servicesSec .= mb_substr($service->summary,0,112,'utf-8') . "<span style='display: none;'>" . mb_substr($service->summary,112, null,'utf-8') . "</span>
                                                    <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                }
                                                else {
                                                    $servicesSec .= $service->summary;
                                                }
                                            $servicesSec .= "</div>
                                        </div>
                                    </div>";
                    }
                    $servicesSec .= "</div>
                        </div>
                    </services-section>
                </div>
            </section>";


            // Featured Portfolios Section (Gym Version)
            $portfoliosSec = "<section class='finlance_project project_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding-bottom: 60px;'>
                <div class='container-full'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->portfolio_section_title) . "</span>
                                <h2>" . convertUtf8($bs->portfolio_section_text) . "</h2>
                            </div>
                        </div>
                    </div>
                    <portfolios-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-propagate=" . '["editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Portfolios</strong>
                            </div>

                            <div class='project_slide project-slick row'>";
                    foreach ($portfolios as $key => $portfolio) {
                        $portfoliosSec .= "<div class='grid_item col-3 px-0 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='finlance_img'>
                                                <img data-src='" . url('assets/front/img/portfolios/featured/' . $portfolio->featured_image) . "' class='img-fluid lazy' alt=''>
                                                <div class='project_overlay'>
                                                    <div class='finlance_content'>
                                                        <a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "' class='more_icon'><i class='fas fa-angle-double-right'></i></a>
                                                        <h3><a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "'>" . (strlen($portfolio->title) > 36 ? mb_substr($portfolio->title, 0, 36, 'utf-8') . '...' : $portfolio->title) . "</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $portfoliosSec .= "</div>
                        </div>
                    </portfolios-section>
                </div>
            </section>";


            // Team Section (Gym Version)
            $teamSec = "<section class='finlance_team team_v1 gray_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->team_section_title) . "</span>
                                <h2>" . convertUtf8($bs->team_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>

                    <team-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Team Section</strong>
                            </div>

                            <div class='team_slide team_slick row'>";
                    foreach ($members as $key => $member) {
                        $teamSec .= "<div class='grid_item col-4 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='finlance_img'>
                                                <img data-src='" . url('assets/front/img/members/' . $member->image) . "' class='img-fluid lazy' alt=''>
                                                <div class='team_overlay'>
                                                    <div class='finlance_content'>
                                                        <h3>" . convertUtf8($member->name) . "</h3>
                                                        <p>" . convertUtf8($member->rank) . "</p>
                                                        <ul class='social_box'>";
                        if (!empty($member->facebook)) {
                            $teamSec .= "<li><a href='" . $member->facebook . "' target='_blank'><i class='fab fa-facebook-f'></i></a></li>";
                        }
                        if (!empty($member->twitter)) {
                            $teamSec .= "<li><a href='" . $member->twitter . "' target='_blank'><i class='fab fa-twitter'></i></a></li>";
                        }
                        if (!empty($member->linkedin)) {
                            $teamSec .= "<li><a href='" . $member->linkedin . "' target='_blank'><i class='fab fa-linkedin-in'></i></a></li>";
                        }
                        if (!empty($member->instagram)) {
                            $teamSec .= "<li><a href='" . $member->instagram . "' target='_blank'><i class='fab fa-instagram'></i></a></li>";
                        }
                        $teamSec .= "</ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $teamSec .= "</div>
                        </div>
                    </team-section>
                </div>
            </section>";


            // Statistics Section (Gym Version)
            $statisticSec = "<section class='finlance_fun finlance_fun_v1 bg_image pb-mb30 lazy " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $be->statistics_bg) . ");background-size:cover; padding: 100px 0px;' id='statisticsSection'>

                <div class='container'>
                    <statistics-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Statistics Sections</strong>
                            </div>

                            <div class='row'>";
                    foreach ($statistics as $key => $statistic) {
                        $statisticSec .= "<div class='col-lg-3 col-md-6 col-sm-12'>
                                        <div class='counter_box'>
                                            <div class='icon'>
                                                <i class='" . $statistic->icon . "'></i>
                                            </div>
                                            <h2><span class='counter'>" . convertUtf8($statistic->quantity) . "</span>+</h2>
                                            <h4>" . convertUtf8($statistic->title) . "</h4>
                                        </div>
                                    </div>";
                    }
                    $statisticSec .= "</div>
                        </div>
                    </statistics-section>
                </div>
            </section>";


            // Testimonial Section (Gym Version)
            $testimonialSec = "<section class='finlance_testimonial testimonial_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->testimonial_title) . "</span>
                                <h2>" . convertUtf8($bs->testimonial_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <testimonial-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Testimonials</strong>
                            </div>

                            <div class='testimonial_slide row'>";
                    foreach ($testimonials as $key => $testimonial) {
                        $testimonialSec .= "<div class='testimonial_box col-12 mx-0'>
                                        <div class='row align-items-center'>
                                            <div class='col-lg-5 col-md-5'>
                                                <div class='finlance_img'>
                                                    <img data-src='" . url('assets/front/img/testimonials/' . $testimonial->image) . "' class='img-fluid lazy' alt=''>
                                                </div>
                                            </div>
                                            <div class='col-lg-7 col-md-7'>
                                                <div class='finlance_content'>
                                                    <img class='lazy' data-src='" . url('assets/front/img/quote.png') . "' alt=''>
                                                    <p>" . convertUtf8($testimonial->comment) . "</p>
                                                    <h3>" . convertUtf8($testimonial->name) . "</h3>
                                                    <h6>" . convertUtf8($testimonial->rank) . "</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $testimonialSec .= "</div>
                        </div>
                    </testimonial-section>
                </div>
            </section>";




            // Featured Package Section (Gym Version)
            $packageSec = "<section class='logistics_pricing pricing_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($be->pricing_title) . "</span>
                                <h2>" . convertUtf8($be->pricing_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <packages-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Package Management > Packages</strong>
                            </div>

                            <div class='pricing_slide pricing_slick row'>";
                    foreach ($packages as $key => $package) {
                        $packageSec .= "<div class='pricing_box text-center col-4 mx-0'>
                                        <div class='pricing_title'>
                                            <h3>" . convertUtf8($package->title) . "</h3>";
                                            if($bex->recurring_billing == 1) {
                                                $packageSec .= "<p>" . ($package->duration == 'monthly' ? __('Monthly') : __('Yearly')) . "</p>";
                                            }
                                        $packageSec .= "</div>
                                        <div class='pricing_price'>
                                            <h3>" . ($bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '') . $package->price . ($bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '') . "</h3>
                                        </div>
                                        <div class='pricing_body'>" . replaceBaseUrl(convertUtf8($package->description)) . "</div>
                                        <div class='pricing_button'>";
                        if ($package->order_status == 1) {
                            $packageSec .= "<a href='" . route('front.packageorder.index', $package->id) . "' class='finlance_btn'>" . __('Place Order') . "</a>";
                        }
                        $packageSec .= "</div>
                                    </div>";
                    }
                    $packageSec .= "</div>
                        </div>
                    </packages-section>
                </div>
            </section>";

            // Latest Blogs Section (Gym Version)
            $blogSec = "<section class='finlance_blog blog_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-6'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->blog_section_title) . "</span>
                                <h2>" . convertUtf8($bs->blog_section_subtitle) . "</h2>
                                <span class='line-circle'></span>
                            </div>
                        </div>
                    </div>
                    <blogs-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Blogs > Blogs</strong>
                            </div>

                            <div class='blog_slide blog_slick row'>";
                    foreach ($blogs as $key => $blog) {
                        $blogSec .= "<div class='grid_item col-4 mx-0'>
                            <div class='grid_inner_item'>
                                <div class='finlance_img'>
                                    <a href='" . route('front.blogdetails', [$blog->slug]) . "'><img data-src='" . url('assets/front/img/blogs/' . $blog->main_image) . "' class='img-fluid lazy' alt=''></a>
                                    <div class='blog-overlay'>
                                        <div class='finlance_content'>";

            $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$lang->code");
            $blogDate = $blogDate->translatedFormat('jS F, Y');

            $blogSec .= "<div class='post_meta'>
                                                <span><i class='far fa-user'></i><a href='#'>" . __('By') . " " . __('Admin') . "</a></span>
                                                <span><i class='far fa-calendar-alt'></i><a href='#'>" . $blogDate . "</a></span>
                                            </div>
                                            <h3 class='post_title'><a href='" . route('front.blogdetails', [$blog->slug]) . "'>" . (strlen($blog->title) > 40 ? mb_substr($blog->title, 0, 40, 'utf-8') . '...' : $blog->title) . "</a></h3>
                                            <p>" . (strlen(strip_tags($blog->content)) > 100 ? mb_substr(strip_tags($blog->content), 0, 100, 'utf-8') . '...' : strip_tags($blog->content)) . "</p>
                                            <a href='" . route('front.blogdetails', [$blog->slug]) . "' class='btn_link'>" . __('Read More') . "</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                    $blogSec .= "</div>
                        </div>
                    </blogs-section>
                </div>
            </section>";



            // CTA Section (Gym Version)
            $ctaSec = "<section class='finlance_cta cta_v1 main_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 70px 0px;'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-8'>
                            <div class='section_title'>
                                <h2 class='text-white'>" . convertUtf8($bs->cta_section_text) . "</h2>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class='button_box'>
                                <a href='" . $bs->cta_section_button_url . "' class='finlance_btn'>" . convertUtf8($bs->cta_section_button_text) . "</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>";


            // Partners Section (Gym Version)
            $partnerSec = "<section class='finlance_partner partner_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 80px 0px;'>
                <div class='container'>
                    <partner-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Partners</strong>
                            </div>

                            <div class='partner_slide row'>";
                            foreach ($partners as $key => $partner) {
                                $partnerSec .= "<div class='single_partner col-3 mx-0'>
                                    <a href='" . $partner->url . "' target='_blank'><img data-src='" . url('assets/front/img/partners/' . $partner->image) . "' class='img-fluid lazy' alt=''></a>
                                </div>";
                            }
                            $partnerSec .= "</div>
                        </div>
                    </partner-section>
                </div>
            </section>";
        }


        // For Car Version
        if ($version == 'car') {

            $introsec = "<section class='finlance_about about_v1 bg_image pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $bs->intro_bg) . ");background-size: cover;padding: 120px 0px;'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-4'>
                            <div class='play_box text-center'>
                                <a href='" . $bs->intro_section_video_link . "' class='play_btn'><i class='fas fa-play'></i></a>
                            </div>
                        </div>
                        <div class='col-lg-8'>
                            <div class='finlance_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->intro_section_title) . "</span>
                                    <h2>" . convertUtf8($bs->intro_section_text) . "</h2>
                                    <span class='line-circle'></span>
                                </div>";
            if (!empty($bs->intro_section_button_url) && !empty($bs->intro_section_button_text)) {
                $introsec .= "<div class='button_box'>
                                        <a href='" . $bs->intro_section_button_url . "' class='finlance_btn'>" . convertUtf8($bs->intro_section_button_text) . "</a>
                                    </div>";
            }
            $introsec .= "</div>
                        </div>
                    </div>
                </div>
            </section>";

            $approachsec = "<section class='finlance_we_do we_do_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-6'>
                            <div class='finlance_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->approach_title) . "</span>
                                    <h2>" . convertUtf8($bs->approach_subtitle) . "</h2>
                                    <span class='line-circle'></span>
                                </div>";
            if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text)) {
                $approachsec .= "<div class='button_box'>
                                        <a href='" . $bs->approach_button_url . "' class='finlance_btn'>" . convertUtf8($bs->approach_button_text) . "</a>
                                    </div>";
            }
            $approachsec .= "</div>
                        </div>
                        <div class='col-lg-6'>
                            <approach-section>
                                <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                    <div class='non-editable-notice'>
                                        <h3>Non-Editable Area</h3>
                                        Manage From <br><strong>Content Management > Home Page Section > Approach Section</strong>
                                    </div>

                                    <div class='finlance_icon_box'>";
                                    foreach ($points as $key => $point) {
                                        $approachsec .= "<div class='icon_list d-flex'>
                                            <div class='icon'>
                                                <i class='" . $point->icon . "'></i>
                                            </div>
                                            <div class='text'>
                                                <h4>" . convertUtf8($point->title) . "</h4>
                                                <p>";
                                                    if (strlen($point->short_text) > 150) {
                                                        $approachsec .= mb_substr($point->short_text,0,150,'utf-8') . "<span style='display: none;'>" . mb_substr($point->short_text,150, null,'utf-8') . "</span>
                                                        <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                    } else {
                                                        $approachsec .= convertUtf8($point->short_text);
                                                    }
                                                $approachsec .= "</p>
                                            </div>
                                        </div>";
                                    }
                                    $approachsec .= "</div>
                                </div>
                            </approach-section>
                        </div>
                    </div>
                </div>
            </section>";

            // Service Categories Section (Car Version)
            $scatsec = "<section class='finlance_service service_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center' style='margin-bottom: 70px;'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <service-category-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Category</strong>
                            </div>

                            <div class='row'>";
                            foreach ($scats as $key => $scat) {
                                $scatsec .= "<div class='col-lg-4 col-md-6 col-sm-12 mb-5' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                                                <div class='grid_item text-center'>
                                                    <div class='grid_inner_item'>";
                                if (!empty($scat->image)) {
                                    $scatsec .= "<div class='finlance_icon'>
                                        <img data-src='" . url('assets/front/img/service_category_icons/' . $scat->image) . "' class='img-fluid lazy' alt=''>
                                    </div>";
                                }
                                $scatsec .= "<div class='finlance_content'>
                                                            <h4>" . convertUtf8($scat->name) . "</h4>
                                                    <p>";
                                                        if (strlen(convertUtf8($scat->short_text)) > 112) {
                                                            $scatsec .= mb_substr($scat->short_text,0,112,'utf-8') . "<span style='display: none;'>" . mb_substr($scat->short_text,112, null,'utf-8') . "</span>
                                                            <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                        }
                                                        else {
                                                            $scatsec .= $scat->short_text;
                                                        }
                                                    $scatsec .= "</p>
                                                            <a href='" . route('front.services', ['category' => $scat->id]) . "' class='btn_link'>" . __('View Services') . "</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                            }
                            $scatsec .= "</div>
                        </div>
                    </service-category-section>
                </div>
            </section>";


            // Featured Services Section (Car Version)
            $servicesSec = "<section class='finlance_service service_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center' style='margin-bottom: 70px;'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>

                    <services-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Services</strong>
                            </div>

                            <div class='row'>";
                    foreach ($services as $key => $service) {
                        $servicesSec .= "<div class='col-lg-4 col-md-6 col-sm-12 mb-5'>
                                        <div class='grid_item text-center'>
                                            <div class='grid_inner_item'>";
                        if (!empty($service->main_image)) {
                            $servicesSec .= "<div class='finlance_icon' style='margin-bottom: 20px;'>
                                                        <img class='lazy' data-src='" . url('assets/front/img/services/' . $service->main_image) . "' alt='service' />
                                                    </div>";
                        }
                        $servicesSec .= "<div class='finlance_content'>
                                                    <h4>" . convertUtf8($service->title) . "</h4>
                                                    <p>";
                                                    if (strlen(convertUtf8($service->summary)) > 100) {
                                                        $servicesSec .= mb_substr($service->summary,0,100,'utf-8') . "<span style='display: none;'>" . mb_substr($service->summary,100, null,'utf-8') . "</span>
                                                        <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                    }
                                                    else {
                                                        $servicesSec .= $service->summary;
                                                    }
                                                    $servicesSec .= "</p>";
                        if ($service->details_page_status == 1) {
                            $servicesSec .= "<a href='" . route('front.servicedetails', [$service->slug]) . "' class='btn_link'>" . __('Read More') . "</a>";
                        }
                        $servicesSec .= "</div>
                                            </div>
                                        </div>
                                    </div>";
                    }

                    $servicesSec .= "</div>
                        </div>
                    </services-section>
                </div>
            </section>";



            // Featured Portfolios Section (Car Version)
            $portfoliosSec = "<section class='finlance_project project_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding-bottom: 60px;'>
                <div class='container-full'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center' style='margin-bottom: 70px;'>
                                <span>" . convertUtf8($bs->portfolio_section_title) . "</span>
                                <h2>" . convertUtf8($bs->portfolio_section_text) . "</h2>
                            </div>
                        </div>
                    </div>

                    <portfolios-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-propagate=" . '["editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Portfolios</strong>
                            </div>

                            <div class='project_slide project_slick'>";
                    foreach ($portfolios as $key => $portfolio) {
                        $portfoliosSec .= "<div class='grid_item'>
                                        <div class='grid_inner_item'>
                                            <div class='finlance_img'>
                                                <img data-src='" . url('assets/front/img/portfolios/featured/' . $portfolio->featured_image) . "' class='img-fluid lazy' alt=''>
                                                <div class='project_overlay'>
                                                    <div class='finlance_content'>
                                                        <a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "' class='more_icon'><i class='fas fa-angle-double-right'></i></a>

                                                        <h3><a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "'>" . (strlen($portfolio->title) > 25 ? mb_substr($portfolio->title, 0, 25, 'utf-8') . '...' : $portfolio->title) . "</a></h3>";


                        if (!empty($portfolio->service)) {
                            $portfoliosSec .= "<p>" . convertUtf8($portfolio->service->title) . "</p>";
                        }
                        $portfoliosSec .= "</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $portfoliosSec .= "</div>
                        </div>
                    </portfolios-section>
                </div>
            </section>";


            // Team Section (Car Version)
            $teamSec = "<section class='finlance_team team_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center' style='margin-bottom: 70px;'>
                                <span>" . convertUtf8($bs->team_section_title) . "</span>
                                <h2>" . convertUtf8($bs->team_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <team-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Team Section</strong>
                            </div>

                            <div class='team_slide team_slick row'>";
                    foreach ($members as $key => $member) {
                        $teamSec .= "<div class='grid_item col-4 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='finlance_img'>
                                                <img data-src='" . url('assets/front/img/members/' . $member->image) . "' class='img-fluid lazy' alt=''>
                                                <div class='team_overlay'>
                                                    <ul class='social_box'>";
                        if (!empty($member->facebook)) {
                            $teamSec .= "<li><a href='" . $member->facebook . "' target='_blank'><i class='fab fa-facebook-f'></i></a></li>";
                        }
                        if (!empty($member->twitter)) {
                            $teamSec .= "<li><a href='" . $member->twitter . "' target='_blank'><i class='fab fa-twitter'></i></a></li>";
                        }
                        if (!empty($member->linkedin)) {
                            $teamSec .= "<li><a href='" . $member->linkedin . "' target='_blank'><i class='fab fa-linkedin-in'></i></a></li>";
                        }
                        if (!empty($member->instagram)) {
                            $teamSec .= "<li><a href='" . $member->instagram . "' target='_blank'><i class='fab fa-instagram'></i></a></li>";
                        }
                        $teamSec .= "</ul>
                                                </div>
                                            </div>
                                            <div class='finlance_content lazy' data-bg='" . url('assets/front/img/pattern_bg.jpg') . "'>
                                                <h4>" . convertUtf8($member->name) . "</h4>
                                                <p>" . convertUtf8($member->rank) . "</p>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $teamSec .= "</div>
                        </div>
                    </team-section>
                </div>
            </section>";


            // Statistics Section (Car Version)
            $statisticSec = "<section class='finlance_fun finlance_fun_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/pattern_bg_2.jpg') . ");padding: 100px 0px;'>
                <div class='container'>
                    <statistics-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Statistics Sections</strong>
                            </div>

                            <div class='row'>";
                            foreach ($statistics as $key => $statistic) {
                                $statisticSec .= "<div class='col-lg-3 col-md-6 col-sm-12'>
                                    <div class='counter_box'>
                                        <div class='icon'>
                                            <i class='" . $statistic->icon . "'></i>
                                        </div>
                                        <h2><span class='counter'>" . convertUtf8($statistic->quantity) . "</span>+</h2>
                                        <h4>" . convertUtf8($statistic->title) . "</h4>
                                    </div>
                                </div>";
                            }
                            $statisticSec .= "</div>
                        </div>
                    </statistics-section>
                </div>
            </section>";




            // Testimonial Section (Car Version)
            $testimonialSec = "<section class='finlance_testimonial testimonial_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center' style='margin-bottom: 75px;'>
                                <span>" . convertUtf8($bs->testimonial_title) . "</span>
                                <h2>" . convertUtf8($bs->testimonial_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <testimonial-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Testimonials</strong>
                            </div>

                            <div class='testimonial_slide'>";
                            foreach ($testimonials as $key => $testimonial) {
                                $testimonialSec .= "<div class='testimonial_box'>
                                    <div class='quote'>
                                        <img class='lazy' data-src='" . url('assets/front/img/quote.png') . "' alt=''>
                                    </div>
                                    <div class='client_box'>
                                        <div class='thumb'>
                                            <img class='lazy' data-src='" . url('assets/front/img/testimonials/' . $testimonial->image) . "' alt=''>
                                        </div>
                                        <div class='info'>
                                            <h3>" . convertUtf8($testimonial->name) . "</h3>
                                            <h6>" . convertUtf8($testimonial->rank) . "</h6>
                                        </div>
                                    </div>
                                    <div class='finlance_content'>
                                        <p>" . convertUtf8($testimonial->comment) . "</p>
                                    </div>
                                </div>";
                            }
                            $testimonialSec .= "</div>
                        </div>
                    </testimonial-section>
                </div>
            </section>";




            // Featured Package Section (Car Version)
            $packageSec = "<section class='finlance_pricing pricing_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='pricing-bg' style='background-image: url(" . url('assets/front/img/' . $be->package_background) . "); background-size: cover;'>
                </div>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center' style='margin-bottom: 60px;'>
                                <span>" . convertUtf8($be->pricing_title) . "</span>
                                <h2>" . convertUtf8($be->pricing_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <packages-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Package Management > Packages</strong>
                            </div>

                            <div class='pricing_slide pricing_slick row'>";
                    foreach ($packages as $key => $package) {
                        $packageSec .= "<div class='pricing_box text-center col-4 mx-0'>
                                        <div class='pricing_title'>
                                            <h3>" . convertUtf8($package->title) . "</h3>
                                        </div>
                                        <div class='pricing_price'>
                                            <h2>" . ($bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '') . $package->price . ($bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '') . "</h2>";
                                            if($bex->recurring_billing == 1) {
                                                $packageSec .= "<p>" . ($package->duration == 'monthly' ? __('Monthly') : __('Yearly')) . "</p>";
                                            }
                                        $packageSec .= "</div>
                                        <div class='pricing_body'>" . replaceBaseUrl(convertUtf8($package->description)) . "</div>
                                        <div class='pricing_button'>";
                        if ($package->order_status == 1) {
                            $packageSec .= "<a href='" . route('front.packageorder.index', $package->id) . "' class='finlance_btn'>" . __('Place Order') . "</a>";
                        }
                        $packageSec .= "</div>
                                    </div>";
                    }
                    $packageSec .= "</div>
                        </div>
                    </packages-section>
                </div>
            </section>";


            // Latest Blogs Section (Car Version)
            $blogSec = "<section class='finlance_blog blog_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6'>
                            <div class='section_title text-center mb-70'>
                                <span>" . convertUtf8($bs->blog_section_title) . "</span>
                                <h2>" . convertUtf8($bs->blog_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <blogs-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Blogs > Blogs</strong>
                            </div>

                            <div class='blog_slide row'>";
                    foreach ($blogs as $key => $blog) {
                        $blogSec .= "<div class='grid_item col-12 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='row align-items-end no-gutters'>
                                                <div class='col-lg-6'>
                                                    <div class='finlance_content'>";

                        $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$lang->code");
                        $blogDate = $blogDate->translatedFormat('jS F, Y');

                        $blogSec .= "<div class='post_meta'>
                                                            <span><i class='far fa-user'></i><a href='#'>" . __('By') . " " . __('Admin') . "</a></span>
                                                            <span><i class='far fa-calendar-alt'></i><a href='#'>" . $blogDate . "</a></span>
                                                        </div>
                                                        <h3 class='post_title'><a href='" . route('front.blogdetails', [$blog->slug]) . "'>" . (strlen($blog->title) > 40 ? mb_substr($blog->title, 0, 40, 'utf-8') . '...' : $blog->title) . "</a></h3>
                                                        <p>" . (strlen(strip_tags($blog->content)) > 100 ? mb_substr(strip_tags($blog->content), 0, 100, 'utf-8') . '...' : strip_tags($blog->content)) . "</p>
                                                        <a href='" . route('front.blogdetails', [$blog->slug]) . "' class='finlance_btn'>" . __('Read More') . "</a>
                                                    </div>
                                                </div>
                                                <div class='col-lg-6'>
                                                    <div class='finlance_img'>
                                                        <a href='" . route('front.blogdetails', [$blog->slug]) . "'><img data-src='" . url('assets/front/img/blogs/' . $blog->main_image) . "' class='img-fluid lazy' alt='' width='100%'></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $blogSec .= "</div>
                        </div>
                    </blogs-section>
                </div>
            </section>";



            // CTA Section (Car Version)
            $ctaSec = "<section class='finlance_cta cta_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/pattern_bg_2.jpg') . "); background-size: cover; padding: 70px 0px;'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-8'>
                            <div class='section_title'>
                                <h2>" . convertUtf8($bs->cta_section_text) . "</h2>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class='button_box'>
                                <a href='" . $bs->cta_section_button_url . "' class='finlance_btn'>" . convertUtf8($bs->cta_section_button_text) . "</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>";

            // Partners Section (Car Version)
            $partnerSec = "<section class='finlance_partner partner_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 100px 0px;'>
                <div class='container'>
                    <partner-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Partners</strong>
                            </div>

                            <div class='partner_slide row'>";
                            foreach ($partners as $key => $partner) {
                                $partnerSec .= "<div class='single_partner col-3 mx-0'>
                                    <a href='" . $partner->url . "' target='_blank'><img data-src='" . url('assets/front/img/partners/' . $partner->image) . "' class='img-fluid lazy' alt=''></a>
                                </div>";
                            }
                            $partnerSec .= "</div>
                        </div>
                    </partner-section>
                </div>
            </section>";
        }


        // For Cleaning Version
        if ($version == 'cleaning') {

            // Intro Section (Cleaning Version)
            $introsec = "<section class='project-video-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                    <div class='container'>
                        <div class='row justify-content-center'>
                            <div class='col-lg-8'>
                                <div class='section-title-one text-center'>
                                    <span>" . convertUtf8($bs->intro_section_title) . "</span>
                                    <h1>" . convertUtf8($bs->intro_section_text) . "</h1>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class='video-content' style='background-image: url(" . url('assets/front/img/' . $bs->intro_bg) . "); background-size:cover;'>
                                    <a href='" . $bs->intro_section_video_link . "' class='play-btn video-popup'><i class='fa fa-play'></i></a>
                                </div>";
            if (!empty($bs->intro_section_button_url) && !empty($bs->intro_section_button_text)) {
                $introsec .= "<div class='video-btn-area'>
                                    <a href='" . $bs->intro_section_button_url . "' class='main-btn video-btn' target='_blank'>" . convertUtf8($bs->intro_section_button_text) . "</a>
                                </div>";
            }
            $introsec .= "</div>
                        </div>
                    </div>
                </section>";



            // Approach Section (Cleaning Version)
            $approachsec = "<section class='about-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-6'>
                            <div class='section-title-two'>
                                <span>" . convertUtf8($bs->approach_title) . "</span>
                                <h1>" . convertUtf8($bs->approach_subtitle) . "</h1>
                            </div>";
            if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text)) {
                $approachsec .= "<div class='button_box'>
                                    <a href='" . $bs->approach_button_url . "' class='main-btn about-btn'>" . convertUtf8($bs->approach_button_text) . "</a>
                                </div>";
            }
            $approachsec .= "</div>
                        <div class='col-lg-6'>
                        <approach-section>
                            <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                <div class='non-editable-notice'>
                                    <h3>Non-Editable Area</h3>
                                    Manage From <br><strong>Content Management > Home Page Section > Approach Section</strong>
                                </div>";
                                foreach ($points as $key => $point) {
                                    $approachsec .= "<div class='single-about-item'>
                                        <p  class='bg-1' style='color: #" . $point->color . "; background: #" . $point->color . "2a;'><span><i class='" . $point->icon . "'></i></span></p>
                                        <h4>" . convertUtf8($point->title) . "
                                        <span>";
                                            if (strlen($point->short_text) > 150) {
                                                $approachsec .= mb_substr($point->short_text,0,150,'utf-8') . "<span style='display: none;'>" . mb_substr($point->short_text,150, null,'utf-8') . "</span>
                                                <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                            } else {
                                                $approachsec .= convertUtf8($point->short_text);
                                            }
                                        $approachsec .= "</span>
                                        </h4>
                                    </div>";
                                }
                            $approachsec .= "</div>
                        </approach-section>
                        </div>
                    </div>
                </div>
            </section>";


            // Service Categories Section (Cleaning Version)
            $scatsec = "<section class='service-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 0;'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-8'>
                            <div class='section-title-one text-center'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h1>" . convertUtf8($bs->service_section_subtitle) . "</h1>
                            </div>
                        </div>
                    </div>
                    <service-category-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Category</strong>
                            </div>

                            <div class='service-carousel-active service-slick row'>";

                    foreach ($scats as $key => $scat) {
                        $scatsec .= "<div class='single-service-item col-4 mx-0'>";
                        if (!empty($scat->image)) {
                            $scatsec .= "<div class='single-service-bg'>
                                                <img data-src='" . url('assets/front/img/service_category_icons/' . $scat->image) . "' class='img-fluid lazy' alt=''>
                                                <span><i class='fas fa-quidditch'></i></span>
                                                <div class='single-service-link'>
                                                    <a href='" . route('front.services', ['category' => $scat->id]) . "' class='main-btn service-btn'>" . __('View Services') . "</a>
                                                </div>
                                            </div>
                                            <div class='single-service-content'>
                                                <h4>" . convertUtf8($scat->name) . "</h4>
                                                <p>";
                                                    if (strlen(convertUtf8($scat->short_text)) > 100) {
                                                        $scatsec .= mb_substr($scat->short_text,0,100,'utf-8') . "<span style='display: none;'>" . mb_substr($scat->short_text,100, null,'utf-8') . "</span>
                                                        <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                    }
                                                    else {
                                                        $scatsec .= $scat->short_text;
                                                    }
                                                $scatsec .= "</p>
                                            </div>";
                        }
                        $scatsec .= "</div>";
                    }


                    $scatsec .= "</div>
                        </div>
                    </service-category-section>
                </div>
            </section>";


            // Featured Services Section (Cleaning Version)
            $servicesSec = "<section class='service-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 0;'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-8'>
                            <div class='section-title-one text-center'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h1>" . convertUtf8($bs->service_section_subtitle) . "</h1>
                            </div>
                        </div>
                    </div>
                    <services-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Services</strong>
                            </div>

                            <div class='service-carousel-active service-slick row'>";

                    foreach ($services as $key => $service) {
                        $servicesSec .= "<div class='single-service-item col-4 mx-0'>";
                        if (!empty($service->main_image)) {
                            $servicesSec .= "<div class='single-service-bg'>
                                                    <img class='lazy' data-src='" . url('assets/front/img/services/' . $service->main_image) . "' alt=''>
                                                    <span><i class='fas fa-quidditch'></i></span>";
                            if ($service->details_page_status == 1) {
                                $servicesSec .= "<div class='single-service-link'>
                                                            <a href='" . route('front.servicedetails', [$service->slug]) . "' class='main-btn service-btn'>" . __('View More') . "</a>
                                                        </div>";
                            }
                            $servicesSec .= "</div>
                                                <div class='single-service-content'>
                                                    <h4>" . convertUtf8($service->title) . "</h4>
                                                    <p>";
                                                    if (strlen(convertUtf8($service->summary)) > 100) {
                                                        $servicesSec .= mb_substr($service->summary,0,100,'utf-8') . "<span style='display: none;'>" . mb_substr($service->summary,100, null,'utf-8') . "</span>
                                                        <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                    }
                                                    else {
                                                        $servicesSec .= $service->summary;
                                                    }
                                                    $servicesSec .= "</p>
                                                </div>";
                        }
                        $servicesSec .= "</div>";
                    }

                    $servicesSec .= "</div>
                        </div>
                    </services-section>
                </div>
            </section>";

            // Featured Portfolios Section (Cleaning Version)
            $portfoliosSec = "<section class='project-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-8'>
                            <div class='section-title-two'>
                                <span>" . convertUtf8($bs->portfolio_section_title) . "</span>
                                <h1>" . convertUtf8($bs->portfolio_section_text) . "</h1>
                            </div>
                        </div>
                        <div class='col-lg-4 text-right'>
                            <a href='" . route('front.portfolios') . "' class='project-btn'>" . __('View More') . " <i class='fa fa-arrow-right'></i></a>
                        </div>
                    </div>
                </div>
                <div class='container-fluid'>
                    <portfolios-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Portfolios</strong>
                            </div>

                            <div class='project-slider-active project-slick row'>";
                    foreach ($portfolios as $key => $portfolio) {
                        $portfoliosSec .= "<div class='single-project-item col-3 mx-0'>
                                        <img class='lazy' data-src='" . url('assets/front/img/portfolios/featured/' . $portfolio->featured_image) . "' alt=''>
                                        <div class='project-link text-center'>
                                            <h4>" . (strlen($portfolio->title) > 36 ? mb_substr($portfolio->title, 0, 36, 'utf-8') . '...' : $portfolio->title) . "</h4>";
                        if (!empty($portfolio->service)) {
                            $portfoliosSec .= "<span>" . convertUtf8($portfolio->service->title) . "</span>";
                        }
                        $portfoliosSec .= "<a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "' class='main-btn project-link-btn'>" . __('View Details') . "</a>
                                        </div>
                                    </div>";
                    }
                    $portfoliosSec .= "</div>
                        </div>
                    </portfolios-section>
                </div>
            </section>";

            // Featured Team Section (Cleaning Version)
            $teamSec = "<section class='team-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-8'>
                            <div class='section-title-one text-center'>
                                <span>" . convertUtf8($bs->team_section_title) . "</span>
                                <h1>" . convertUtf8($bs->team_section_subtitle) . "</h1>
                            </div>
                        </div>
                    </div>
                    <team-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Team Section</strong>
                            </div>

                            <div class='team-carousel-active team-slick row'>";
                    foreach ($members as $key => $member) {
                        $teamSec .= "<div class='single-team-item col-4 mx-0'>
                                        <img class='lazy' data-src='" . url('assets/front/img/members/' . $member->image) . "' alt=''>
                                        <div class='single-team-content'>
                                            <div class='single-team-member-details'>
                                                <h4>" . convertUtf8($member->name) . "</h4>
                                                <p>" . convertUtf8($member->rank) . "</p>
                                            </div>
                                            <ul class='team-social-links'>";
                        if (!empty($member->facebook)) {
                            $teamSec .= "<li><a href='" . $member->facebook . "' target='_blank'><i class='fab fa-facebook-f'></i></a></li>";
                        }
                        if (!empty($member->twitter)) {
                            $teamSec .= "<li><a href='" . $member->twitter . "' target='_blank'><i class='fab fa-twitter'></i></a></li>";
                        }
                        if (!empty($member->linkedin)) {
                            $teamSec .= "<li><a href='" . $member->linkedin . "' target='_blank'><i class='fab fa-linkedin-in'></i></a></li>";
                        }
                        if (!empty($member->instagram)) {
                            $teamSec .= "<li><a href='" . $member->instagram . "' target='_blank'><i class='fab fa-instagram'></i></a></li>";
                        }
                        $teamSec .= "</ul>
                                        </div>
                                    </div>";
                    }
                    $teamSec .= "</div>
                        </div>
                    </team-section>
                </div>
            </section>";


            // Counter Section (Cleaning Version)
            $statisticSec = "<section class='project-counter-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $be->statistics_bg) . "); background-size: cover; padding: 100px 0px;'>
                <div class='container'>
                    <statistics-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Statistics Sections</strong>
                            </div>

                            <div class='row'>";
                            foreach ($statistics as $key => $statistic) {
                                $statisticSec .= "<div class='col-lg-3 col-md-6'>
                                    <div class='single-counter-item'>
                                        <span><i class='" . $statistic->icon . "'></i></span>
                                        <h1><span class='count'>" . convertUtf8($statistic->quantity) . "</span>   +</h1>
                                        <p>" . convertUtf8($statistic->title) . "</p>
                                    </div>
                                </div>";
                            }
                            $statisticSec .= "</div>
                        </div>
                    </statistics-section>
                </div>
            </section>";


            // Testimonial Section (Cleaning Version)
            $testimonialSec = "<section class='testimonial-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-8'>
                            <div class='section-title-one text-center'>
                                <span>" . convertUtf8($bs->testimonial_title) . "</span>
                                <h1>" . convertUtf8($bs->testimonial_subtitle) . "</h1>
                            </div>
                        </div>
                    </div>
                    <testimonial-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Testimonials</strong>
                            </div>

                            <div class='testimonial-active'>";
                    foreach ($testimonials as $key => $testimonial) {
                        $testimonialSec .= "<div class='single-testimonial-item'>
                                        <div class='testimonial-author-img'>
                                            <img data-src='" . url('assets/front/img/testimonials/' . $testimonial->image) . "' class='img-fluid lazy' alt=''>
                                        </div>
                                        <div class='testimonial-author-details'>
                                            <h4>" . convertUtf8($testimonial->name) . " <span>" . convertUtf8($testimonial->rank) . "</span></h4>
                                            <p>" . convertUtf8($testimonial->comment) . "</p>
                                        </div>
                                    </div>";
                    }
                    $testimonialSec .= "</div>
                        </div>
                    </testimonial-section>
                </div>
            </section>";

            // Featured Package Section (Cleaning Version)
            $packageSec = "<section class='price-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-8'>
                            <div class='section-title-one text-center'>
                                <span>" . convertUtf8($be->pricing_title) . "</span>
                                <h1>" . convertUtf8($be->pricing_subtitle) . "</h1>
                            </div>
                        </div>
                    </div>
                    <packages-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Package Management > Packages</strong>
                            </div>

                            <div class='price-carousel-active pricing-slick row'>";
                    foreach ($packages as $key => $package) {
                        $packageSec .= "<div class='single-price-item text-center col-4 mx-0'>
                                        <div class='price-heading'>
                                            <h3>" . convertUtf8($package->title) . "</h3>";
                                            if($bex->recurring_billing == 1) {
                                                $packageSec .= "<p>" . ($package->duration == 'monthly' ? __('Monthly') : __('Yearly')) . "</p>";
                                            }
                                        $packageSec .= "</div>
                                        <h1 class='bg-1' style='background: #" . $package->color . ";'>" . ($bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '') . $package->price . ($bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '') . "</h1>
                                        <div class='price-cata mb-4'>" . replaceBaseUrl(convertUtf8($package->description)) . "</div>";
                        if ($package->order_status == 1) {
                            $packageSec .= "<a href='" . route('front.packageorder.index', $package->id) . "' class='main-btn price-btn'>" . __('Place Order') . "</a>";
                        }
                        $packageSec .= "</div>";
                    }
                    $packageSec .= "</div>
                        </div>
                    </packages-section>
                </div>
            </section>";

            // Latest Blogs Section (Cleaning Version)
            $blogSec = "<section class='blog-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-7'>
                            <div class='section-title-two'>
                                <span>" . convertUtf8($bs->blog_section_title) . "</span>
                                <h1>" . convertUtf8($bs->blog_section_subtitle) . "</h1>
                            </div>
                        </div>
                        <div class='col-lg-5 text-right'>
                            <a href='" . route('front.blogs') . "' class='blog-link'>" . __('View More') . " <i class='fa fa-arrow-right'></i></a>
                        </div>
                    </div>
                    <blogs-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Blogs > Blogs</strong>
                            </div>

                            <div class='blog-carousel-active blog-slick row'>";
                    foreach ($blogs as $key => $blog) {

                        $blogSec .= "<div class='single-blog-item col-4 mx-0'>
                                        <div class='single-blog-img'>
                                            <img class='lazy' data-src='" . url('assets/front/img/blogs/' . $blog->main_image) . "' alt=''>
                                        </div>
                                        <div class='single-blog-details'>";

                        $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$lang->code");
                        $blogDate = $blogDate->translatedFormat('d M. Y');

                        $blogSec .= "<span><i class='fa fa-arrow-right'></i>" . __('By') . " " . __('Admin') . "</span>
                                            <span><i class='fa fa-arrow-right'></i>" . $blogDate . "</span>
                                            <h4>" . (strlen($blog->title) > 40 ? mb_substr($blog->title, 0, 40, 'utf-8') . '...' : $blog->title) . "</h4>
                                            <p>" . (strlen(strip_tags($blog->content)) > 100 ? mb_substr(strip_tags($blog->content), 0, 100, 'utf-8') . '...' : strip_tags($blog->content)) . "</p>
                                            <a href='" . route('front.blogdetails', [$blog->slug]) . "' class='blog-btn'>" . __('Read More') . " <i class='fa fa-arrow-right'></i></a>
                                        </div>
                                    </div>";
                    }
                    $blogSec .= "</div>
                        </div>
                    </blogs-section>
                </div>
            </section>";

            // CTA Section (Cleaning Version)
            $ctaSec = "<section class='cta-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $bs->cta_bg) . "); background-size:cover;'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-8'>
                            <h1>" . convertUtf8($bs->cta_section_text) . "</h1>
                        </div>
                        <div class='col-lg-4 text-center'>
                            <a href='" . $bs->cta_section_button_url . "' class='main-btn cta-btn'>" . convertUtf8($bs->cta_section_button_text) . "</a>
                        </div>
                    </div>
                </div>
            </section>";

            // Partner Section (Cleaning Version)
            $partnerSec = "<section class='bran-area pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 100px 0;'>
                <div class='container'>
                    <partner-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Partners</strong>
                            </div>

                            <div class='row'>
                                <div class='col-lg-12'>
                                    <div class='brand-container brand-carousel-active row'>";
                                    foreach ($partners as $key => $partner) {
                                        $partnerSec .= "<div class='single-brand-logo col-3 mx-0'>
                                            <a class='d-block' href='" . $partner->url . "' target='_blank'><img data-src='" . url('assets/front/img/partners/' . $partner->image) . "' class='img-fluid lazy' alt=''></a>
                                        </div>";
                                    }
                                    $partnerSec .= "</div>
                                </div>
                            </div>
                        </div>
                    </partner-section>
                </div>
            </section>";
        }



        // For Construction Version
        if ($version == 'construction') {

            // Intro Section (Construction Version)
            $introsec = "<section class='finlance_about about_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-6'>
                            <div class='finlance_box_img'>
                                <div class='finlance_img'>
                                    <img src='" . url('assets/front/img/' . $bs->intro_bg) . "' class='img-fluid' alt=''>
                                </div>
                                <div class='play_box'>
                                    <a href='" . $bs->intro_section_video_link . "' class='play_btn'><i class='fas fa-play'></i></a>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-6'>
                            <div class='finlance_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->intro_section_title) . "</span>
                                    <h2>" . convertUtf8($bs->intro_section_text) . "</h2>
                                </div>";
            if (!empty($bs->intro_section_button_url) && !empty($bs->intro_section_button_text)) {
                $introsec .= "<div class='button_box'>
                                        <a href='" . $bs->intro_section_button_url . "' class='finlance_btn'>" . convertUtf8($bs->intro_section_button_text) . "</a>
                                    </div>";
            }
            $introsec .= "</div>
                        </div>
                    </div>
                </div>
            </section>";


            // Approach Section (Construction Version)
            $approachsec = "<section class='finlance_we_do we_do_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-6'>
                            <div class='finlance_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->approach_title) . "</span>
                                    <h2>" . convertUtf8($bs->approach_subtitle) . "</h2>
                                </div>";
                            if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text)) {
                                $approachsec .= "<div class='button_box  wow fadeInUp' data-wow-delay='.4s'>
                                    <a href='" . $bs->approach_button_url . "' class='finlance_btn'>" . convertUtf8($bs->approach_button_text) . "</a>
                                </div>";
                            }
                            $approachsec .= "</div>
                        </div>
                        <div class='col-lg-6'>
                            <approach-section>
                                <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                    <div class='non-editable-notice'>
                                        <h3>Non-Editable Area</h3>
                                        Manage From <br><strong>Content Management > Home Page Section > Approach Section</strong>
                                    </div>

                                    <div class='finlance_icon_box'>";
                                    foreach ($points as $key => $point) {
                                        $approachsec .= "<div class='icon_list d-flex'>
                                            <div class='icon'>
                                                <i class='" . $point->icon . "'></i>
                                            </div>
                                            <div class='text'>
                                                <h4>" . convertUtf8($point->title) . "</h4>
                                                <p>";
                                                    if (strlen($point->short_text) > 150) {
                                                        $approachsec .= mb_substr($point->short_text,0,150,'utf-8') . "<span style='display: none;'>" . mb_substr($point->short_text,150, null,'utf-8') . "</span>
                                                        <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                    } else {
                                                        $approachsec .= convertUtf8($point->short_text);
                                                    }
                                                $approachsec .= "</p>
                                            </div>
                                        </div>";
                                    }
                                    $approachsec .= "</div>
                                </div>
                            </approach-section>
                        </div>
                    </div>
                </div>
            </section>";


            // Service Category Section (Construction Version)
            $scatsec = "<section class='finlance_service service_v1 gray_bg  pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <service-category-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Category</strong>
                            </div>

                            <div class='service_slide service-slick row'>";
                    foreach ($scats as $key => $scat) {
                        $scatsec .= "<div class='grid_item col-4 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='finlance_icon'>
                                                <img data-src='" . url('assets/front/img/service_category_icons/' . $scat->image) . "' class='img-fluid lazy' alt=''>
                                            </div>
                                            <div class='finlance_content'>
                                                <h4>" . convertUtf8($scat->name) . "</h4>
                                                <p class='mb-0'>";
                                                if (strlen(convertUtf8($scat->short_text)) > 112) {
                                                    $scatsec .= mb_substr($scat->short_text,0,112,'utf-8') . "<span style='display: none;'>" . mb_substr($scat->short_text,112, null,'utf-8') . "</span>
                                                    <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                }
                                                else {
                                                    $scatsec .= $scat->short_text;
                                                }
                                                $scatsec .= "</p>
                                                <a href='" . route('front.services', ['category' => $scat->id]) . "' class='btn_link d-inline-block mt-35'>" . __('View Services') . "</a>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $scatsec .= "</div>
                        </div>
                    </service-category-section>
                </div>
            </section>";


            $servicesSec = "<section class='finlance_service service_v1 gray_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <services-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Services</strong>
                            </div>

                            <div class='service_slide service-slick row'>";

                            foreach ($services as $key => $service) {
                                $servicesSec .= "<div class='grid_item col-4 mx-0'>
                                    <div class='grid_inner_item'>";
                                    if (!empty($service->main_image)) {
                                            $servicesSec .= "<div class='finlance_icon' style='margin-bottom: 20px;'>
                                                <img class='lazy' data-src='" . url('assets/front/img/services/' . $service->main_image) . "' alt='service' />
                                            </div>";
                                    }
                                    $servicesSec .= "<div class='finlance_content'>
                                        <h4>" . convertUtf8($service->title) . "</h4>
                                        <p class='mb-0'>";
                                        if (strlen(convertUtf8($service->summary)) > 120) {
                                            $servicesSec .= mb_substr($service->summary,0,120,'utf-8') . "<span style='display: none;'>" . mb_substr($service->summary,120, null,'utf-8') . "</span>
                                            <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                        }
                                        else {
                                            $servicesSec .= $service->summary;
                                        }
                                        $servicesSec .= "</p>";
                                    if ($service->details_page_status == 1) {
                                        $servicesSec .= "<a href='" . route('front.servicedetails', [$service->slug]) . "' class='btn_link d-inline-block mt-35'>" . __('Read More') . "</a>";
                                    }
                                    $servicesSec .= "</div>
                                    </div>
                                </div>";
                            }


                            $servicesSec .= "</div>
                        </div>
                    </services-section>
                </div>
            </section>";


            $portfoliosSec = "<section class='finlance_project project_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->portfolio_section_title) . "</span>
                                <h2>" . convertUtf8($bs->portfolio_section_text) . "</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='container-fluid'>
                    <portfolios-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Portfolios</strong>
                            </div>

                            <div class='project_slide project-slick row'>";
                    foreach ($portfolios as $key => $portfolio) {
                        $portfoliosSec .= "<div class='grid_item col-3 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='finlance_img'>
                                                <img data-src='" . url('assets/front/img/portfolios/featured/' . $portfolio->featured_image) . "' class='img-fluid lazy' alt=''>
                                                <div class='overlay_img'></div>
                                                <div class='overlay_content'>
                                                    <div class='button_box'>
                                                        <a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "' class='finlance_btn'>" . __('View More') . "</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='finlance_content'>
                                                <h4>" . (strlen($portfolio->title) > 25 ? mb_substr($portfolio->title, 0, 25, 'utf-8') . '...' : $portfolio->title) . "</h4>";

                        if (!empty($portfolio->service)) {
                            $portfoliosSec .= "<p>" . $portfolio->service->title . "</p>";
                        }
                        $portfoliosSec .= "</div>
                                        </div>
                                    </div>";
                    }
                    $portfoliosSec .= "</div>
                        </div>
                    </portfolios-section>
                </div>
            </section>";


            $teamSec = "<section class='finlance_team team_v1 gray_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-8'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->team_section_title) . "</span>
                                <h2>" . convertUtf8($bs->team_section_subtitle) . "</h2>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class='button_box'>
                                <a href='" . route('front.team') . "' class='btn_link'>" . __('View More') . "</a>
                            </div>
                        </div>
                    </div>
                    <team-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Team Section</strong>
                            </div>

                            <div class='team_slide team-slick row'>";
                            foreach ($members as $key => $member) {
                                $teamSec .= "<div class='grid_item col-4 mx-0'>
                                                <div class='grid_inner_item'>
                                                    <div class='finlance_img'>
                                                        <img data-src='" . url('assets/front/img/members/' . $member->image) . "' class='img-fluid lazy' alt=''>
                                                        <div class='overlay_content'>
                                                            <div class='social_box'>
                                                                <ul>";
                                if (!empty($member->facebook)) {
                                    $teamSec .= " <li><a href='" . $member->facebook . "' target='_blank'><i class='fab fa-facebook-f'></i></a></li>";
                                }
                                if (!empty($member->twitter)) {
                                    $teamSec .= "  <li><a href='" . $member->twitter . "' target='_blank'><i class='fab fa-twitter'></i></a></li>";
                                }
                                if (!empty($member->linkedin)) {
                                    $teamSec .= " <li><a href='" . $member->linkedin . "' target='_blank'><i class='fab fa-linkedin-in'></i></a></li>";
                                }
                                if (!empty($member->instagram)) {
                                    $teamSec .= "<li><a href='" . $member->instagram . "' target='_blank'><i class='fab fa-instagram'></i></a></li>";
                                }
                                $teamSec .= "</ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='finlance_content text-center'>
                                                        <h4>" . convertUtf8($member->name) . "</h4>
                                                        <p>" . convertUtf8($member->rank) . "</p>
                                                    </div>
                                                </div>
                                            </div>";
                            }
                            $teamSec .= "</div>
                        </div>
                    </team-section>
                </div>
            </section>";


            $statisticSec = "<section class='finlance_fun finlance_fun_v1 bg_image pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $be->statistics_bg) . ");background-size:cover; padding: 100px 0px;' id='statisticsSection'>
                <div class='container' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                    <statistics-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Statistics Sections</strong>
                            </div>

                            <div class='row'>";
                                foreach ($statistics as $key => $statistic) {
                                    $statisticSec .= "<div class='col-lg-3 col-md-6 col-sm-12'>
                                        <div class='counter_box'>
                                            <div class='icon'>
                                                <i class='" . $statistic->icon . "'></i>
                                            </div>
                                            <h2><span class='counter'>" . convertUtf8($statistic->quantity) . "</span>+</h2>
                                            <p>" . convertUtf8($statistic->title) . "</p>
                                        </div>
                                    </div>";
                                }
                            $statisticSec .= "</div>
                        </div>
                    </statistics-section>
                </div>
            </section>";


            $testimonialSec = "<section class='finlance_testimonial testimonial_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->testimonial_title) . "</span>
                                <h2>" . convertUtf8($bs->testimonial_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <testimonial-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Testimonials</strong>
                            </div>

                            <div class='testimonial_slide row'>";
                            foreach ($testimonials as $key => $testimonial) {
                                $testimonialSec .= "<div class='testimonial_box d-flex align-items-center col-6 mx-0'>
                                    <div class='finlance_img'>
                                        <img data-src='" . url('assets/front/img/testimonials/' . $testimonial->image) . "' class='img-fluid lazy' alt=''>
                                    </div>
                                    <div class='finlance_content'>
                                        <h4>" . convertUtf8($testimonial->name) . "</h4>
                                        <h6>" . convertUtf8($testimonial->rank) . "</h6>
                                        <p>" . convertUtf8($testimonial->comment) . "</p>
                                    </div>
                                </div>";
                            }
                            $testimonialSec .= "</div>
                        </div>
                    </testimonial-section>
                </div>
            </section>";


            $packageSec = "<section class='finlance_pricing pricing_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($be->pricing_title) . "</span>
                                <h2>" . convertUtf8($be->pricing_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <packages-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Package Management > Packages</strong>
                            </div>

                            <div class='pricing_slide pricing-slick row'>";
                    foreach ($packages as $key => $package) {
                        $packageSec .= "<div class='pricing_box text-center col-4 mx-0'>
                                        <div class='pricing_title'>
                                            <h3>" . convertUtf8($package->title) . "</h3>";
                                            if($bex->recurring_billing == 1) {
                                                $packageSec .= "<p>" . ($package->duration == 'monthly' ? __('Monthly') : __('Yearly')) . "</p>";
                                            }
                                        $packageSec .= "</div>
                                        <div class='pricing_price'>
                                            <h3>" . ($bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '') . " " . $package->price . " " . ($bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '') . "</h3>
                                        </div>
                                        <div class='pricing_body'>" . replaceBaseUrl(convertUtf8($package->description)) . "</div>
                                        <div class='pricing_button'>";
                        if ($package->order_status == 1) {
                            $packageSec .= "<a href='" . route('front.packageorder.index', $package->id) . "' class='finlance_btn'>" . __('Place Order') . "</a>";
                        }
                        $packageSec .= "</div>
                                    </div>";
                    }
                    $packageSec .= "</div>
                        </div>
                    </packages-section>
                </div>
            </section>";


            $blogSec = "<section class='finlance_blog blog_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->blog_section_title) . "</span>
                                <h2>" . convertUtf8($bs->blog_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <blogs-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Blogs > Blogs</strong>
                            </div>

                            <div class='blog_slide blog-slick row'>";
                    foreach ($blogs as $key => $blog) {
                        $blogSec .= "<div class='grid_item col-4 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='finlance_img'>
                                                <a href='" . route('front.blogdetails', [$blog->slug]) . "'><img data-src='" . url('assets/front/img/blogs/' . $blog->main_image) . "' class='img-fluid lazy' alt=''></a>
                                            </div>
                                            <div class='finlance_content'>
                                                <div class='post_meta'>";

                        $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$lang->code");
                        $blogDate = $blogDate->translatedFormat('d M. Y');

                        $blogSec .= "<span><i class='far fa-user'></i><a href='#'>" . __('By') . " " . __('Admin') . "</a></span>
                                                    <span><i class='far fa-calendar-alt'></i><a href='#'>" . $blogDate . "</a></span>
                                                </div>
                                                <h3 class='post_title'><a href='" . route('front.blogdetails', [$blog->slug]) . "'>" . (strlen($blog->title) > 40 ? mb_substr($blog->title, 0, 40, 'utf-8') . '...' : $blog->title) . "</a></h3>
                                                <a href='" . route('front.blogdetails', [$blog->slug]) . "' class='btn_link'>" . __('Read More') . "</a>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $blogSec .= "</div>
                        </div>
                    </blogs-section>
                </div>
            </section>";


            $ctaSec = "<section class='finlance_cta cta_v1 main_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 60px 0px;'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-7'>
                            <div class='section_title'>
                                <h2 class='text-white'>" . convertUtf8($bs->cta_section_text) . "</h2>
                            </div>
                        </div>
                        <div class='col-lg-5'>
                            <div class='button_box'>
                                <a href='" . $bs->cta_section_button_url . "' class='finlance_btn'>" . convertUtf8($bs->cta_section_button_text) . "</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>";


            $partnerSec = "<section class='finlance_partner partner_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 100px 0px;'>
                <div class='container'>
                    <partner-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Partners</strong>
                            </div>

                            <div class='partner_slide row'>";
                            foreach ($partners as $key => $partner) {
                                $partnerSec .= "<div class='single_partner col-3 mx-0'>
                                                <a href='" . $partner->url . "'><img data-src='" . url('assets/front/img/partners/' . $partner->image) . "' class='img-fluid lazy' alt=''></a>
                                            </div>";
                            }
                            $partnerSec .= "</div>
                        </div>
                    </partner-section>
                </div>
            </section>";
        }


        // For Logistic Version
        if ($version == 'logistic') {

            $introsec = "<section class='logistics_about about_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-6'>
                            <div class='logistics_box_img'>
                                <div class='logistics_img'>
                                    <img src='" . url('assets/front/img/' . $bs->intro_bg) . "' class='img-fluid' alt=''>
                                </div>
                                <div class='logistics_img'>
                                    <img src='" . url('assets/front/img/' . $be->intro_bg2) . "' class='img-fluid' alt=''>
                                    <div class='play_box'>
                                        <a href='" . $bs->intro_section_video_link . "' class='play_btn'><i class='fas fa-play'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-6'>
                            <div class='logistics_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->intro_section_title) . "</span>
                                    <h2>" . convertUtf8($bs->intro_section_text) . "</h2>
                                </div>
                                <div class='button_box'>
                                    <a href='" . $bs->intro_section_button_url . "' class='logistics_btn'>" . convertUtf8($bs->intro_section_button_text) . "</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>";


            $approachsec = "<section class='logistics_we_do we_do_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-6'>
                            <div class='logistics_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->approach_title) . "</span>
                                    <h2>" . convertUtf8($bs->approach_subtitle) . "</h2>
                                </div>";
            if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text)) {
                $approachsec .= "<div class='button_box'>
                                        <a href='" . $bs->approach_button_url . "' class='logistics_btn'>" . convertUtf8($bs->approach_button_text) . "</a>
                                    </div>";
            }
            $approachsec .= "</div>
                        </div>
                        <div class='col-lg-6'>
                            <approach-section>
                                <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                    <div class='non-editable-notice'>
                                        <h3>Non-Editable Area</h3>
                                        Manage From <br><strong>Content Management > Home Page Section > Approach Section</strong>
                                    </div>

                                    <div class='logistics_icon_box'>";
                    foreach ($points as $key => $point) {
                        $approachsec .= "<div class='icon_list d-flex'>
                                                <div class='icon'>
                                                    <i class='" . $point->icon . "'></i>
                                                </div>
                                                <div class='text'>
                                                    <h4>" . convertUtf8($point->title) . "</h4>
                                                    <p>";
                                                        if (strlen($point->short_text) > 150) {
                                                            $approachsec .= mb_substr($point->short_text,0,150,'utf-8') . "<span style='display: none;'>" . mb_substr($point->short_text,150, null,'utf-8') . "</span>
                                                            <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                        } else {
                                                            $approachsec .= convertUtf8($point->short_text);
                                                        }
                                                    $approachsec .= "</p>
                                                </div>
                                            </div>";
                    }
                    $approachsec .= "</div>
                                </div>
                            </approach-section>
                        </div>
                    </div>
                </div>
            </section>";


            $scatsec = "<section class='logistics_service service_v1 dark_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <service-category-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Category</strong>
                            </div>

                            <div class='service_slide service-slick row'>";
                    foreach ($scats as $key => $scat) {
                        $scatsec .= "<div class='grid_item col-4 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='logistics_icon'>
                                                <img data-src='" . url('assets/front/img/service_category_icons/' . $scat->image) . "' class='img-fluid lazy' alt=''>
                                            </div>
                                            <div class='logistics_content'>
                                                <h4>" . convertUtf8($scat->name) . "</h4>
                                                <p>";
                                                    if (strlen(convertUtf8($scat->short_text)) > 112) {
                                                        $scatsec .= mb_substr($scat->short_text,0,112,'utf-8') . "<span style='display: none;'>" . mb_substr($scat->short_text,112, null,'utf-8') . "</span>
                                                        <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                    }
                                                    else {
                                                        $scatsec .= $scat->short_text;
                                                    }
                                                $scatsec .= "</p>
                                                <a href='" . route('front.services', ['category' => $scat->id]) . "' class='btn_link'>" . __('View Services') . "</a>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $scatsec .= "</div>
                        </div>
                    </service-category-section>
                </div>
            </section>";


            $servicesSec = "<section class='logistics_service service_v1 dark_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <services-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Services</strong>
                            </div>

                            <div class='service_slide service-slick row'>";
                            foreach ($services as $key => $service) {
                                $servicesSec .= "<div class='grid_item col-4 mx-0'>
                                                <div class='grid_inner_item'>";

                                if (!empty($service->main_image)) {
                                    $servicesSec .= "<div class='logistics_icon'>
                                                            <img data-src='" . url('assets/front/img/services/' . $service->main_image) . "' class='img-fluid lazy' alt=''>
                                                        </div>";
                                }

                                $servicesSec .= "<div class='logistics_content'>
                                                        <h4>" . convertUtf8($service->title) . "</h4>
                                                        <p>";
                                                            if (strlen(convertUtf8($service->summary)) > 120) {
                                                                $servicesSec .= mb_substr($service->summary,0,120,'utf-8') . "<span style='display: none;'>" . mb_substr($service->summary,120, null,'utf-8') . "</span>
                                                                <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                            }
                                                            else {
                                                                $servicesSec .= $service->summary;
                                                            }
                                                        $servicesSec .= "</p>";

                                if ($service->details_page_status == 1) {
                                    $servicesSec .= "<a href='" . route('front.servicedetails', [$service->slug]) . "' class='btn_link'>" . __('View Services') . "</a>";
                                }

                                $servicesSec .= "</div>
                                                </div>
                                            </div>";
                            }
                            $servicesSec .= "</div>
                        </div>
                    </services-section>
                </div>
            </section>";


            $portfoliosSec = "<section class='logistics_project project_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->portfolio_section_title) . "</span>
                                <h2>" . convertUtf8($bs->portfolio_section_text) . "</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='container-fluid'>
                    <portfolios-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Portfolios</strong>
                            </div>

                            <div class='project_slide project-slick row'>";
                    foreach ($portfolios as $key => $portfolio) {
                        $portfoliosSec .= "<div class='grid_item col-3 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='logistics_img'>
                                                <img data-src='" . url('assets/front/img/portfolios/featured/' . $portfolio->featured_image) . "' class='img-fluid lazy' alt=''>
                                                <div class='overlay_img'></div>
                                                <div class='overlay_content'>
                                                    <div class='button_box'>
                                                        <a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "' class='logistics_btn'>" . __('View More') . "</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='logistics_content'>
                                                <h4>" . (strlen($portfolio->title) > 25 ? mb_substr($portfolio->title, 0, 25, 'utf-8') . '...' : $portfolio->title) . "</h4>";

                        if (!empty($portfolio->service)) {
                            $portfoliosSec .= "<p>" . convertUtf8($portfolio->service->title) . "</p>";
                        }
                        $portfoliosSec .= "</div>
                                        </div>
                                    </div>";
                    }
                    $portfoliosSec .= "</div>
                        </div>
                    </portfolios-section>
                </div>
            </section>";


            $teamSec = "<section class='logistics_team team_v1 gray_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-8'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->team_section_title) . "</span>
                                <h2>" . convertUtf8($bs->team_section_subtitle) . "</h2>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class='button_box'>
                                <a href='" . route('front.team') . "' class='btn_link'>" . __('View More') . "</a>
                            </div>
                        </div>
                    </div>
                    <team-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Team Section</strong>
                            </div>

                            <div class='team_slide team-slick row'>";
                    foreach ($members as $key => $member) {
                        $teamSec .= "<div class='grid_item col-4 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='logistics_img'>
                                                <img data-src='" . url('assets/front/img/members/' . $member->image) . "' class='img-fluid lazy' alt=''>
                                                <div class='overlay_content'>
                                                    <div class='social_box'>
                                                        <ul>";
                        if (!empty($member->facebook)) {
                            $teamSec .= "<li><a href='" . $member->facebook . "' target='_blank'><i class='fab fa-facebook-f'></i></a></li>";
                        }
                        if (!empty($member->twitter)) {
                            $teamSec .= "<li><a href='" . $member->twitter . "' target='_blank'><i class='fab fa-twitter'></i></a></li>";
                        }
                        if (!empty($member->linkedin)) {
                            $teamSec .= "<li><a href='" . $member->linkedin . "' target='_blank'><i class='fab fa-linkedin-in'></i></a></li>";
                        }
                        if (!empty($member->instagram)) {
                            $teamSec .= "<li><a href='" . $member->instagram . "' target='_blank'><i class='fab fa-instagram'></i></a></li>";
                        }
                        $teamSec .= "</ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='logistics_content text-center'>
                                                <h4>" . convertUtf8($member->name) . "</h4>
                                                <p>" . convertUtf8($member->rank) . "</p>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $teamSec .= "</div>
                        </div>
                    </team-section>
                </div>
            </section>";


            $statisticSec = "<section class='logistics_fun logistics_fun_v1 bg_image pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $be->statistics_bg) . ");background-size:cover; padding: 100px 0px;' id='statisticsSection'>
                <div class='container' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                    <statistics-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Statistics Sections</strong>
                            </div>

                            <div class='row'>";
                    foreach ($statistics as $key => $statistic) {
                        $statisticSec .= "<div class='col-lg-3 col-md-6 col-sm-12'>
                                        <div class='counter_box'>
                                            <div class='icon'>
                                                <i class='" . $statistic->icon . "'></i>
                                            </div>
                                            <h2><span class='counter'>" . convertUtf8($statistic->quantity) . "</span>+</h2>
                                            <p>" . convertUtf8($statistic->title) . "</p>
                                        </div>
                                    </div>";
                    }
                    $statisticSec .= "</div>
                        </div>
                    </statistics-section>
                </div>
            </section>";


            $testimonialSec = "<section class='logistics_testimonial testimonial_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->testimonial_title) . "</span>
                                <h2>" . convertUtf8($bs->testimonial_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <testimonial-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Testimonials</strong>
                            </div>

                            <div class='testimonial_slide'>";
                    foreach ($testimonials as $key => $testimonial) {
                        $testimonialSec .= "<div class='testimonial_box d-lg-flex align-items-lg-center'>
                                        <div class='logistics_img'>
                                            <img data-src='" . url('assets/front/img/testimonials/' . $testimonial->image) . "' class='img-fluid lazy' alt='' width='100%'>
                                        </div>
                                        <div class='logistics_content'>
                                            <h4>" . convertUtf8($testimonial->name) . "</h4>
                                            <h6>" . convertUtf8($testimonial->rank) . "</h6>
                                            <p>" . convertUtf8($testimonial->comment) . "</p>
                                        </div>
                                    </div>";
                    }
                    $testimonialSec .= "</div>
                        </div>
                    </testimonial-section>
                </div>
            </section>";


            $packageSec = "<section class='logistics_pricing pricing_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($be->pricing_title) . "</span>
                                <h2>" . convertUtf8($be->pricing_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <packages-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Package Management > Packages</strong>
                            </div>

                            <div class='pricing_slide pricing-slick row'>";
                    foreach ($packages as $key => $package) {
                        $packageSec .= "<div class='pricing_box text-center col-4 mx-0'>
                                        <div class='pricing_title'>
                                            <h3>" . convertUtf8($package->title) . "</h3>";
                                            if($bex->recurring_billing == 1) {
                                                $packageSec .= "<p>" . ($package->duration == 'monthly' ? __('Monthly') : __('Yearly')) . "</p>";
                                            }
                                        $packageSec .= "</div>
                                        <div class='pricing_price'>
                                            <h3>" . ($bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '') . " " . $package->price . " " . ($bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '') . "</h3>
                                        </div>
                                        <div class='pricing_body'>" . replaceBaseUrl(convertUtf8($package->description)) . "</div>
                                        <div class='pricing_button'>";
                        if ($package->order_status == 1) {
                            $packageSec .= "<a href='" . route('front.packageorder.index', $package->id) . "' class='logistics_btn'>" . __('Place Order') . "</a>";
                        }
                        $packageSec .= "</div>
                                    </div>";
                    }
                    $packageSec .= "</div>
                        </div>
                    </packages-section>
                </div>
            </section>";


            $blogSec = "<section class='logistics_blog blog_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->blog_section_title) . "</span>
                                <h2>" . convertUtf8($bs->blog_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <blogs-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Blogs > Blogs</strong>
                            </div>

                            <div class='blog_slide blog-slick row'>";
                    foreach ($blogs as $key => $blog) {
                        $blogSec .= "<div class='grid_item col-4 mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='logistics_img'>
                                                <a href='" . route('front.blogdetails', [$blog->slug]) . "'><img data-src='" . url('assets/front/img/blogs/' . $blog->main_image) . "' class='img-fluid lazy' alt=''></a>
                                            </div>
                                            <div class='logistics_content'>
                                                <div class='post_meta'>";

                        $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$lang->code");
                        $blogDate = $blogDate->translatedFormat('d M. Y');

                        $blogSec .= "<span><i class='far fa-user'></i><a href='#'>" . __('By') . " " . __('Admin') . "</a></span>
                                                    <span><i class='far fa-calendar-alt'></i><a href='#'>" . $blogDate . "</a></span>
                                                </div>
                                                <h3 class='post_title'><a href='" . route('front.blogdetails', [$blog->slug]) . "'>" . (strlen($blog->title) > 40 ? substr($blog->title, 0, 40) . '...' : $blog->title) . "</a></h3>
                                                <a href='" . route('front.blogdetails', [$blog->slug]) . "' class='btn_link'>" . __('Read More') . "</a>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $blogSec .= "</div>
                        </div>
                    </blogs-section>
                </div>
            </section>";


            $ctaSec = "<section class='logistics_cta cta_v1 main_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 70px 0px;'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-9'>
                            <div class='section_title'>
                                <h2 class='text-white'>" . convertUtf8($bs->cta_section_text) . "</h2>
                            </div>
                        </div>
                        <div class='col-lg-3'>
                            <div class='button_box'>
                                <a href='" . $bs->cta_section_button_url . "' class='logistics_btn'>" . convertUtf8($bs->cta_section_button_text) . "</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>";


            $partnerSec = "<section class='logistics_partner partner_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 100px 0px;'>
                <div class='container'>
                    <partner-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Partners</strong>
                            </div>

                            <div class='partner_slide row'>";
                    foreach ($partners as $key => $partner) {
                        $partnerSec .= "<div class='single_partner col-3 mx-0'>
                            <a href='" . $partner->url . "'><img data-src='" . url('assets/front/img/partners/' . $partner->image) . "' class='img-fluid lazy' alt=''></a>
                        </div>";
                    }
                    $partnerSec .= "</div>
                        </div>
                    </partner-section>
                </div>
            </section>";
        }


        // For Lawyer Version
        if ($version == 'lawyer') {

            $introsec = "<section class='lawyer_about about_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' id='about_v1'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-7'>
                            <div class='lawyer_box_img'>
                                <div class='lawyer_img'>
                                    <img src='" . url('assets/front/img/' . $bs->intro_bg) . "' class='img-fluid' alt=''>
                                </div>
                                <div class='lawyer_img'>
                                    <img src='" . url('assets/front/img/' . $be->intro_bg2) . "' class='img-fluid' alt=''>
                                    <div class='play_box'>
                                        <a href='" . $bs->intro_section_video_link . "' class='play_btn'><i class='fas fa-play'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-5'>
                            <div class='lawyer_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->intro_section_title) . "</span>
                                    <h2>" . convertUtf8($bs->intro_section_text) . "</h2>
                                </div>
                                <div class='button_box'>
                                    <a href='" . $bs->intro_section_button_url . "' class='lawyer_btn'>" . convertUtf8($bs->intro_section_button_text) . "</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>";


            $approachsec = "<section class='lawyer_we_do we_do_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-6'>
                            <div class='lawyer_content_box'>
                                <div class='section_title'>
                                    <span>" . convertUtf8($bs->approach_title) . "</span>
                                    <h2>" . convertUtf8($bs->approach_subtitle) . "</h2>
                                </div>";
            if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text)) {
                $approachsec .= "<div class='button_box  wow fadeInUp' data-wow-delay='.4s'>
                                        <a href='" . $bs->approach_button_url . "' class='lawyer_btn'>" . convertUtf8($bs->approach_button_text) . "</a>
                                    </div>";
            }
            $approachsec .= "</div>
                        </div>
                        <div class='col-lg-6'>
                            <approach-section>
                                <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                    <div class='non-editable-notice'>
                                        <h3>Non-Editable Area</h3>
                                        Manage From <br><strong>Content Management > Home Page Section > Approach Section</strong>
                                    </div>
                                    <div class='lawyer_icon_box'>";
                                    foreach ($points as $key => $point) {
                                        $approachsec .= "<div class='icon_list d-flex' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                                            <div class='icon'>
                                                <i class='" . $point->icon . "'></i>
                                            </div>
                                            <div class='text'>
                                                <h4>" . convertUtf8($point->title) . "</h4>
                                                <p>";
                                                    if (strlen($point->short_text) > 150) {
                                                        $approachsec .= mb_substr($point->short_text,0,150,'utf-8') . "<span style='display: none;'>" . mb_substr($point->short_text,150, null,'utf-8') . "</span>
                                                        <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                    } else {
                                                        $approachsec .= convertUtf8($point->short_text);
                                                    }
                                                $approachsec .= "</p>
                                            </div>
                                        </div>";
                                    }
                                    $approachsec .= "</div>
                                </div>
                            </approach-section>
                        </div>
                    </div>
                </div>
            </section>";


            $scatsec = "<section class='lawyer_service service_v1 gray_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-lg-12'>
                                    <div class='section_title text-center'>
                                        <span>" . convertUtf8($bs->service_section_title) . "</span>
                                        <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                                    </div>
                                </div>
                            </div>
                            <service-category-section>
                                <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                                    <div class='non-editable-notice'>
                                        <h3>Non-Editable Area</h3>
                                        Manage From <br><strong>Content Management > Services > Category</strong>
                                    </div>
                                    <div class='service_slide service-slick row'>";
                                    foreach ($scats as $key => $scat) {
                                        $scatsec .= "<div class='grid_item col-lg-4 mx-0'>
                                            <div class='grid_inner_item'>
                                                <div class='lawyer_img'>
                                                    <img data-src='" . url('assets/front/img/service_category_icons/' . $scat->image) . "' class='img-fluid lazy' alt=''>
                                                </div>
                                                <div class='lawyer_content'>
                                                    <h4>" . convertUtf8($scat->name) . "</h4>
                                                    <p>";
                                                        if (strlen(convertUtf8($scat->short_text)) > 100) {
                                                            $scatsec .= mb_substr($scat->short_text,0,100,'utf-8') . "<span style='display: none;'>" . mb_substr($scat->short_text,100, null,'utf-8') . "</span>
                                                            <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                        }
                                                        else {
                                                            $scatsec .= $scat->short_text;
                                                        }
                                                    $scatsec .= "</p>
                                                    <a href='" . route('front.services', ['category' => $scat->id]) . "' class='lawyer_btn'>" . __('View Services') . "</a>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                    $scatsec .= "</div>
                                </div>
                            </service-category-section>
                        </div>
                    </section>";

            $servicesSec = "<section class='lawyer_service service_v1 gray_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->service_section_title) . "</span>
                                <h2>" . convertUtf8($bs->service_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <services-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Services > Services</strong>
                            </div>

                            <div class='service_slide service-slick row'>";
                    foreach ($services as $key => $service) {
                        $servicesSec .= "<div class='grid_item col-lg-4 mx-0' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                                        <div class='grid_inner_item'>
                                            <div class='lawyer_img'>";
                        if (!empty($service->main_image)) {
                            $servicesSec .= "<div class='logistics_icon'>
                                                        <img data-src='" . url('assets/front/img/services/' . $service->main_image) . "' class='img-fluid lazy' alt=''>
                                                    </div>";
                        }
                        $servicesSec .= "</div>
                                            <div class='lawyer_content'>
                                                <h4>" . convertUtf8($service->title) . "</h4>
                                                <p>";
                                                    if (strlen(convertUtf8($service->summary)) > 100) {
                                                        $servicesSec .= mb_substr($service->summary,0,100,'utf-8') . "<span style='display: none;'>" . mb_substr($service->summary,100, null,'utf-8') . "</span>
                                                        <a href='#' class='see-more'>" . __('see more') . "...</a>";
                                                    }
                                                    else {
                                                        $servicesSec .= $service->summary;
                                                    }
                                                $servicesSec .= "</p>";
                        if ($service->details_page_status == 1) {
                            $servicesSec .= "<a href='" . route('front.servicedetails', [$service->slug]) . "' class='lawyer_btn'>" . __('Read More') . "</a>";
                        }
                        $servicesSec .= "</div>
                                        </div>
                                    </div>";
                    }

                    $servicesSec .= "</div>
                        </div>
                    </services-section>
                </div>
            </section>";


            $portfoliosSec = "<section class='lawyer_project project_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->portfolio_section_title) . "</span>
                                <h2>" . convertUtf8($bs->portfolio_section_text) . "</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='container-fluid'>
                    <portfolios-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Portfolios</strong>
                            </div>

                            <div class='row project_slide project-slick'>";
                    foreach ($portfolios as $key => $portfolio) {
                        $portfoliosSec .= "<div class='col-lg-3 grid_item mx-0' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                                        <div class='grid_inner_item'>
                                            <div class='lawyer_img'>
                                                <img data-src='" . url('assets/front/img/portfolios/featured/' . $portfolio->featured_image) . "' class='img-fluid lazy' alt=''>
                                                <div class='overlay_img'></div>
                                                <div class='overlay_content'>
                                                    <h3><a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "'>" . (strlen($portfolio->title) > 25 ? mb_substr($portfolio->title, 0, 25, 'utf-8') . '...' : $portfolio->title) . "</a></h3>";
                        if (!empty($portfolio->service)) {
                            $portfoliosSec .= "<p>" . convertUtf8($portfolio->service->title) . "</p>";
                        }
                        $portfoliosSec .= "<a href='" . route('front.portfoliodetails', [$portfolio->slug]) . "' class='lawyer_btn'>" . __('View More') . "</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $portfoliosSec .= "</div>
                        </div>
                    </portfolios-section>
                </div>
            </section>";


            $teamSec = "<section class='lawyer_team team_v1 gray_bg pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-12'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($bs->team_section_title) . "</span>
                                <h2>" . convertUtf8($bs->team_section_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <team-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Team Section</strong>
                            </div>

                            <div class='row team_slide team-slick'>";
                    foreach ($members as $key => $member) {
                        $teamSec .= "<div class='col-lg-4 grid_item mx-0'>
                                        <div class='grid_inner_item'>
                                            <div class='lawyer_img'>
                                                <img data-src='" . url('assets/front/img/members/' . $member->image) . "' class='img-fluid lazy' alt=''>
                                            </div>
                                            <div class='lawyer_content text-center'>
                                                <h4>" . convertUtf8($member->name) . "</h4>
                                                <p>" . convertUtf8($member->rank) . "</p>
                                                <ul class='social'>";
                        if (!empty($member->facebook)) {
                            $teamSec .= "<li><a href='" . $member->facebook . "' target='_blank'><i class='fab fa-facebook-f'></i></a></li>";
                        }
                        if (!empty($member->twitter)) {
                            $teamSec .= "<li><a href='" . $member->twitter . "' target='_blank'><i class='fab fa-twitter'></i></a></li>";
                        }
                        if (!empty($member->linkedin)) {
                            $teamSec .= "<li><a href='" . $member->linkedin . "' target='_blank'><i class='fab fa-linkedin-in'></i></a></li>";
                        }
                        if (!empty($member->instagram)) {
                            $teamSec .= "<li><a href='" . $member->instagram . "' target='_blank'><i class='fab fa-instagram'></i></a></li>";
                        }
                        $teamSec .= "</ul>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $teamSec .= "</div>
                        </div>
                    </team-section>
                </div>
            </section>";


            $statisticSec = "<section class='lawyer_fun lawyer_fun_v1 bg_image pb-mb30 lazy " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $be->statistics_bg) . "); background-size:cover; padding: 100px 0px;' id='statisticsSection'>
                <div class='container'>
                    <statistics-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Statistics Sections</strong>
                            </div>
                            <div class='row'>";

                                foreach ($statistics as $key => $statistic) {
                                    $statisticSec .= "<div class='col-lg-3 col-md-6 col-sm-12' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                                        <div class='counter_box'>
                                            <div class='icon'>
                                                <i class='" . $statistic->icon . "'></i>
                                            </div>
                                            <h2><span class='counter'>" . convertUtf8($statistic->quantity) . "</span>+</h2>
                                            <h4>" . convertUtf8($statistic->title) . "</h4>
                                        </div>
                                    </div>";
                                }

                            $statisticSec .= "</div>
                        </div>
                    </statistics-section>
                </div>
            </section>";

            $testimonialSec = "<section class='lawyer_testimonial testimonial_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->testimonial_title) . "</span>
                                <h2>" . convertUtf8($bs->testimonial_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <testimonial-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Sections > Testimonials</strong>
                            </div>
                            <div class='testimonial_slide row'>";
                            foreach ($testimonials as $key => $testimonial) {
                                $testimonialSec .= "<div class='testimonial_box col-lg-4 mx-0' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                                    <div class='lawyer_content_box'>
                                        <img class='lazy' data-src='" . url('assets/front/img/quote_1.png') . "' alt=''>
                                        <p>" . convertUtf8($testimonial->comment) . "</p>
                                        <div class='admin_box d-flex align-items-center'>
                                            <div class='thumb'>
                                                <img data-src='" . url('assets/front/img/testimonials/' . $testimonial->image) . "' class='img-fluid lazy' alt=''>
                                            </div>
                                            <div class='info'>
                                                <h4>" . convertUtf8($testimonial->name) . "</h4>
                                                <p>" . convertUtf8($testimonial->rank) . "</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            }
                            $testimonialSec .= "</div>
                        </div>
                    </testimonial-section>
                </div>
            </section>";


            $packageSec = "<section class='lawyer_pricing pricing_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='section_title text-center'>
                                <span>" . convertUtf8($be->pricing_title) . "</span>
                                <h2>" . convertUtf8($be->pricing_subtitle) . "</h2>
                            </div>
                        </div>
                    </div>
                    <packages-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Package Management > Packages</strong>
                            </div>

                            <div class='pricing_slide pricing-slick row'>";
                            foreach ($packages as $key => $package) {
                                $packageSec .= "<div class='col-lg-4 mx-0 pricing_box text-center' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                                                <div class='pricing_title'>";
                                if (!empty($package->image)) {
                                    $packageSec .= "<img class='lazy' data-src='" . url('assets/front/img/packages/' . $package->image) . "' alt=''>";
                                }
                                $packageSec .= "<h3>" . convertUtf8($package->title) . "</h3>";
                                if($bex->recurring_billing == 1) {
                                    $packageSec .= "<p>" . ($package->duration == 'monthly' ? __('Monthly') : __('Yearly')) . "</p>";
                                }
                                $packageSec .= "</div>
                                <div class='pricing_price'>
                                    <h3>" . ($bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '') . " " . $package->price . " " . ($bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '') . "</h3>
                                </div>
                                <div class='pricing_body'>" . replaceBaseUrl(convertUtf8($package->description)) . "</div>
                                <div class='pricing_button'>";
                                if ($package->order_status == 1) {
                                    $packageSec .= "<a href='" . route('front.packageorder.index', $package->id) . "' class='lawyer_btn'>" . __('Place Order') . "</a>";
                                }
                                $packageSec .= "</div>
                                </div>";
                            }
                            $packageSec .= "</div>
                        </div>

                    </packages-section>
                </div>
            </section>";


            $blogSec = "<section class='lawyer_blog blog_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-6'>
                            <div class='section_title'>
                                <span>" . convertUtf8($bs->blog_section_title) . "</span>
                                <h2>" . convertUtf8($bs->blog_section_subtitle) . "</h2>
                            </div>
                        </div>
                        <div class='col-lg-6'>
                            <div class='button_box float-lg-right'>
                                <a href='" . route('front.blogs') . "' class='btn_link'>" . __('View More') . "</a>
                            </div>
                        </div>
                    </div>
                    <blogs-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Blogs > Blogs</strong>
                            </div>

                            <div class='blog_slide blog-slick row'>";
                            foreach ($blogs as $key => $blog) {
                                $blogSec .= "<div class='col-lg-4 mx-0 grid_item' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable"]' . ">
                                                <div class='grid_inner_item'>
                                                    <div class='lawyer_img'>
                                                        <a href='" . route('front.blogdetails', [$blog->slug]) . "'><img data-src='" . url('assets/front/img/blogs/' . $blog->main_image) . "' class='img-fluid lazy' alt=''></a>
                                                    </div>
                                                    <div class='lawyer_content'>
                                                        <div class='post_meta'>";

                                $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$lang->code");
                                $blogDate = $blogDate->translatedFormat('d M. Y');

                                $blogSec .= "<span><i class='far fa-user'></i><a href='#'>" . __('By') . " " . __('Admin') . "</a></span>
                                                            <span><i class='far fa-calendar-alt'></i><a href='#'>" . $blogDate . "</a></span>
                                                        </div>
                                                        <h3 class='post_title'><a href='" . route('front.blogdetails', [$blog->slug]) . "'>" . (strlen($blog->title) > 40 ? mb_substr($blog->title, 0, 40, 'utf-8') . '...' : $blog->title) . "</a></h3>
                                                        <p>" . (strlen(strip_tags($blog->content)) > 100 ? mb_substr(strip_tags($blog->content), 0, 100, 'utf-8') . '...' : strip_tags($blog->content)) . "</p>
                                                        <a href='" . route('front.blogdetails', [$blog->slug]) . "' class='btn_link'>" . __('Read More') . "</a>
                                                    </div>
                                                </div>
                                            </div>";
                            }
                            $blogSec .= "</div>
                        </div>

                    </blogs-section>
                </div>
            </section>";


            $ctaSec = "<section class='lawyer_cta cta_v1 bg_image pb-mb30 lazy " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='background-image: url(" . url('assets/front/img/' . $bs->cta_bg) . "); background-size:cover; padding: 70px 0px;'>
                <div class='container'>
                    <div class='row align-items-center'>
                        <div class='col-lg-7'>
                            <div class='section_title'>
                                <h2 class='text-white'>" . convertUtf8($bs->cta_section_text) . "</h2>
                            </div>
                        </div>
                        <div class='col-lg-5'>
                            <div class='button_box'>
                                <a href='" . $bs->cta_section_button_url . "' class='lawyer_btn'>" . convertUtf8($bs->cta_section_button_text) . "</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>";


            $partnerSec = "<section class='lawyer_partner partner_v1 pb-mb30 " . ($rtl == 1 ? 'pb-rtl' : '') . "' style='padding: 90px 0px;'>
                <div class='container'>
                    <partner-section>
                        <div class='non-editable-area' data-gjs-stylable='false' data-gjs-draggable='false' data-gjs-editable='false' data-gjs-removable='false' data-gjs-propagate=" . '["removable","editable","draggable","stylable"]' . ">
                            <div class='non-editable-notice'>
                                <h3>Non-Editable Area</h3>
                                Manage From <br><strong>Content Management > Home Page Section > Partners</strong>
                            </div>
                            <div class='partner_slide row'>";
                            foreach ($partners as $key => $partner) {
                                $partnerSec .= "<div class='single_partner col-lg-3 mx-0'>
                                    <a href='" . $partner->url . "'><img data-src='" . url('assets/front/img/partners/' . $partner->image) . "' class='img-fluid lazy' alt=''></a>
                                </div>";
                            }
                            $partnerSec .= "</div>
                        </div>
                    </partner-section>

                </div>
            </section>";
        }

        $data['introsec'] = $introsec;
        $data['approachsec'] = $approachsec;
        $data['scatsec'] = $scatsec;
        $data['servicesSec'] = $servicesSec;
        $data['portfoliosSec'] = $portfoliosSec;
        $data['teamSec'] = $teamSec;
        $data['statisticSec'] = $statisticSec;
        $data['faqSec'] = $faqSec;
        $data['testimonialSec'] = $testimonialSec;
        $data['packageSec'] = $packageSec;
        $data['blogSec'] = $blogSec;
        $data['ctaSec'] = $ctaSec;
        $data['partnerSec'] = $partnerSec;


        $data['abe'] = $be;
        $data['version'] = $version;

        $components = !empty($data['components']) ? json_decode($data['components'], true) : [];
        $components = str_replace("{base_url}", url('/'), json_encode($components));
        $data['components'] = json_decode($components, true);

        $styles = !empty($data['styles']) ? json_decode($data['styles'], true) : [];
        $styles = str_replace("{base_url}", url('/'), json_encode($styles));
        $data['styles'] = json_decode($styles, true);

        $data['bookworm_blocks'] = $bookworm_blocks;

        return view('admin.pagebuilder.content', $data);
    }
}
