<?php

namespace App\Utils;

function get_aspect_ratio($w, $h) {
    if (!$w || !$h) return;

    // Helper function to calculate the greatest common divisor (GCD)
    $gcd = function ($w, $h) use (&$gcd) {
        return ($h == 0) ? $w : $gcd($h, $w % $h);
    };

    $g = $gcd($w, $h);
    $simplified_w = $w / $g;
    $simplified_h = $h / $g;

    return $simplified_w . ':' . $simplified_h;
}

function get_orientation($w, $h) {
    return $w > $h ? 'landscape' : 'portrait';
}
