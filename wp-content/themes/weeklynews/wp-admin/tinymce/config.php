<?php

$miptheme_shortcode['miptheme_alert'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' 		=> 'select',
			'label' 	=> __('Alert Type', THEMENAME),
			'desc' 		=> __('Select Alert Type', THEMENAME),
			'options' 	=> array(
				'warning' 	=> 'warning',
				'success' 	=> 'success',
				'danger' 	=> 'error',
				'info' 		=> 'info',
			)
		),
		'content' => array(
			'std' => 'Alert Message',
			'type' => 'textarea',
			'label' => __('Alert Text', THEMENAME),
			'desc' => __('Alert Text', THEMENAME),
		),
		'close' => array(
			'type' 		=> 'select',
			'label' 	=> __('Closable', THEMENAME),
			'desc' 		=> __('Select if alert can be closed or not', THEMENAME),
			'options' 	=> array(
				'true' 		=> 'true',
				'false' 	=> 'false',
			)
		),

	),
	'shortcode' => '[miptheme_alert type="{{type}}" close="{{close}}"]{{content}}[/miptheme_alert]',
	'popup_title' => __('Insert Alert Shortcode', THEMENAME)
);


$miptheme_shortcode['miptheme_dropcap'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'R',
			'type' => 'text',
			'label' => __('Sign', THEMENAME),
			'desc' => 'Dropcap Sign',
		),
		'style' => array(
			'type' => 'select',
			'label' => __('Dropcap Style', THEMENAME),
			'desc' => '',
			'options' => array(
				'normal' => 'Normal',
				'circle' => 'Circle',
				'box' => 'Box',
				'book' => 'Book',
				'color' => 'Color',
			)
		),
		'color' => array(
			'std' => '#222222',
			'type' => 'text',
			'label' => __('Text Color', THEMENAME),
			'desc' => 'e.g. #0000000',
		),
		'background' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Background Color', THEMENAME),
			'desc' => 'e.g. #444444',
		),
	),
	'shortcode' => '[miptheme_dropcap style="{{style}}" color="{{color}}" background="{{background}}"]{{content}}[/miptheme_dropcap]',
	'popup_title' => __('Insert Dropcap Shortcode', THEMENAME)
);


$miptheme_shortcode['miptheme_list'] = array(
	'params' => array(),
    'no_preview' => true,
    'shortcode' => '[miptheme_list]{{child_shortcode}}[/miptheme_list]',
    'popup_title' => __('Insert List Shortcode', THEMENAME),

    'child_shortcode' => array(
        'params' => array(
            'icon' => array(
                'std' => 'fa-check',
                'type' => 'text',
                'label' => __('Icon', THEMENAME),
                'desc' => __('Insert any of the <a href="https://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome Icons</a>', THEMENAME),
            ),
            'content' => array(
                'std' => 'Enter List Item here',
                'type' => 'textarea',
                'label' => __('List Content', THEMENAME),
                'desc' => ''
            )
        ),
        'shortcode' => '[miptheme_listitem icon="{{icon}}"]{{content}}[/miptheme_listitem]',
        'clone_button' => __('Add List Item', THEMENAME)
    )
);


$miptheme_shortcode['miptheme_quote'] = array(
    'no_preview' => true,
    'params' => array(
        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => __('Quote Text', THEMENAME),
            'desc' => ''
        ),
        'author' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Quote Author', THEMENAME),
            'desc' => ''
        ),
		'style' => array(
			'type' 		=> 'select',
			'label' 	=> __('Quote Style', THEMENAME),
			'desc' 		=> '',
			'options' 	=> array(
				'text-center' 	=> 'Quote Center',
				'text-left' 	=> 'Quote Left',
				'text-right' 	=> 'Quote Right',
				'boxquote text-center' 		=> 'Quote Box Center',
				'boxquote text-left' 		=> 'Quote Box Left',
				'boxquote text-right' 		=> 'Quote Box Right',
				'pull-left' 		=> 'Pull Quote Left',
				'pull-right' 		=> 'Pull Quote Right'
			)
		),
    ),
	'shortcode' => '[miptheme_quote author="{{author}}" style="{{style}}"]{{content}}[/miptheme_quote]',
	'popup_title' => __('Add Quote', THEMENAME)
);



$miptheme_shortcode['miptheme_spacer'] = array(
	'no_preview' => true,
	'params' => array(
		'height' => array(
			'std' => '50',
			'type' => 'text',
			'label' => __('Height', THEMENAME),
			'desc' => 'Height in pixels (enter only number)',
		)
	),
	'shortcode' => '[miptheme_spacer height="{{height}}"]',
	'popup_title' => __('Insert Spacer Shortcode', THEMENAME)
);
