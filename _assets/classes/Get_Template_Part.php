<?php
/* 
 * Get Template Part
 *
 */

/**
 *
 * Include a file and(optionally) pass arguments to it.
 *
 * @param string $file The file path, relative to theme root
 * @param array $args The arguments to pass to this file. Optional.
 * Default empty array.
 *
 * @return object Use render() method to display the content.
 */
if ( ! class_exists('Get_Template_Part') ) {
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
				include( locate_template($this->file) );//Theme Check free. Child themes support.
			}
		}

		public static function get_part($file, $args = array()){
	        $template = new Get_Template_Part($file, $args);
    	    $template->render();
		}
	}
}


?>