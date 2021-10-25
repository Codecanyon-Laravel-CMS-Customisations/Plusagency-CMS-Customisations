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
                    "section_title"         => "Website body section",
                    "section_description"   => "This color settings will affect entire website page contents so take care",
                    "attr_default"          => "body",
                    "attr_hover"            => "body:hover",
                ],
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
                    "section_title"         => "Website header section",
                    "section_description"   => "This color settings will affect all website header colors",
                    "attr_default"          => "header, header .masthead div",
                    "attr_hover"            => "header:hover, , header .masthead div:hover",
                    "important_default"     => " !important",
                    "important_hover"       => " !important",
                ],
                [
                    "section_title"         => "Search bar button",
                    "section_description"   => "This area controls the look of the search button in the header section",
                    "attr_default"          => "header .btn-search",
                    "attr_hover"            => "header .btn-search:hover",
                ],
                [
                    "section_title"         => "Site Navigation top menu",
                    "section_description"   => "This area controls the look of the site top menu colors",
                    "attr_default"          => ".site-navigation > ul > li, .site-navigation > ul > li > a",
                    "attr_hover"            => ".site-navigation > ul > li:hover, .site-navigation > ul > li > a:hover",
                ],
                [
                    "section_title"         => "Site Navigation dropdown menu",
                    "section_description"   => "This area controls the look of the site dropdown menu colors",
                    "attr_default"          => ".site-navigation > ul > li ul > li, .site-navigation > ul > li ul > li > a",
                    "attr_hover"            => ".site-navigation > ul > li  ul > li:hover, .site-navigation > ul > li  ul > li > a:hover",
                ],
            ],
        ],
        'texts_section'             => [
            "active"                => false,
            "tab_title"             => "Texts & Headings Section",
            "elements"              => [
                [
                    "section_title"         => "Website heading 1 text",
                    "section_description"   => "This color settings will affect entire Heading 1 texts on the entire website",
                    "attr_default"          => "h1",
                    "attr_hover"            => "h1:hover",
                    // "important_default"     => " !important",
                    // "important_hover"       => " !important",
                ],
                [
                    "section_title"         => "Website heading 2 text",
                    "section_description"   => "This color settings will affect entire Heading 2 texts on the entire website",
                    "attr_default"          => "h2",
                    "attr_hover"            => "h2:hover",
                ],
                [
                    "section_title"         => "Website heading 3 text",
                    "section_description"   => "This color settings will affect entire Heading 3 texts on the entire website",
                    "attr_default"          => "h3",
                    "attr_hover"            => "h3:hover",
                ],
                [
                    "section_title"         => "Website heading 4 text",
                    "section_description"   => "This color settings will affect entire Heading 4 texts on the entire website",
                    "attr_default"          => "h4",
                    "attr_hover"            => "h4:hover",
                ],
                [
                    "section_title"         => "Website heading 5 text",
                    "section_description"   => "This color settings will affect entire Heading 5 texts on the entire website",
                    "attr_default"          => "h5",
                    "attr_hover"            => "h5:hover",
                ],
                [
                    "section_title"         => "Website heading 6 text",
                    "section_description"   => "This color settings will affect entire Heading 6 texts on the entire website",
                    "attr_default"          => "h6",
                    "attr_hover"            => "h6:hover",
                ],
                [
                    "section_title"         => "Paragraphs text",
                    "section_description"   => "This color settings will affect app paragraph texts on the website",
                    "attr_default"          => "p",
                    "attr_hover"            => "p:hover",
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
                    "attr_hover"            => ".pagebuilder-content .nav .nav-item:hover *,.pagebuilder-content .nav .nav-item a:hover *",
                    "important_default"     => " ",
                    "important_hover"       => " !important",
                ],
                [
                    "section_title"         => "Pagebuilder tabs Arrow",
                    "section_description"   => "This section involves setting color themes for tab arrow that shows which tab is active",
                    "attr_default"          => ".pagebuilder-content .nav-link-caret.active::after",
                    "attr_hover"            => ".pagebuilder-content .nav-link-caret.hover::after",
                    "attr_config"           => "border-bottom-color",
                    "attr_mono"             => true,
                ],
            ],
        ],
        'tables_section'            => [
            "active"                => false,
            "tab_title"             => "Tables Section",
            "elements"              => [
                [
                    "section_title"         => "Website tables section",
                    "section_description"   => "This color settings will affect all website table elements",
                    "attr_default"          => "table",
                    "attr_hover"            => "table:hover",
                ],
                [
                    "section_title"         => "Table Headers",
                    "section_description"   => "This color settings will affect all table headers",
                    "attr_default"          => "table thead",
                    "attr_hover"            => "table thead:hover",
                ],
                [
                    "section_title"         => "Table Body",
                    "section_description"   => "This color settings will affect all table body",
                    "attr_default"          => "table tbody",
                    "attr_hover"            => "table tbody:hover",
                ],
                [
                    "section_title"         => "Table rows",
                    "section_description"   => "This color settings will affect all table rows",
                    "attr_default"          => "table tr",
                    "attr_hover"            => "table tr:hover",
                ],
                [
                    "section_title"         => "Table cells",
                    "section_description"   => "This color settings will affect all table cells",
                    "attr_default"          => "table td",
                    "attr_hover"            => "table td:hover",
                ],
            ],
        ],
        'forms_section'            => [
            "active"                => false,
            "tab_title"             => "Forms Section",
            "elements"              => [
                [
                    "section_title"         => "Website forms section",
                    "section_description"   => "This color settings will affect all website form elements",
                    "attr_default"          => "form",
                    "attr_hover"            => "form:hover",
                ],
                [
                    "section_title"         => "Form labels",
                    "section_description"   => "This color settings will affect all form labels",
                    "attr_default"          => "label",
                    "attr_hover"            => "label:hover",
                ],
                [
                    "section_title"         => "Form inputs",
                    "section_description"   => "This color settings will affect all form elements of type input",
                    "attr_default"          => "input",
                    "attr_hover"            => "input:hover",
                ],
                [
                    "section_title"         => "Form Select Dropdown",
                    "section_description"   => "This color settings will affect all form elements of type select",
                    "attr_default"          => "select",
                    "attr_hover"            => "select:hover",
                ],
                [
                    "section_title"         => "Form Select Dropdown Options",
                    "section_description"   => "This color settings will affect all form elements of type select options",
                    "attr_default"          => "option",
                    "attr_hover"            => "option:hover",
                ],
                [
                    "section_title"         => "Form textarea fields",
                    "section_description"   => "This color settings will affect all form elements of type textarea",
                    "attr_default"          => "textarea",
                    "attr_hover"            => "textarea:hover",
                ],
            ],
        ],
        'footer_section'            => [
            "active"                => false,
            "tab_title"             => "Footer Section",
            "elements"              => [
                [
                    "section_title"         => "Website footer section",
                    "section_description"   => "This color settings will affect all website footer colors",
                    "attr_default"          => "footer, footer div",
                    "attr_hover"            => "footer:hover, footer div:hover",
                    "important_default"     => " !important",
                    "important_hover"       => " !important",
                ],
                [
                    "section_title"         => "Footer links",
                    "section_description"   => "This color settings will affect all footer links colors",
                    "attr_default"          => "footer a, footer a *",
                    "attr_hover"            => "footer a:hover, footer a *:hover",
                ],
            ],
        ],
    ];

    // public function getColorSelectionsAttribute()
    // {
    //     return collect($this->COLOR_SELECTIONS);
    // }
}
