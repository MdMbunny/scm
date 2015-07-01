<?php

    global $SCM_fa;

// **************
// *** SOCIAL ***
// **************

	$SCM_fa['typography'] = array(
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

// **************
// *** SOCIAL ***
// **************

	$SCM_fa['social'] = array(
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

// ***************
// *** CONTACT ***
// ***************

    $SCM_fa['contact'] = array(

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

		// +++ todo: Wait for Font Awesome update (o sbircia e fatti il tuo cazzo di plugin personale, idem con Limiter e PayPal)
		/*'whatsapp' => array(
			'name' => 'WhatsApp',
			'color' => '#333333',
			'choices' => array(
				'fa-whatsapp',
			),
		),*/

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

// *************
// *** BRAND ***
// *************

    $SCM_fa['brand'] = array(

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

?>