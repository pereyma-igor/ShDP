<?php
/*
Plugin Name: REVE Chat - WP Live Chat Support plugin
Description: REVE Chat is a powerful and intuitive real-time customer engagement software. As a customer support software, REVE Chat puts a live person on your website to personally guide and help your visitors, while they go through the various sections of your digital display. This live chat service helps them to get the most out of your web presence, while allowing you to understand their diverse needs on a one-to-one basis. REVE Chat is easy to install and use.
Version: 6.2.0
Author: REVE Chat
Author URI: www.revechat.com
License: GPL2
*/
if(!class_exists('WP_Plugin_Revechat'))
{
/**
 * Core class which interacts with
 * WordPress hooks and filters
 */
class WP_Plugin_Revechat
{
    /**
     * Constructor method of the plugin object.
     * This method initialize the stdClass,
     * defines plugin name, plugin display name etc.
     *
     * This method also calls necessary wodpress hooks and filters.
     * for more about hooks please visit @link [https://developer.wordpress.org/reference/functions/add_action/]
     * for more information on filters @link [https://developer.wordpress.org/reference/functions/add_filter/]
     */
    public function __construct()
    {
        // Plugin Details
        $this->plugin = new stdClass;
        $this->plugin->name = 'revechat'; // Plugin Folder
        $this->plugin->displayName = 'REVE Chat'; // Plugin Name
        
        // Hooks
        add_action('admin_init', array(&$this, 'registerSettings'));
        
        add_action('wp_head', array(&$this, 'frontendHeader'));
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this,'add_action_links') );

        // Add Menu Page
        add_action('admin_menu',array($this,'admin_menu'));

        //enqueue scripts
        add_action('admin_enqueue_scripts',array($this,'admin_scripts'));

    } // END public function __construct

    /**
     * REVE Chat widget script.
     *
     * This script will be rendered in frontend of the site.
     * This funtion is called when wp_head action triggered.
     * The wp_head action hook is triggered within the <head></head> section of the user's template
     * by the wp_head() function. Although this is theme-dependent,
     * it is one of the most essential theme hooks, so it is widely supported.
     *
     */
    public static function frontendHeader()
    {
        $accountId = get_option('revechat_aid' , '');
        if( (isset($accountId) && !empty($accountId))  ) {

            $script = "<script type='text/javascript'>";
            $script .= 'window.$_REVECHAT_API || (function(d, w) { var r = $_REVECHAT_API = function(c) {r._.push(c);}; w.__revechat_account=\''.$accountId.'\';w.__revechat_version=2;
                    r._= []; var rc = d.createElement(\'script\'); rc.type = \'text/javascript\'; rc.async = true; rc.setAttribute(\'charset\', \'utf-8\');
                    rc.src = (\'https:\' == document.location.protocol ? \'https://\' : \'http://\') + \'static.revechat.com/widget/scripts/new-livechat.js?\'+new Date().getTime();
                    var s = d.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(rc, s);
                    })(document, window);';

            $script .='</script>';

            echo $script ;

        }

    } 

    /**
     * Register a setting and its data.
     * refer to @link [https://developer.wordpress.org/reference/functions/register_setting/]
     * for more information about register setting
     */
    public function registerSettings(){
        register_setting($this->plugin->name, 'revechat_aid', 'trim');
    }

    /**
     * Render the settings form
     */
    public function reveChatOptions(){
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        // variables for the field and option names
        $accountId = 'revechat_aid';

        

        
        // Read in existing option value from database
        $val_accountId = get_option( $accountId );
        
        if( isset($_POST[ $accountId ])){
            
            // Read in existing option value from POST
            $val_accountId = $_POST[ $accountId ];
            update_option( $accountId , $val_accountId );
            ?>
                <div class="updated" xmlns="http://www.w3.org/1999/html"><p><strong><?php _e('Settings saved.', 'revechat-menu' ); ?></strong></p></div>
            <?php
        }
        ?>
        <div id="revechat">

        <div class="revechat-logo">
            <img src="<?php echo plugin_dir_url( __FILE__ )."assets/images/logo.png";?>" alt="REVE Chat">
        </div>

        <?php if( isset($_GET[ 'activated' ])){ ?>
            <div class="install_success_message"><h3>REVE Chat is successfully activated</h3></div>
        <?php } ?>

        <div class="revechat_wrap">

        <?php if(isset($val_accountId) && $val_accountId != 0){ ?>
            <form id="revechat_remove_form" name="revechat_remove_form" method="post" action="" class="revechat_success_message">

                <h4>REVE Chat has been installed.</h4>
                <p>Sign in to REVE Chat Dashboard and start chatting with your customers.</p>
                <p><a href="https://dashboard.revechat.com" class="form-submit button-primary" target="_blank">Go to Dashboard</a></p>

                <div id="edit-actions" class="form-actions form-wrapper">
                    <input type="hidden" name="revechat_aid" value="0">
                   <p><small>Something went wrong? <input type="submit" style="background: transparent; border: 0; text-decoration: underline;text-transform: lowercase; font-size: 10px; cursor: pointer;" value="Disconnect" name="revechat_remove" id="edit-submit"></small></p> 
                </div>
            </form>
        <?php } else { ?>
            <div id="revechat_chooser">
                <h3>Do you already have a REVE Chat account?</h3>
                <div>
                    <input type="radio" id="newAccountInput" name="accountChooser" checked="checked" >
                    <label for="newAccountInput">No, I want to create one</label>
                </div>
                <div>
                    <input type="radio" id="existingAccountInput" name="accountChooser">
                    <label for="existingAccountInput">Yes, I already have a REVE Chat account</label>
                </div>
            </div><!-- Edit Choose Form -->

            <div class="revechat_forms">

            <div id="edit-ajax-message" class="">
                <p class="ajax_message"></p>
            </div>

            <form name="existingAccountForm" id="existingAccountForm" class="revechat_form" method="post" action="">
            
                <h3>Account Details</h3>

                <label for="edit-revechat-account-email">REVE Chat login email</label>
                <div class="form-group">
                    <input type="email" class="form-control" id="existingAccountEmail" name="existingAccountEmail" value="" placeholder="Work Email" required>
                    <i class="icon-envelope-o"></i> 
                </div>
                <input type="hidden" value="<?php echo $val_accountId; ?>" name="revechat_aid">
                <input type="button" id="existingAccountBtn" class="btn btn-primary btn-block" value="Save Changes" />
                
            </form><!-- revechat_already_have -->


            <form id="newAccountForm" class="revechat_form" method="post" action="">
                <h3>Create a New REVE Chat account</h3>

                <fieldset class="form-wrapper" id="edit-new-revechat-account">

                    <div class="form-group">
                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name">
                        <i class="icon-user"></i>
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" id="emailAddress" name="emailAddress" value="" placeholder="Work Email" required>
                        <i class="icon-envelope-o"></i> 
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <i class="icon-eye" id="eye_close" aria-hidden="true"></i> 
                        <i class="icon-eye-slash" id="eye_open" aria-hidden="true" style="display:none;"></i>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" pattern="[0-9\-\)\( ]+" id="phoneTaker" name="phoneTaker" placeholder="Phone Number" required>
                        <i class="icon-phone-handset"></i>
                    </div>
                    <div style="display: none;"><input type="hidden" id="phoneNo" name="phoneNo" value="" /></div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="companyWebsite" name="companyWebsite" placeholder="Website Address">
                        <i class="icon-link"></i>
                    </div>
                </fieldset>

                <input type="hidden" name="revechat_aid" value="0">

                <input type="button" id="new-account-submit" value="Sign Up" class="btn btn-primary btn-block">
            </form> 
            </div>

        <?php } ?>
        </div>
        </div>

        <?php 
    }

    /**
     * Add page in admin menu
     * This method takes a capability which will be used to determine whether or not a page is included in the menu.
     * this method which is hooked in to handle the output of the page also check that the user has the required
     * capability as well.
     */
    public function admin_menu()
    {
        add_menu_page(__($this->plugin->displayName.' Dashboard','revechat-settings'), __($this->plugin->displayName,'menu-revechat'), 'manage_options', 'revechatsettings', array($this , 'reveChatOptions'), plugin_dir_url( __FILE__ )."assets/images/favicon.png");
    }

    /**
     * Triggers when the user deactivate/uninstall the plugin.
     * this method simply delete all the data of this
     * plugin from database.
     */

    public static function deactivate()
    {
        delete_option('revechat_aid');
    }


    /**
     * Load necessary JavaScript and CSS library
     * in admin panel.
     */
    public function admin_scripts(){

        wp_enqueue_script( 'jquery');
        wp_enqueue_style( 'intlTelInput',plugin_dir_url( __FILE__ ).'assets/css/intlTelInput.css' );
        wp_enqueue_style( 'revechat_styles',plugin_dir_url( __FILE__ ).'assets/css/styles.css' );

        wp_enqueue_script( 'jquery-validation', plugin_dir_url( __FILE__ ) . 'assets/js/jquery-validation.js', array('jquery') );
        wp_enqueue_script( 'intlTelInput', plugin_dir_url( __FILE__ ) . 'assets/js/intlTelInput.min.js', array('jquery') );
        wp_enqueue_script( 'revechat_scripts', plugin_dir_url( __FILE__ ) . 'assets/js/scripts.js', array('jquery','jquery-validation','intlTelInput') );

    }

    /**
     * Applied to the list of links to display on the plugins page (beside the activate/deactivate links).
     *
     * @param $links
     * @return array
     */
    function add_action_links ( $links ) {
         $menu_link = array(
         '<a href="' . admin_url( 'admin.php?page=revechatsettings' ) . '">Settings</a>',
         );
        return array_merge( $links, $menu_link );
        }
}
} // END if(!class_exists('WP_Plugin_Revechat'))

/**
* Initialize the core class
*/
$revechat = new WP_Plugin_Revechat();

/**
* Register the deactivation hook.
*/
register_deactivation_hook( __FILE__, array( 'WP_Plugin_Revechat', 'deactivate' ) );

function revechat_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'admin.php?page=revechatsettings&activated=true' ) ) );
    }
}
add_action( 'activated_plugin', 'revechat_activation_redirect' );
