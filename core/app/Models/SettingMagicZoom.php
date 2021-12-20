<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingMagicZoom extends Model
{
    protected $casts        = [
        'desktop_options'   => 'json',
        'mobile_options'    => 'json',
    ];

    public const D_SETTINGS = [
        [
            'key'           => 'zoomMode',
            'default'       => 'magnifier',
            'options'       => [
                'zoom',
                'magnifier',
                'preview',
                'off'
            ]
        ],
        [
            'key'           => 'zoomOn',
            'default'       => 'hover',
            'options'       => [
                'hover',
                'click'
            ]
        ],
        [
            'key'           => 'zoomPosition',
            'default'       => 'right',
            'options'       => [
                'right',
                'left',
                'top',
                'bottom',
                'inner'
            ]
        ],
        [
            'key'           => 'zoomWidth',
            'type'          => 'text',
            'default'       => 'auto',
        ],
        [
            'key'           => 'zoomHeight',
            'type'          => 'text',
            'default'       => 'auto',
        ],
        [
            'key'           => 'zoomDistance',
            'type'          => 'text',
            'default'       => '15',
        ],
        [
            'key'           => 'zoomCaption',
            'default'       => 'off',
            'options'       => [
                'off',
                'bottom',
                'top',
            ]
        ],
        [
            'key'           => 'expand',
            'default'       => 'window',
            'options'       => [
                'window',
                'fullscreen',
                'off',
            ]
        ],
        [
            'key'           => 'expandZoomMode',
            'default'       => 'zoom',
            'options'       => [
                'zoom',
                'magnifier',
                'off',
            ]
        ],
        [
            'key'           => 'expandZoomOn',
            'default'       => 'click',
            'options'       => [
                'click',
                'always',
            ]
        ],
        [
            'key'           => 'expandCaption',
            'default'       => 'true',
            'options'       => [
                'true',
                'false',
            ]
        ],
        [
            'key'           => 'closeOnClickOutside',
            'default'       => 'true',
            'options'       => [
                'true',
                'false',
            ]
        ],
        [
            'key'           => 'history',
            'default'       => 'true',
            'options'       => [
                'true',
                'false',
            ]
        ],
        [
            'key'           => 'hint',
            'default'       => 'once',
            'options'       => [
                'once',
                'always',
                'off',
            ]
        ],
        [
            'key'           => 'smoothing',
            'default'       => 'true',
            'options'       => [
                'true',
                'false',
            ]
        ],
        [
            'key'           => 'variableZoom',
            'default'       => 'false',
            'options'       => [
                'false',
                'true',
            ]
        ],
        [
            'key'           => 'lazyZoom',
            'default'       => 'false',
            'options'       => [
                'false',
                'true',
            ]
        ],
        [
            'key'           => 'upscale',
            'default'       => 'true',
            'options'       => [
                'true',
                'false',
            ]
        ],
        [
            'key'           => 'rightClick',
            'default'       => 'false',
            'options'       => [
                'false',
                'true',
            ]
        ],
        [
            'key'           => 'transitionEffect',
            'default'       => 'true',
            'options'       => [
                'true',
                'false',
            ]
        ],
        [
            'key'           => 'selectorTrigger',
            'default'       => 'click',
            'options'       => [
                'click',
                'hover',
            ]
        ],
        [
            'key'           => 'selectorTrigger',
            'default'       => 'click',
            'options'       => [
                'click',
                'hover',
            ]
        ],
        [
            'key'           => 'cssClass',
            'type'          => 'text',
            'default'       => '',
        ],
        [
            'key'           => 'textHoverZoomHint',
            'type'          => 'text',
            'default'       => 'Hover to zoom',
        ],
        [
            'key'           => 'textClickZoomHint',
            'type'          => 'text',
            'default'       => 'Click to zoom',
        ],
        [
            'key'           => 'textExpandHint',
            'type'          => 'text',
            'default'       => 'Click to expand',
        ],
        [
            'key'           => 'textBtnClose',
            'type'          => 'text',
            'default'       => 'Close',
        ],
        [
            'key'           => 'textBtnNext',
            'type'          => 'text',
            'default'       => 'Next',
        ],
        [
            'key'           => 'textBtnPrev',
            'type'          => 'text',
            'default'       => 'Previous',
        ]
    ];

    public const M_SETTINGS = [
        [
            'key'           => 'zoomMode',
            'default'       => 'magnifier',
            'options'       => [
                'zoom',
                'magnifier',
                'off'
            ]
        ],
        [
            'key'           => 'textHoverZoomHint',
            'type'          => 'text',
            'default'       => 'Touch to zoom',
        ],
        [
            'key'           => 'textClickZoomHint',
            'type'          => 'text',
            'default'       => 'Double tap or pinch to zoom',
        ],
        [
            'key'           => 'textExpandHint',
            'type'          => 'text',
            'default'       => 'Tap or pinch to expand',
        ]
    ];
}
