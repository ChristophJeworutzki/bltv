<?php
// Function to load ratio choices into a field
function load_ratio_choices($field) {
    $field['choices'] = [
        'auto' => 'Auto',
        '16:9' => '16:9',
        '3:2' => '3:2',
        '4:3' => '4:3',
        '5:4' => '5:4',
        '1:1' => '1:1',
        '9:16' => '9:16',
        '2:3' => '2:3',
        '3:4' => '3:4',
        '4:5' => '4:5',
    ];
    return $field;
}

add_filter('acf/load_field/name=ratio', 'load_ratio_choices');
