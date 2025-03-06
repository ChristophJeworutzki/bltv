<?php

function transform_oembed($value, $post_id, $field) {

    // Step 1: Extract the src attribute from the iframe
    preg_match('/src="([^"]+)"/', $value, $matches);

    if (isset($matches[1])) {

        // Extract the src URL from the first match
        $src = $matches[1];

        // Replace the base URL to use 'youtube-nocookie.com'
        $urls = ['www.youtube.com', 'youtube.com', 'youtu.be'];

        // Create a regex pattern to match any of the URLs
        $pattern = '/(' . implode('|', array_map('preg_quote', $urls)) . ')/';

        // Bail early if the src is not from YouTube
        if (!preg_match($pattern, $src)) {
            return $value;
        }

        // Replace the base URL with 'youtube-nocookie.com'
        $src = str_replace($urls, 'www.youtube-nocookie.com', $src);

        // Parse the URL and add minimal player parameters
        $parsed_url = parse_url($src);
        $base_url = "{$parsed_url['scheme']}://{$parsed_url['host']}{$parsed_url['path']}";

        // Merge existing query params with new ones
        parse_str($parsed_url['query'] ?? '', $query_params);
        $query_params = array_merge($query_params, [
            'modestbranding' => 1, // Minimal branding
            'controls' => 1,       // Hide player controls
            'rel' => 0,            // Disable related videos
            'showinfo' => 0,       // Hide video info
            'autoplay' => 1        // Autoplay video
        ]);

        // Build the new URL with updated query string
        $new_src = $base_url . '?' . http_build_query($query_params);

        // Replace the src in the original iframe
        $value = str_replace($matches[1], $new_src, $value);
    }

    return $value;
}

add_filter('acf/format_value/type=oembed', 'transform_oembed', 20, 3);
