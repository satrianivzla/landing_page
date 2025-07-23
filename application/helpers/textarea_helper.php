<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('generate_summernote_textarea')) {
    function generate_summernote_textarea($name, $label, $value) {
        $ci =& get_instance();
        $ci->load->helper('form');

        $output = '<div class="mb-3">';
        $output .= form_label($label, $name, ['class' => 'form-label']);
        $output .= form_textarea([
            'name'  => $name,
            'id'    => $name,
            'class' => 'form-control summernote',
            'value' => $value
        ]);
        $output .= '</div>';

        return $output;
    }
}
