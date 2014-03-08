<?php

// Spark Child Theme

/* 
	NOTE: 
		get_template_directory_uri(); returns the path to the PARENT theme directory.
	 	get_stylesheet_directory_uri(); returns the path to this current CHILD theme directory.
*/


// Here is how to enqueue CSS and JS files properly:
add_action('init', 'my_custom_js_and_css', 99);
function my_custom_js_and_css() {
	
	// Enqueue "style.css" from current Child Theme
	spark_add_styles(array('my-custom-css' => array('url' => get_stylesheet_directory_uri() . '/style.css')));

	// Enqueue "scripts.js" from current Child Theme
	// spark_add_scripts(array('my-custom-js' => array('url' => get_stylesheet_directory_uri().'/scripts.js', 'depends_on' => array('jquery'))));

}



// If you want to REMOVE CSS or JS files that are enqueued by the Spark Parent Theme, 
// then copy/past the content from /core/css-frontend.php to here and then edit the 2 main arrays by removing the unwanted styles/scripts from it.


// Tip: You can easily "override" most functions from the Spark Theme, 
// as most of them check for "if function_exists(...)" before defining the function, 
// therefor you can copy/past functions (only those with a "function_exists()" check) from the Spark theme and edit them here.



