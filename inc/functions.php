<?php 
/* PLUGIN FUNCTIONS */

/*
*
*
* SETTINGS PAGE
*/

function wwu_settings_page(){
    // Adds the plugin settings page 
	add_submenu_page(
		'options-general.php',
		'Opzioni Call to Action',
		'Call to Action',
		'manage_options',
		'call-to-action-options',
		'wwu_settings_output' 
    );
}

function wwu_settings_output(){
    // Actually builds the plugin settings page ?>
    <div class="wrap">
        <h1><?php echo get_admin_page_title();?></h1>
        <p><?php echo esc_html( "Da questa pagina è possibile modificare il codice HTML di una Call to Action che apparirà all'interno dei post, dopo il quarto paragrafo." );?></p>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'wwu_settings' ); 
                do_settings_sections( 'wwu_call_to_action' ); 
                submit_button(); 
            ?>
        </form>
    </div>
<?php }

function wwu_settings_fields(){
	// Set the fields for our custom plugin page 
	$page_slug = 'wwu_call_to_action';
	$option_group = 'wwu_settings';

	// Create the section 
	add_settings_section(
		'wwu_section_id', 
		'', 
		'',
		$page_slug
	);

	// Register fields
	register_setting( $option_group, 'wwu_html_code', 'wp_kses_post' );
    register_setting( $option_group, 'wwu_tag_slug', 'sanitize_title' );

	// Add the fields
	add_settings_field(
		'wwu_html_code',
		'Codice Call to Action',
		'wwu_print_html_field',
		$page_slug,
		'wwu_section_id'
	);

    add_settings_field(
		'wwu_tag_slug',
		'Tag (slug)',
		'wwu_print_tag_input',
		$page_slug,
		'wwu_section_id'
	);
}

function wwu_print_html_field(){
    // Prints the HTML setting field 
    $value = get_option( 'wwu_html_code' );?>
    <div class="wwu-form-field">
        <textarea class="wwu-html-textarea" name="wwu_html_code"><?php echo $value;?></textarea>
        <p><em><?php echo esc_html( "È possibile scrivere qui il codice HTML della Call to Action che verrà visualizzata all'interno degli articoli." );?></em></p>
    </div>
<?php }

function wwu_print_tag_input(){
    // Prints the tag setting field 
    $value = get_option( 'wwu_tag_slug' );
    if( $value == '' ){
        $value = 'governo';
    }?>
    <div class="wwu-form-field">
        <input type="text" id="wwu_tag_slug" name="wwu_tag_slug" value="<?php echo esc_attr( $value );?>" />
        <p><em><?php echo esc_html( "La Call to Action verrà visualizzata soltanto all'interno degli articoli contenenti questo tag." );?></em></p>
    </div>
<?php }

/*
*
*
* POST CONTENT
*/

function wwu_print_cta( $content ){
    // Actually prints the call to action if a post has a certain tag 
    $tag_slug = get_option( 'wwu_tag_slug' );
    $cta_code = get_option( 'wwu_html_code' );
    $new_content = $content;

    if( is_single() && $tag_slug !== '' && has_tag( $tag_slug ) && $cta_code !== '' ){ // Check if everything matches        
        // Count paragraphs
        $p_after = 4; 
        $content = explode( "</p>", $content );
        $new_content = '';
        for( $i = 0; $i < count( $content ); $i++) {
            if( $i == $p_after ){
                // Only print the code if we're after the fourth paragraph
                $new_content .= $cta_code;
            }

            $new_content .= $content[ $i ] . "</p>";
        }
    }

    return $new_content;
}

/*
*
*
* ASSETS
*/

function wwu_assets(){
    // Enqueues assets for the plugin to work properly 
    wp_enqueue_style( 'wwu_style', WORK_WITH_US_URL . '/assets/css/style.css' );
}

/*
*
*
* ACTIONS
*/

// Action for adding the settings page 
add_action( 'admin_menu', 'wwu_settings_page' );

// Settings field
add_action( 'admin_init', 'wwu_settings_fields' );

// Content filter 
add_action( 'the_content', 'wwu_print_cta' );

// Enqueue scripts and styles 
add_action( 'admin_enqueue_scripts', 'wwu_assets' );?>