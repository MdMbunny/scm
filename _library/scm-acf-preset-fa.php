<?php

/**
* scm-acf-preset-fa.php.
*
* Font Awesome icons subsets.
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage ACF/Preset
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 1.0 Filter
// 2.0 Choices
//
// ------------------------------------------------------

// ------------------------------------------------------
// 1.0 FILTER
// ------------------------------------------------------

/**
* [GET] Get FA icon choices preset by group and list
*
* Example usage:
```php
// Get social > facebook + twitter FA icons
scm_acf_field_fa( 'social', [ 'facebook', 'twitter' ] );
```
*
* @see scm_acf_field_fa_preset()
*
* @param {string} group FA group name.
* @param {array|string=} filter Filter group by one or more categories (default is '').
* @return {array} List of FA icons.
*/
function scm_acf_field_fa( $group = NULL, $filter = '' ){

	$choices = array();
	if( is_null( $group ) ) return $choices;
	$fa = scm_acf_field_fa_preset( $group );
	$filter = toArray( $filter, false, true );

	if( isset( $fa ) ){
		
		if( $filter ){
			foreach $filter as $value)
				$choices = ( isset( $fa[$value] ) ? array_merge( $choices, $fa[$value]['choices'] ) : $choices );
		}
		
		if( empty( $choices ) ){
    		foreach ( $fa as $value)
				$choices = array_merge( $choices, $value['choices'] );
		}
	}

	return $choices;
}

// ------------------------------------------------------
// 1.0 CHOICES
// ------------------------------------------------------

/**
* [GET] Get FA icon choices by group
*
* Each group contains categories.
* Each category contains 'name', 'color' and 'choices' attributes.
*
* Example usage:
```php
// Get typography FA icons
$icons = scm_acf_field_fa_preset( 'typography' );
```
*
* Complete structure:
```php
// typography:
` [
` 	'quote' => [
` 		'name' => __( 'Virgolette', SCM_THEME ),
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-quote-left',
` 			'fa-quote-right',
` 			'fa-angle-double-left',
` 			'fa-angle-double-right',
` 			'fa-angle-left',
` 			'fa-angle-right',
` 			'fa-hand-o-left',
` 			'fa-hand-o-right',
` 			'fa-minus',
` 		],
` 	],
` ];
` 
// social:
` [
` 	'deviantart' => [
` 		'name' => 'DeviantArt',
` 		'color' => '#05cc47',
` 		'choices' => [
` 			'fa-deviantart',
` 		],
` 	],
` 	'facebook' => [
` 		'name' => 'Facebook',
` 		'color' => '#3b5998',
` 		'choices' => [
` 			'fa-facebook',
` 			'fa-facebook-official',
` 			'fa-facebook-square',
` 		],
` 	],
` 	'flickr' => [
` 		'name' => 'Flickr',
` 		'color' => '#ff0084',
` 		'choices' => [
` 			'fa-flickr',
` 		],
` 	],
` 	'github' => [
` 		'name' => 'GitHub',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-github',
` 			'fa-github-alt',
` 			'fa-github-square',
` 		],
` 	],
` 	'google' => [
` 		'name' => 'Google Plus',
` 		'color' => '#db4733',
` 		'choices' => [
` 			'fa-google-plus',
` 			'fa-google-plus-square',
` 		],
` 	],		
` 	'instagram' => [
` 		'name' => 'Instagram',
` 		'color' => '#3f729b',
` 		'choices' => [
` 			'fa-instagram',
` 		],
` 	],
` 	'lastfm' => [
` 		'name' => 'LastFM',
` 		'color' => '#2ebd59',
` 		'choices' => [
` 			'fa-lastfm',
` 			'fa-lastfm-square',
` 		],
` 	],
` 	'linkedin' => [
` 		'name' => 'Linked In',
` 		'color' => '#4875B4',
` 		'choices' => [
` 			'fa-linkedin',
` 			'fa-linkedin-square',
` 		],
` 	],		
` 	'pinterest' => [
` 		'name' => 'Pinterest',
` 		'color' => '#bd081c',
` 		'choices' => [
` 			'fa-pinterest',
` 			'fa-pinterest-p',
` 			'fa-pinterest-square',
` 		],
` 	],
` 	'reddit' => [
` 		'name' => 'Reddit',
` 		'color' => '#ff4500',
` 		'choices' => [
` 			'fa-reddit',
` 			'fa-reddit-square',
` 		],
` 	],
` 	'soundcloud' => [
` 		'name' => 'SoundCloud',
` 		'color' => '#2ebd59',
` 		'choices' => [
` 			'fa-soundcloud',
` 		],
` 	],
` 	'spotify' => [
` 		'name' => 'Spotify',
` 		'color' => '#2ebd59',
` 		'choices' => [
` 			'fa-spotify',
` 		],
` 	],
` 	'tumblr' => [
` 		'name' => 'Tumblr',
` 		'color' => '#bd4364',
` 		'choices' => [
` 			'fa-tumblr',
` 			'fa-tumblr-square',
` 		],
` 	],
` 	'twitter' => [
` 		'name' => 'Twitter',
` 		'color' => '#55acee',
` 		'choices' => [
` 			'fa-twitter',
` 			'fa-twitter-square',
` 		],
` 	],
` 	'xing' => [
` 		'name' => 'Xing',
` 		'color' => '#026466',
` 		'choices' => [
` 			'fa-xing',
` 			'fa-xing-square',
` 		],
` 	],
` 	'youtube' => [
` 		'name' => 'YouTube',
` 		'color' => '#cc181e',
` 		'choices' => [
` 			'fa-youtube',
` 			'fa-youtube-play',
` 			'fa-youtube-square',
` 		],
` 	],
` 	'other' => [
` 		'name' => 'Altri',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-dribbble',
` 			'fa-digg',
` 			'fa-delicious',
` 			'fa-behance',
` 			'fa-behance-square',
` 			'fa-bitbucket',
` 			'fa-bitbucket-square',
` 			'fa-share-alt',
` 			'fa-share-alt-square',
` 		],
` 	],
` ];
` 
// contact:
` [
` 	'web' => [
` 		'name' => 'Web',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-globe',
` 			'fa-link',
` 			'fa-external-link',
` 			'fa-external-link-square',
` 			'fa-sitemap',
` 		],
` 	],
` 
` 	'email' => [
` 		'name' => 'Email',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-envelope-o',
` 			'fa-envelope',
` 			'fa-envelope-square',
` 			'fa-paper-plane-o',
` 			'fa-paper-plane',
` 			'fa-pencil-o',
` 			'fa-pencil',
` 			'fa-pencil-square',
` 		],
` 	],
` 
` 	'skype' => [
` 		'name' => 'Skype',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-skype',
` 		],
` 	],
` 
` 	'whatsapp' => [
` 		'name' => 'WhatsApp',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-whatsapp',
` 		],
` 	],
` 
` 	'phone' => [
` 		'name' => __( 'Telefono', SCM_THEME ),
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-phone',
` 			'fa-phone-square',
` 			'fa-mobile',
` 		],
` 	],   	
` 
` 	'fax' => [
` 		'name' => __( 'Fax', SCM_THEME ),
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-fax',
` 			'fa-file',
` 			'fa-file-o',
` 			'fa-file-text',
` 			'fa-file-text-o',
` 			'fa-files-o',
` 		],
` 	],
` ];
` 
// brand:
` [
` 
` 	'chat' => [
` 		'name' => 'Chat',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-skype',
` 			'fa-whatsapp',
` 		],
` 	],
` 
` 	'social' => [
` 		'name' => 'Social',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-facebook',
` 			'fa-facebook-official',
` 			'fa-facebook-square',
` 			'fa-twitter',
` 			'fa-twitter-square',
` 			'fa-google-plus',
` 			'fa-google-plus-square',
` 			'fa-tumblr',
` 			'fa-tumblr-square',
` 			'fa-reddit',
` 			'fa-reddit-square',
` 			'fa-pinterest',
` 			'fa-pinterest-p',
` 			'fa-pinterest-square',
` 			'fa-dribbble',
` 			'fa-digg',
` 			'fa-delicious',
` 			'fa-behance',
` 			'fa-behance-square',
` 			'fa-bitbucket',
` 			'fa-bitbucket-square',
` 			'fa-share-alt',
` 			'fa-share-alt-square',
` 		],
` 	],
` 
` 	'job' => [
` 		'name' => 'Job',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-linkedin',
` 			'fa-linkedin-square',
` 			'fa-xing',
` 			'fa-xing-square',
` 		],
` 	],
` 
` 	'cloud' => [
` 		'name' => 'Cloud',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-dropbox',
` 		],
` 	],
` 
` 	'blog' => [
` 		'name' => 'Blog',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-wordpress',
` 			'fa-joomla',
` 			'fa-drupal',
` 		],
` 	],
` 
` 	'code' => [
` 		'name' => 'Code',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-html5',
` 			'fa-css3',
` 			'fa-jsfiddle',
` 			'fa-codepen',
` 			'fa-stack-overflow',
` 			'fa-git',
` 			'fa-git-square',
` 			'fa-github',
` 			'fa-github-alt',
` 			'fa-github-square',
` 			'fa-hacker-news',
` 		],
` 	],
` 
` 	'search' => [
` 		'name' => 'Search',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-google',
` 			'fa-yahoo',
` 			'fa-stack-exchange',
` 			'fa-yelp',
` 		],
` 	],
` 
` 	'video' => [
` 		'name' => 'Video',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-twitch',
` 			'fa-vimeo-square',
` 			'fa-vine',
` 			'fa-youtube',
` 			'fa-youtube-play',
` 			'fa-youtube-square',
` 		],
` 	],
` 
` 	'music' => [
` 		'name' => 'Music',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-spotify',
` 			'fa-soundcloud',
` 			'fa-lastfm',
` 			'fa-lastfm-square',
` 		],
` 	],
` 
` 	'image' => [
` 		'name' => 'Images',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-flickr',
` 			'fa-instagram',
` 			'fa-deviantart',
` 		],
` 	],
` 
` 	'app' => [
` 		'name' => 'App and Games',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-apple',
` 			'fa-windows',
` 			'fa-linux',
` 			'fa-android',
` 			'fa-steam',
` 			'fa-steam-square',
` 		],
` 	],
` 
` 	'pay' => [
` 		'name' => 'Payments',
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-paypal',
` 			'fa-viacoin',
` 			'fa-gratipay',
` 			'fa-google-wallet',
` 			'fa-cc-amex',
` 			'fa-cc-discover',
` 			'fa-cc-mastercard',
` 			'fa-cc-paypal',
` 			'fa-cc-stripe',
` 			'fa-cc-visa',
` 			'fa-btc',
` 		],
` 	],
` 
` 	'other' => [
` 		'name' => __( 'Altri', SCM_THEME ),
` 		'color' => '#333333',
` 		'choices' => [
` 			'fa-adn',
` 			'fa-angellist',
` 			'fa-buysellads',
` 			'fa-connectdevelop',
` 			'fa-dashcube',
` 			'fa-empire',
` 			'fa-forumbee',
` 			'fa-foursquare',
` 			'fa-ioxhost',
` 			'fa-leanpub',
` 			'fa-maxcdn',
` 			'fa-meanpath',
` 			'fa-medium',
` 			'fa-openid',
` 			'fa-pagelines',
` 			'fa-pied-piper',
` 			'fa-pied-piper-alt',
` 			'fa-qq',
` 			'fa-rebel',
` 			'fa-renren',
` 			'fa-sellsy',
` 			'fa-shirtsinbulk',
` 			'fa-simplybuilt',
` 			'fa-skyatlas',
` 			'fa-slack',
` 			'fa-slideshare',
` 			'fa-stumbleupon',
` 			'fa-stumbleupon-circle',
` 			'fa-tencent-weibo',
` 			'fa-trello',
` 			'fa-vk',
` 			'fa-weibo',
` 			'fa-weixin',
` 		],
` 	],
` ];
```
*
* @param {string=} group FA group name (default is '').
* @return {array} List of FA icons or NULL if group does not exist.
*/
function scm_acf_field_fa_preset( $group = '' ){

	$choices = array();

	switch ($group) {

		case 'typography':
			$choices = array(
				'quote' => array(
					'name' => __( 'Virgolette', SCM_THEME ),
					'color' => '#333333',
					'choices' => array(
						'fa-quote-left',
						'fa-quote-right',
						'fa-angle-double-left',
						'fa-angle-double-right',
						'fa-angle-left',
						'fa-angle-right',
						'fa-hand-o-left',
						'fa-hand-o-right',
						'fa-minus',
					),
				),
			);
		break;

		case 'social':
			$choices = array(
				'deviantart' => array(
					'name' => 'DeviantArt',
					'color' => '#05cc47',
					'choices' => array(
						'fa-deviantart',
					),
				),
				'facebook' => array(
					'name' => 'Facebook',
					'color' => '#3b5998',
					'choices' => array(
						'fa-facebook',
						'fa-facebook-official',
						'fa-facebook-square',
					),
				),
				'flickr' => array(
					'name' => 'Flickr',
					'color' => '#ff0084',
					'choices' => array(
						'fa-flickr',
					),
				),
				'github' => array(
					'name' => 'GitHub',
					'color' => '#333333',
					'choices' => array(
						'fa-github',
						'fa-github-alt',
						'fa-github-square',
					),
				),
				'google' => array(
					'name' => 'Google Plus',
					'color' => '#db4733',
					'choices' => array(
						'fa-google-plus',
						'fa-google-plus-square',
					),
				),		
				'instagram' => array(
					'name' => 'Instagram',
					'color' => '#3f729b',
					'choices' => array(
						'fa-instagram',
					),
				),
				'lastfm' => array(
					'name' => 'LastFM',
					'color' => '#2ebd59',
					'choices' => array(
						'fa-lastfm',
						'fa-lastfm-square',
					),
				),
				'linkedin' => array(
					'name' => 'Linked In',
					'color' => '#4875B4',
					'choices' => array(
						'fa-linkedin',
						'fa-linkedin-square',
					),
				),		
				'pinterest' => array(
					'name' => 'Pinterest',
					'color' => '#bd081c',
					'choices' => array(
						'fa-pinterest',
						'fa-pinterest-p',
						'fa-pinterest-square',
					),
				),
				'reddit' => array(
					'name' => 'Reddit',
					'color' => '#ff4500',
					'choices' => array(
						'fa-reddit',
						'fa-reddit-square',
					),
				),
				'soundcloud' => array(
					'name' => 'SoundCloud',
					'color' => '#2ebd59',
					'choices' => array(
						'fa-soundcloud',
					),
				),
				'spotify' => array(
					'name' => 'Spotify',
					'color' => '#2ebd59',
					'choices' => array(
						'fa-spotify',
					),
				),
				'tumblr' => array(
					'name' => 'Tumblr',
					'color' => '#bd4364',
					'choices' => array(
						'fa-tumblr',
						'fa-tumblr-square',
					),
				),
				'twitter' => array(
					'name' => 'Twitter',
					'color' => '#55acee',
					'choices' => array(
						'fa-twitter',
						'fa-twitter-square',
					),
				),
				'xing' => array(
					'name' => 'Xing',
					'color' => '#026466',
					'choices' => array(
						'fa-xing',
						'fa-xing-square',
					),
				),
				'youtube' => array(
					'name' => 'YouTube',
					'color' => '#cc181e',
					'choices' => array(
						'fa-youtube',
						'fa-youtube-play',
						'fa-youtube-square',
					),
				),
				'other' => array(
					'name' => 'Altri',
					'color' => '#333333',
					'choices' => array(
						'fa-dribbble',
						'fa-digg',
						'fa-delicious',
						'fa-behance',
						'fa-behance-square',
						'fa-bitbucket',
						'fa-bitbucket-square',
						'fa-share-alt',
						'fa-share-alt-square',
					),
				),
			);
		break;

		case 'contact':
			$choices = array(
				'web' => array(
					'name' => 'Web',
					'color' => '#333333',
					'choices' => array(
						'fa-globe',
						'fa-link',
						'fa-external-link',
						'fa-external-link-square',
						'fa-sitemap',
					),
				),

				'email' => array(
					'name' => 'Email',
					'color' => '#333333',
					'choices' => array(
						'fa-envelope-o',
						'fa-envelope',
						'fa-envelope-square',
						'fa-paper-plane-o',
						'fa-paper-plane',
						'fa-pencil-o',
						'fa-pencil',
						'fa-pencil-square',
					),
				),

				'skype' => array(
					'name' => 'Skype',
					'color' => '#333333',
					'choices' => array(
						'fa-skype',
					),
				),

				'whatsapp' => array(
					'name' => 'WhatsApp',
					'color' => '#333333',
					'choices' => array(
						'fa-whatsapp',
					),
				),

				'phone' => array(
					'name' => __( 'Telefono', SCM_THEME ),
					'color' => '#333333',
					'choices' => array(
						'fa-phone',
						'fa-phone-square',
						'fa-mobile',
					),
				),   	

				'fax' => array(
					'name' => __( 'Fax', SCM_THEME ),
					'color' => '#333333',
					'choices' => array(
						'fa-fax',
						'fa-file',
						'fa-file-o',
						'fa-file-text',
						'fa-file-text-o',
						'fa-files-o',
					),
				),
			);
		break;

		case 'brand':
			$choices = array(

			// CONTACTS

				// CHAT
				'chat' => array(
					'name' => 'Chat',
					'color' => '#333333',
					'choices' => array(
						'fa-skype',
						'fa-whatsapp',
					),
				),

				// SOCIAL
				'social' => array(
					'name' => 'Social',
					'color' => '#333333',
					'choices' => array(
						'fa-facebook',
						'fa-facebook-official',
						'fa-facebook-square',
						'fa-twitter',
						'fa-twitter-square',
						'fa-google-plus',
						'fa-google-plus-square',
						'fa-tumblr',
						'fa-tumblr-square',
						'fa-reddit',
						'fa-reddit-square',
						'fa-pinterest',
						'fa-pinterest-p',
						'fa-pinterest-square',
						'fa-dribbble',
						'fa-digg',
						'fa-delicious',
						'fa-behance',
						'fa-behance-square',
						'fa-bitbucket',
						'fa-bitbucket-square',
						'fa-share-alt',
						'fa-share-alt-square',
					),
				),

				// SOCIAL JOB
				'job' => array(
					'name' => 'Job',
					'color' => '#333333',
					'choices' => array(
						'fa-linkedin',
						'fa-linkedin-square',
						'fa-xing',
						'fa-xing-square',
					),
				),

			// WEB

				// CLOUD
				'cloud' => array(
					'name' => 'Cloud',
					'color' => '#333333',
					'choices' => array(
						'fa-dropbox',
					),
				),

				// BLOGGING
				'blog' => array(
					'name' => 'Blog',
					'color' => '#333333',
					'choices' => array(
						'fa-wordpress',
						'fa-joomla',
						'fa-drupal',
					),
				),

				// CODING
				'code' => array(
					'name' => 'Code',
					'color' => '#333333',
					'choices' => array(
						'fa-html5',
						'fa-css3',
						'fa-jsfiddle',
						'fa-codepen',
						'fa-stack-overflow',
						'fa-git',
						'fa-git-square',
						'fa-github',
						'fa-github-alt',
						'fa-github-square',
						'fa-hacker-news',
					),
				),

				// SEARCH ENGINE
				'search' => array(
					'name' => 'Search',
					'color' => '#333333',
					'choices' => array(
						'fa-google',
						'fa-yahoo',
						'fa-stack-exchange',
						'fa-yelp',
					),
				),

			// MULTIMEDIA

				// VIDEO
				'video' => array(
					'name' => 'Video',
					'color' => '#333333',
					'choices' => array(
						'fa-twitch',
						'fa-vimeo-square',
						'fa-vine',
						'fa-youtube',
						'fa-youtube-play',
						'fa-youtube-square',
					),
				),

				// MUSIC
				'music' => array(
					'name' => 'Music',
					'color' => '#333333',
					'choices' => array(
						'fa-spotify',
						'fa-soundcloud',
						'fa-lastfm',
						'fa-lastfm-square',
					),
				),

				// IMAGES
				'image' => array(
					'name' => 'Images',
					'color' => '#333333',
					'choices' => array(
						'fa-flickr',
						'fa-instagram',
						'fa-deviantart',
					),
				),

			// SOFTWARES

				// APP & GAMES
				'app' => array(
					'name' => 'App and Games',
					'color' => '#333333',
					'choices' => array(
						'fa-apple',
						'fa-windows',
						'fa-linux',
						'fa-android',
						'fa-steam',
						'fa-steam-square',
					),
				),

			// COMMERCE

				// PAGAMENTI
				'pay' => array(
					'name' => 'Payments',
					'color' => '#333333',
					'choices' => array(
						'fa-paypal',
						'fa-viacoin',
						'fa-gratipay',
						'fa-google-wallet',
						'fa-cc-amex',
						'fa-cc-discover',
						'fa-cc-mastercard',
						'fa-cc-paypal',
						'fa-cc-stripe',
						'fa-cc-visa',
						'fa-btc',
					),
				),

			// UNKNOWN

				'other' => array(
					'name' => __( 'Altri', SCM_THEME ),
					'color' => '#333333',
					'choices' => array(
						'fa-adn',
						'fa-angellist',
						'fa-buysellads',
						'fa-connectdevelop',
						'fa-dashcube',
						'fa-empire',
						'fa-forumbee',
						'fa-foursquare',
						'fa-ioxhost',
						'fa-leanpub',
						'fa-maxcdn',
						'fa-meanpath',
						'fa-medium',
						'fa-openid',
						'fa-pagelines',
						'fa-pied-piper',
						'fa-pied-piper-alt',
						'fa-qq',
						'fa-rebel',
						'fa-renren',
						'fa-sellsy',
						'fa-shirtsinbulk',
						'fa-simplybuilt',
						'fa-skyatlas',
						'fa-slack',
						'fa-slideshare',
						'fa-stumbleupon',
						'fa-stumbleupon-circle',
						'fa-tencent-weibo',
						'fa-trello',
						'fa-vk',
						'fa-weibo',
						'fa-weixin',
					),
				),
			);
		break;

		default: return NULL; break;
	}

	return $choices;
}

?>