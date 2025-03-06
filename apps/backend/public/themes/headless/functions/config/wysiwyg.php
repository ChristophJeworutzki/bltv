<?php

/* Custom WYSIWYG Toolbar */
function acf_custom_wysiwyg_toolbar($toolbars) {
  $toolbars['Basic'] = array();
  $toolbars['Basic'][1] = array('bold', 'italic', 'link', 'unlink');
  $toolbars['Link'] = array();
  $toolbars['Link'][1] = array('link', 'unlink');
  if (($key = array_search('code', $toolbars['Full'][2])) !== false) {
    unset($toolbars['Full'][2][$key]);
  }
  return $toolbars;
}

function acf_custom_wysiwyg_formats($settings) {
  $settings['block_formats'] = 'Heading 3=h4; Heading 2=h3; Heading 1=h2; Paragraph=p;';
  $settings['wpautop'] = false;
  $settings['toolbar1'] = false;
  $settings['keep_styles'] = true;
  return $settings;
}

/* Clean Copy & Paste */
function custom_tinymce_config($in) {
  $in['paste_preprocess'] = "function(plugin, args){
    // Strip all HTML tags except those we have whitelisted
    var whitelist = 'p,br,em,i,strong,b,a';
    var stripped = jQuery('<div>' + args.content + '</div>');
    var els = stripped.find('*').not(whitelist);
    for (var i = els.length - 1; i >= 0; i--) {
    var e = els[i];
    jQuery(e).replaceWith(e.innerHTML);
    }
    // Strip all class and id attributes
    stripped.find('*').removeAttr('id').removeAttr('class');
    // Return the clean HTML
    args.content = stripped.html();
    }";
  return $in;
}

/* Editor Styles
---------------------------------------*/
add_theme_support('editor-styles');
add_editor_style('assets/css/editor.css');

/* Filters
---------------------------------------*/
add_filter('acf/fields/wysiwyg/toolbars', 'acf_custom_wysiwyg_toolbar');
add_filter('tiny_mce_before_init', 'acf_custom_wysiwyg_formats');
add_filter('tiny_mce_before_init', 'custom_tinymce_config');
