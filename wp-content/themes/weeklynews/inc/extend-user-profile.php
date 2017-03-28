<?php
if ( ! function_exists( 'miptheme_modify_contact_methods' ) ) {
    function miptheme_modify_contact_methods($profile_fields) {
    
        // Add new fields
        $profile_fields['twitter'] = 'Twitter Username';
        $profile_fields['facebook'] = 'Facebook URL';
        $profile_fields['linkedin'] = 'LinkedIn URL';
        $profile_fields['gplus'] = 'Google+ URL';
        $profile_fields['vimeo'] = 'Vimeo URL';
        $profile_fields['tumblr'] = 'Tumblr URL';
        $profile_fields['flickr'] = 'Flickr URL';
    
        return $profile_fields;
    }
}