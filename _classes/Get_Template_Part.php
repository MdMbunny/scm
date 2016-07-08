<?php

if ( ! class_exists('Get_Template_Part') ) {

/**
 * Get_Template_Part.php
 *
 * Include a file and (optionally) pass arguments to it.
 *
 * Example usage:
 *
```php
$args = array(
    'acf_fc_layout' => 'layout-titolo',
    'title' => '',
    'tag' => 'h1',
    'prepend' => 'no',
    'append' => 'no',
    'id' => '',
    'class' => '',
    'attributes' => '',
    'style' => '',
);

Get_Template_Part::get_part( '_parts/single/single-title.php', array( 'cont' => $args ));
```
 *
 * @param string $file The file path, relative to theme root
 * @param array $args The arguments to pass to this file. Optional.
 * Default empty array.
 *
 * @return object Use render() method to display the content.
 *
 * @link http://www.studiocreativo-m.it
 *
 * @package SCM
 * @subpackage Classes
 * @since 1.0.0
 */
	class Get_Template_Part{
		private $args;
		private $file;
 
		public function __get($name) {
			return $this->args[$name];
		}
 
		public function __construct($file, $args = array()) {
			$this->file = $file;
			$this->args = $args;
		}
 
		public function __isset($name){
			return isset( $this->args[$name] );
		}
 
		public function render() {
			if( locate_template($this->file) ){
				include( locate_template($this->file) );
			}
		}

		public static function get_part($file, $args = array()){
	        $template = new Get_Template_Part($file, $args);
    	    $template->render();
		}
	}
	
}


?>