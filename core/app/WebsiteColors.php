<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteColors extends Model
{
    protected $fillable     = ['element', 'attribute', 'value'];

    public const COLOR_SELECTIONS = [
        'general_section'           => [
            "active"                => true,
            "tab_title"             => "General Section",
            "elements"              => [
                [
                    "section_title"         => "Side Nav submenu Title",
                    "section_description"   => "This is the section on the side navigation menu",
                    "attr_default"          => ".zeynep .submenu-header > a",
                    "attr_hover"            => ".zeynep .submenu-header > a:hover",
                ],
                [
                    "section_title"         => "Side Nav links",
                    "section_description"   => "This is the section on the side navigation menu",
                    "attr_default"          => ".zeynep ul > li.has-submenu > a",
                    "attr_hover"            => ".zeynep ul > li.has-submenu > a:hover",
                ],
                [
                    "section_title"         => "Side Product links",
                    "section_description"   => "This is the section on the side navigation menu",
                    "attr_default"          => ".zeynep ul > li > a:not(.btn)",
                    "attr_hover"            => ".zeynep ul > li > a:not(.btn):hover",
                ],
            ],
        ],
        'header_section'            => [
            "active"                => false,
            "tab_title"             => "Header Section",
            "elements"              => [
                [
                    "section_title"         => "Search bar button",
                    "section_description"   => "This area controls the look of the search button in the header section",
                    "attr_default"          => "header .btn-search",
                    "attr_hover"            => "header .btn-search:hover",
                ],
            ],
        ],
        'pagebuilder_section'       => [
            "active"                => false,
            "tab_title"             => "Pagebuilder Section",
            "elements"              => [
                [
                    "section_title"         => "Pagebuilder tabs",
                    "section_description"   => "This section involves setting color themes for various tab items generated by the page-builder such as products under categories and child categories",
                    "attr_default"          => ".pagebuilder-content .nav .nav-item > a, .pagebuilder-content .nav .nav-item *",
                    "attr_hover"            => ".pagebuilder-content .nav .nav-item a:active  *,
                                                .pagebuilder-content .nav .nav-item a:focus  *,
                                                .pagebuilder-content .nav .nav-item a:hover *",
                ],
            ],
        ],
    ];

    // public function getColorSelectionsAttribute()
    // {
    //     return collect($this->COLOR_SELECTIONS);
    // }
}
