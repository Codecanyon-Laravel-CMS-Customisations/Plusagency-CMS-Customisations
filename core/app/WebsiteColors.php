<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteColors extends Model
{
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
            ],
        ],
    ];

    public function getElementAttribute(string $element = null)
    {
        return html_entity_decode($element);
    }

    // public function getColorSelectionsAttribute()
    // {
    //     return collect($this->COLOR_SELECTIONS);
    // }
}
