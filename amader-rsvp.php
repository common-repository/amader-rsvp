<?php
/*
Plugin Name: Amader RSVP
Plugin URI: https://mucasoft.com/plugins-demo/amader-rsvp-wordpress-plugin-demo/
Description: Amazing RSVP plugin for free for you. Its easy and simple to use anywhere in your website. 
Author: Mucasoft
Author URI: https://mucasoft.com/
Version: 1.0.0
License: GPL2
*/

/************************************/
/* Register styles and js files    */
/***********************************/
function amader_rsvp_load_css_js() {
    wp_enqueue_style( 'bootstrap-css', plugins_url('/css/bootstrap/bootstrap.min.css', __FILE__));
    wp_enqueue_style( 'main-css', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_style( 'fontawesome-css', plugins_url('/css/font-awesome/font-awesome.min.css', __FILE__));


    wp_enqueue_script( 'bootstrap-js', plugins_url('/js/bootstrap.min.js',__FILE__), array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'amader_rsvp_load_css_js' );



/************************************/
/* Enqueue stylesheet for admin     */
/***********************************/
function amader_rsvp_load_css_js_admin() {
    wp_enqueue_style( 'amader-rsvp-admin-css', plugins_url('/css/admin/style.css', __FILE__));
}
add_action( 'admin_enqueue_scripts', 'amader_rsvp_load_css_js_admin' );



/************************************/
/* Create db table on activation */
/************************************/
function amader_rsvp_plugin_activation() 
{
    global $wpdb;
    $table = $wpdb->prefix . "amader_rsvp";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table
    (
    id INT AUTO_INCREMENT,
    first_name varchar(20),
    last_name varchar(20),
    rsvp_phone varchar(20),
    rsvp_email varchar(50),
    rsvp_attending varchar(15),
    rsvp_kids_menus varchar(15),
    rsvp_vegetarian_menus varchar(20),
    invite_code varchar(20),
    PRIMARY KEY (id)
    )$charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__,'amader_rsvp_plugin_activation');




/************************************/
/* Create admin page for rsvp       */
/************************************/
function amader_rsvp_admin_page()
{
    global $team_page;
    add_menu_page('Amader RSVP', 'Amader RSVP', 'edit_posts', 'amader-rsvp', 'rsvp_page_handler', 'dashicons-groups', 6);
}
add_action('admin_menu', 'amader_rsvp_admin_page');




/************************************/
/* Contents for rsvp admin page     */
/************************************/
function rsvp_page_handler()
{
?>
    <br/>


    <?php
    global $wpdb;
    $dbtable = $wpdb->prefix . "amader_rsvp";
    $rsvp_datas = $wpdb->get_results("SELECT * FROM $dbtable");
    if ($rsvp_datas == true):
    ?>
<table class="table">

  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Full Name</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Email Address</th>
      <th scope="col"># Persons</th>
      <th scope="col"># Kids menus</th>
      <th scope="col"># Veg. menus</th>
      <th scope="col">Invitaton Code</th>
    </tr>
  </thead>
  <tbody>
  	<?php
        $serial = 1;
        foreach ($rsvp_datas as $rsvp_data) {
    ?>
    <tr>
      <th scope="row"><?php echo $serial;?></th>
      <td><?php echo esc_textarea($rsvp_data->first_name)." ".esc_textarea($rsvp_data->last_name); ?></td>
      <td><?php echo esc_textarea($rsvp_data->rsvp_phone)?></td>
      <td><?php echo esc_textarea($rsvp_data->rsvp_email)?></td>
      <td><?php echo esc_textarea($rsvp_data->rsvp_attending)?></td>
      <td><?php echo esc_textarea($rsvp_data->rsvp_kids_menus)?></td>
      <td><?php echo esc_textarea($rsvp_data->rsvp_vegetarian_menus)?></td>
      <td><?php echo esc_textarea($rsvp_data->invite_code)?></td>
    </tr>
    <?php $serial++; } ?>
  </tbody>
  <tfoot class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Full Name</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Email Address</th>
      <th scope="col"># Persons</th>
      <th scope="col"># Kids menus</th>
      <th scope="col"># Veg. menus</th>
      <th scope="col">Invitaton Code</th>
    </tr>
  </tfoot>
</table>
<?php
    else:echo '<p>Sorry, no RSVP found in the database. <br/> Please use <strong>[amader_rsvp]</strong> in any page to show RSVP form in your website.</p>'; endif;

}


include_once ('src/rsvp-main.php');
