<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-08-17 16:47
 * @File name           : default.php
 */

return [
    'general' => [
        'space' => [
            'type' => 'string',
            'default' => '8px',
        ],
        'breakAfterRow' => [
            'type' => 'string',
            'default' => 5,
        ],
    ],
    'front' => [
        'background' => [
            'type' => 'image',
            'default' => MWB . 'membership/card/assets/bg.png',
        ],
        'photo' => [
            'show' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'width' => [
                'type' => 'string',
                'default' => '80px',
            ],
            'height' => [
                'type' => 'string',
                'default' => 'auto',
            ],
        ],
        'qrcode' => [
            'show' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'width' => [
                'type' => 'string',
                'default' => '40px',
            ],
            'height' => [
                'type' => 'string',
                'default' => '40px',
            ],
        ],
        'barcode' => [
            'show' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'width' => [
                'type' => 'string',
                'default' => '180px',
            ],
            'height' => [
                'type' => 'string',
                'default' => '40px',
            ],
        ],
        'memberName' => [
            'color' => [
                'type' => 'color',
                'default' => '#000',
            ],
            'size' => [
                'type' => 'string',
                'default' => '11pt',
            ],
        ],
        'memberId' => [
            'color' => [
                'type' => 'color',
                'default' => '#666',
            ],
            'size' => [
                'type' => 'string',
                'default' => '10pt',
            ],
        ],
        'profile' => [
            'line1' => [
                'show' => [
                    'type' => 'boolean',
                    'default' => true,
                ],
                'key' => [
                    'type' => 'key',
                    'default' => 'member_address',
                ],
                'icon' => [
                    'type' => 'image',
                    'default' => MWB . 'membership/card/assets/002-home.png',
                ],
            ],
            'line2' => [
                'show' => [
                    'type' => 'boolean',
                    'default' => true,
                ],
                'key' => [
                    'type' => 'key',
                    'default' => 'member_type_name',
                ],
                'icon' => [
                    'type' => 'image',
                    'default' => MWB . 'membership/card/assets/003-boss.png',
                ],
            ],
            'line3' => [
                'show' => [
                    'type' => 'boolean',
                    'default' => true,
                ],
                'key' => [
                    'type' => 'key',
                    'default' => 'member_email',
                ],
                'icon' => [
                    'type' => 'image',
                    'default' => MWB . 'membership/card/assets/001-gmail.png',
                ],
            ],
        ],
    ],
    'back' => [
        'layout' => [
            'type' => 'select',
            'default' => 'logo',
            'options' => ['logo', 'rules'],
        ],
        'background' => [
            'type' => 'image',
            'default' => MWB . 'membership/card/assets/bg.png',
        ],
        'logo' => [
            'path' => [
                'type' => 'image',
                'default' => MWB . 'membership/card/assets/logo.png',
            ],
            'width' => [
                'type' => 'string',
                'default' => '50px',
            ],
            'height' => [
                'type' => 'string',
                'default' => '55px',
            ],
            'libraryName' => [
                'text' => [
                    'type' => 'string',
                    'default' => 'Klaras Library',
                ],
                'color' => [
                    'type' => 'color',
                    'default' => '#000',
                ],
                'size' => [
                    'type' => 'string',
                    'default' => '16px',
                ],
            ],
            'librarySubName' => [
                'text' => [
                    'type' => 'string',
                    'default' => 'make our SLiMS special',
                ],
                'color' => [
                    'type' => 'color',
                    'default' => '#333',
                ],
                'size' => [
                    'type' => 'string',
                    'default' => '12px',
                ],
            ],
        ],
        'rules' => [
            'title' => [
                'type' => 'string',
                'default' => 'Rules',
            ],
            'rules' => [
                'type' => 'array',
                'default' => [
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'Praesent tristique magna sit amet purus gravida quis. Sapien faucibus et molestie ac feugiat sed lectus. ',
                    'Libero justo laoreet sit amet cursus sit amet dictum sit. Urna duis convallis convallis tellus id interdum.',
                ],
            ],
            'color' => [
                'type' => 'color',
                'default' => '#333',
            ],
            'size' => [
                'type' => 'string',
                'default' => '8px',
            ],
            'location' => [
                'type' => 'string',
                'default' => 'Semarang',
            ],
            'date' => [
                'type' => 'date',
                'default' => '2019-08-17',
            ],
            'headPosition' => [
                'type' => 'string',
                'default' => 'Librarian',
            ],
            'headName' => [
                'type' => 'string',
                'default' => 'Waris Agung Widodo',
            ],
            'headPid' => [
                'type' => 'string',
                'default' => '3303129986480128',
            ],
            'libraryName' => [
                'type' => 'string',
                'default' => 'Klaras Library',
            ],
            'librarySubName' => [
                'type' => 'string',
                'default' => 'make our SLiMS special',
            ],
            'stamp' => [
                'type' => 'image',
                'default' => MWB . 'membership/card/assets/stamp.png',
            ],
            'signature' => [
                'type' => 'image',
                'default' => MWB . 'membership/card/assets/signature.png',
            ],
        ],
    ],
];
