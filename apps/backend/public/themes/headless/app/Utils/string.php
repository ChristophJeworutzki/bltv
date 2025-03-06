<?php

namespace App\Utils;

// Helper function to pluralize a string eg. 'user' => 'users'
function pluralize($singular) {
    $last = strtolower(substr($singular, -1));
    switch ($last) {
        case 's':
            return $singular . 'es';
        case 'y':
            return substr($singular, 0, -1) . 'ies';
        default:
            return $singular . 's';
    }
}
