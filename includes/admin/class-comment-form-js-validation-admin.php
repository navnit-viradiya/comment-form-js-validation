<?php
class CommentFormJsValidationSetting
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'nv_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'nv_page_init' ) );
    }

    /**
     * Add options page
     */
    public function nv_add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Comment form js validation Settings', 
            'Comment form js validation', 
            'manage_options', 
            'comment-form-jv-setting', 
            array( $this, 'nv_create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function nv_create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'nv_comment_form_jv' );
        ?>
        <div class="wrap">
            <h1>Comment form js validation Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'nv_comment_form_jv_group_1' );
                do_settings_sections( 'comment-form-jv-setting' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function nv_page_init()
    {        
        register_setting(
            'nv_comment_form_jv_group_1', // Option group
            'nv_comment_form_jv', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'nv_comment_form_jv_section_id', // ID
            'Custom Validation Message', // Title
            array( $this, 'nv_print_section_info' ), // Callback
            'comment-form-jv-setting' // Page
        );  

        add_settings_field(
            'comment_validation_msg', // ID
            'Comment', // Title 
            array( $this, 'comment_comment_callback' ), // Callback
            'comment-form-jv-setting', // Page
            'nv_comment_form_jv_section_id' // Section           
        );      

        add_settings_field(
            'name_validation_msg', 
            'Name', 
            array( $this, 'comment_name_callback' ), 
            'comment-form-jv-setting', 
            'nv_comment_form_jv_section_id'
        );

        add_settings_field(
            'email_validation_msg', 
            'Email', 
            array( $this, 'comment_email_callback' ), 
            'comment-form-jv-setting', 
            'nv_comment_form_jv_section_id'
        ); 

        /*add_settings_field(
            'website_validation_msg', 
            'Webite', 
            array( $this, 'comment_website_callback' ), 
            'comment-form-jv-setting', 
            'nv_comment_form_jv_section_id'
        );*/      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['comment_comment_msg'] ) )
            $new_input['comment_comment_msg'] = sanitize_text_field( $input['comment_comment_msg'] );

        if( isset( $input['comment_name_msg'] ) )
            $new_input['comment_name_msg'] = sanitize_text_field( $input['comment_name_msg'] );

        if( isset( $input['comment_email_msg'] ) )
            $new_input['comment_email_msg'] = sanitize_text_field( $input['comment_email_msg'] );

        /*if( isset( $input['comment_website_msg'] ) )
            $new_input['comment_website_msg'] = sanitize_text_field( $input['comment_website_msg'] );*/

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function nv_print_section_info()
    {
        print 'Enter the message, if you want set your own validation message.';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function comment_comment_callback()
    {
        printf(
            '<input type="text" class="regular-text" id="comment_comment_msg" name="nv_comment_form_jv[comment_comment_msg]" value="%s" />',
            isset( $this->options['comment_comment_msg'] ) ? esc_attr( $this->options['comment_comment_msg']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function comment_name_callback()
    {
        printf(
            '<input type="text" class="regular-text" id="comment_name_msg" name="nv_comment_form_jv[comment_name_msg]" value="%s" />',
            isset( $this->options['comment_name_msg'] ) ? esc_attr( $this->options['comment_name_msg']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function comment_email_callback()
    {
        printf(
            '<input type="text" class="regular-text" id="comment_email_msg" name="nv_comment_form_jv[comment_email_msg]" value="%s" />',
            isset( $this->options['comment_email_msg'] ) ? esc_attr( $this->options['comment_email_msg']) : ''
        );
    }


    /** 
     * Get the settings option array and print one of its values
     */
    /*public function comment_website_callback()
    {
        printf(
            '<input type="text" class="regular-text" id="comment_website_msg" name="nv_comment_form_jv[comment_website_msg]" value="%s" />',
            isset( $this->options['comment_website_msg'] ) ? esc_attr( $this->options['comment_website_msg']) : ''
        );
    }*/
}

$CommentFormJsValidationSettingObj = new CommentFormJsValidationSetting();
?>