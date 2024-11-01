<?php
/*
Plugin Name: WP Pricing Table
Plugin URI: http://www.wppricingtable.com
Description: The easiest to use Pricing Table plugin for WordPress. Create beautiful, modern and responsive CSS3 price tables for your products or services. Quick and easy.
Version: 1.1
Author: CodeCabin
Author URI: http://www.codecabin.co.za
*/

error_reporting(E_ERROR);
global $wppt_short_code_active;
global $wppt_tblname_tables;
global $wppt_tblname_products;
global $wppt_tblname_features;
global $wppt_version;
global $wppt_p_version;
global $wppt_t;
global $wpdb;
$wppt_tblname_tables = $wpdb->prefix . "wppt_tables";
$wppt_version = "1.1";
$wppt_p_version = "1.1";
$wppt_t = "basic";

register_activation_hook( __FILE__, 'wppt_activate' );
register_deactivation_hook( __FILE__, 'wppt_deactivate' );
add_action('init', 'wppt_init');
add_action('admin_menu', 'wppt_admin_menu');
add_filter('widget_text', 'do_shortcode');

if (function_exists('wppt_register_pro_version')) {
    add_action('admin_head', 'wppt_head_pro');
} else {
    add_action('admin_head', 'wppt_head_basic');
}


function wppt_activate() {
    global $wpdb;
    global $wppt_version;
    global $wppt_tblname_tables;

    wppt_handle_db();


    $check_tables = $wpdb->get_results("SELECT * FROM $wppt_tblname_tables");
    if (!$check_tables) {
        $wpdb->insert( $wppt_tblname_tables, array(
            "table_name" => "My first table",
            "table_active" => 1,
            'table_data' => "")
        );
    }

}
function wppt_init() {
    wp_enqueue_script("jquery");
    $plugin_dir = basename(dirname(__FILE__))."/languages/";
    load_plugin_textdomain( 'wp-pricing-table', false, $plugin_dir );
}

function wppt_admin_javascript_basic() {

}


function wppt_user_javascript_basic() {
}

function wppt_action_callback_basic() {
        global $wpdb;
        $check = check_ajax_referer( 'wppt', 'security' );

        if ($check == 1) {
            /* nothing yet */
        }

	die(); // this is required to return a proper result

}

function wppt_tag_basic( $atts ) {
    global $wppt_current_table_id;
    extract( shortcode_atts( array(
        'id' => '1'
    ), $atts ) );
    $wppt_current_id = $atts['id'];
    global $wppt_short_code_active;
    $wppt_short_code_active = true;

    $wppt_data = wppt_get_table_data($wppt_current_id);
    $table_data = maybe_unserialize($wppt_data->table_data);
    $prod_cnt = 0;

    if ($table_data['wppt_product_1_enabled'] == "on") {
        $prod_cnt++;
        if ($table_data['wppt_prod_1_feature_1_details'] != "") { $feature1 = "<li>".$table_data['wppt_prod_1_feature_1_details']."</li>"; }
        if ($table_data['wppt_prod_1_feature_2_details'] != "") { $feature1 .= "<li>".$table_data['wppt_prod_1_feature_2_details']."</li>"; }
        if ($table_data['wppt_prod_1_feature_3_details'] != "") { $feature1 .= "<li>".$table_data['wppt_prod_1_feature_3_details']."</li>"; }
        if ($table_data['wppt_prod_1_feature_4_details'] != "") { $feature1 .= "<li>".$table_data['wppt_prod_1_feature_4_details']."</li>"; }
        $prod_list = "<li class=\"wppt_price_block\"><h3>".$table_data['wppt_product_1_name']."</h3><div class=\"wppt_price\"><div class=\"wppt_price_figure\"><span class=\"wppt_price_number\">".$table_data['wppt_product_1_price']."</span></div></div><ul class=\"wppt_features\">$feature1</ul><div class=\"wppt_footer\"><a href=\"".$table_data['wppt_product_1_btn_url']."\" class=\"wppt_action_button\">".$table_data['wppt_product_1_btn_text']."</a></div></li>";
    }

    if ($table_data['wppt_product_2_enabled'] == "on") {
        $prod_cnt++;
        if ($table_data['wppt_prod_2_feature_1_details'] != "") { $feature2 = "<li>".$table_data['wppt_prod_2_feature_1_details']."</li>"; }
        if ($table_data['wppt_prod_2_feature_2_details'] != "") { $feature2 .= "<li>".$table_data['wppt_prod_2_feature_2_details']."</li>"; }
        if ($table_data['wppt_prod_2_feature_3_details'] != "") { $feature2 .= "<li>".$table_data['wppt_prod_2_feature_3_details']."</li>"; }
        if ($table_data['wppt_prod_2_feature_4_details'] != "") { $feature2 .= "<li>".$table_data['wppt_prod_2_feature_4_details']."</li>"; }
        $prod_list .= "<li class=\"wppt_price_block\"><h3>".$table_data['wppt_product_2_name']."</h3><div class=\"wppt_price\"><div class=\"wppt_price_figure\"><span class=\"wppt_price_number\">".$table_data['wppt_product_2_price']."</span></div></div><ul class=\"wppt_features\">$feature2</ul><div class=\"wppt_footer\"><a href=\"".$table_data['wppt_product_2_btn_url']."\" class=\"wppt_action_button\">".$table_data['wppt_product_2_btn_text']."</a></div></li>";
    }
    if ($table_data['wppt_product_3_enabled'] == "on") {
        $prod_cnt++;
        if ($table_data['wppt_prod_3_feature_1_details'] != "") { $feature3 = "<li>".$table_data['wppt_prod_3_feature_1_details']."</li>"; }
        if ($table_data['wppt_prod_3_feature_2_details'] != "") { $feature3 .= "<li>".$table_data['wppt_prod_3_feature_2_details']."</li>"; }
        if ($table_data['wppt_prod_3_feature_3_details'] != "") { $feature3 .= "<li>".$table_data['wppt_prod_3_feature_3_details']."</li>"; }
        if ($table_data['wppt_prod_3_feature_4_details'] != "") { $feature3 .= "<li>".$table_data['wppt_prod_3_feature_4_details']."</li>"; }
        $prod_list .= "<li class=\"wppt_price_block\"><h3>".$table_data['wppt_product_3_name']."</h3><div class=\"wppt_price\"><div class=\"wppt_price_figure\"><span class=\"wppt_price_number\">".$table_data['wppt_product_3_price']."</span></div></div><ul class=\"wppt_features\">$feature3</ul><div class=\"wppt_footer\"><a href=\"".$table_data['wppt_product_3_btn_url']."\" class=\"wppt_action_button\">".$table_data['wppt_product_3_btn_text']."</a></div></li>";
    }
    $wppt_width1 = round(100/$prod_cnt);

    $ret_msg = "
            <style>
                @media only screen and (min-width : 768px){
                    .wppt_price_block {width: $wppt_width1% !important;}
                }
            </style>
            <ul class=\"wppt_pricing_table\">$prod_list</ul>

    ";
    return $ret_msg;
}


function wppt_head_basic() {
    global $wppt_tblname_tables;

    if (isset($_POST['wppt_save_table'])){
        global $wpdb;
        $table_id = esc_attr($_POST['wppt_id']);
        $table_title = esc_attr($_POST['wppt_title']);
        $serialized = maybe_serialize($_POST);
        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wppt_tblname_tables SET
                table_name = %s,
                table_data = %s
                WHERE `id` = %d
                ",

                $table_title,
                $serialized,
                $table_id
                )
        );
        echo "<div class='updated'>";
        _e("Your settings have been saved.","wp-pricing-table");
        echo "</div>";

   }

   else if (isset($_POST['wppt_save_settings'])){
        global $wpdb;

        echo "<div class='updated'>";
        _e("Your settings have been saved.","wp-pricing-table");
        echo "</div>";


   }



}

function wppt_admin_menu() {
    add_menu_page('WP Pricing Table', __('Price Tables','wp-pricing-table'), 'manage_options', 'wp-pricing-table-menu', 'wppt_menu_layout');
    add_submenu_page('wp-pricing-table-menu', 'WP Pricing Table - Settings', __('Settings','wp-pricing-table'), 'manage_options' , 'wp-pricing-table-menu-settings', 'wppt_menu_settings_layout');
}


function wppt_menu_layout() {
    if (!$_GET['action']) {

        wppt_table_page();

    } else {
        echo"<br /><div style='float:right; display:block; width:250px; height:36px; padding:6px; text-align:center; background-color: #EEE; border: 1px solid #E6DB55; margin-right:17px;'><strong>".__("Experiencing problems with the plugin?","wp-pricing-table")."</strong><br /><a href='http://www.wppricingtable.com/documentation/' title='WP Pricing Table Troubleshooting Section' target='_BLANK'>".__("See the troubleshooting manual.","wp-pricing-table")."</a></div>";


        if ($_GET['action'] == "trash" && isset($_GET['table_id'])) {

            if ($_GET['s'] == "1") {
                if (wppt_trash_table($_GET['table_id'])) {
                    echo "<script>window.location = \"".get_option('siteurl')."/wp-admin/admin.php?page=wp-pricing-table-menu\"</script>";
                } else {
                    _e("There was a problem deleting the table.");;
                }
            } else {
                $res = wppt_get_table_data($_GET['table_id']);
                echo "<h2>".__("Delete your table","wp-pricing-table")."</h2><p>".__("Are you sure you want to delete the table","wp-pricing-table")." <strong>\"".$res->table_title."?\"</strong> <br /><a href='?page=wp-pricing-table-menu&action=trash&table_id=".$_GET['table_id']."&s=1'>".__("Yes","wp-pricing-table")."</a> | <a href='?page=wp-pricing-table-menu'>".__("No","wp-pricing-table")."</a></p>";
            }


        }
        else {
            if (function_exists('wppt_register_pro_version')) {
                        wppt_pro_menu();
            } else {
                wppt_basic_menu();
            }
        }
    }

}




function wppt_menu_settings_layout() {
    if (function_exists('wppt_register_pro_version')) {
        if (function_exists('wppt_settings_page_pro')) {
            wppt_settings_page_pro();
        }
    } else {
        wppt_settings_page_basic();
    }
}


function wppt_settings_page_basic() {
    echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("WP Pricing Table Settings","wp-pricing-table")."</h2>";

    echo "
            
            <form action='' method='post' id='wppt_options'>
                <h3>".__("Pricing Table Settings")."</h3>
                        <div style=\"margin-top:20px;\" class=\"update-nag\" >
                        ".__("Get all of these advanced features with the Pro version for only <a href=\"http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=settings\">$15.99 once off</a>. Updates included free forever.","wp-pricing_table")."
                        </div>                <table class='form-table'>
                    <tr>
                         <td width='200' valign='top'>".__("General table Settings","wp-pricing-table").":</td>
                    <tr/>
                                <tr><td>Product Background </td><td><input readonly disabled type=\"text\" class=\"color\" value=\"333333\" /> <small>Only editable in the Pro version</small></td></tr>
                                <tr><td>Product Text </td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"FFFFFF\" /></td></tr>
                                <tr><td>Price Background </td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"444444\" /></td></tr>
                                <tr><td>Price Text </td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"FFFFFF\" /></td></tr>
                                <tr><td>Hover Color 1 </td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"F9B84A\" /></td></tr>
                                <tr><td>Hover Color 2 </td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"DB7224\" /></td></tr>
                                <tr><td>Features Text </td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"000000\" /></td></tr>
                                <tr><td>Features Border Bottom </td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"CCCCCC\" /></td></tr>
                                <tr><td>Features Background </td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"DEF0F4\" /></td></tr>
                                <tr><td>Footer Background </td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"DEF0F4\" /></td></tr>
                                <tr><td>Button Color 1</td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"666666\" /></td></tr>
                                <tr><td>Button Color 2</td><td><input readonly disabled  type=\"text\" class=\"color\" value=\"333333\" /></td></tr>
                        </td>
                    </tr>

                </table>


                <p class='submit'><input type='submit' name='wppt_save_settings' class='button-primary' value='".__("Save Settings","wp-pricing-table")." &raquo;' /></p>



            </form>

                            <div style=\"width:100%; text-align:center; display:block;\">
                    <p><span style=\"font-size:8em; line-height:3em;\">Take your Pricing Table from this</span></p>
                    <p><img src=\"".plugins_url('/images/basic_version.png',__FILE__)."\" />
                    <p><span style=\"font-size:8em; line-height:3em;\">to this</span></p>
                    <p><img src=\"".plugins_url('/images/pro_version.png',__FILE__)."\" />
                    <p><span style=\"font-size:9em; line-height:3em;\">For only <a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=bigmsg1'>$15.99 once off!</a> Updates free forever.</span></p>

                    <p><span style=\"font-size:9em; line-height:3em;\"><a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=bigmsg2'>Get the Pro version now</a></span></p>
                </div>
    ";

    echo "</div>";

    
}

function wppt_menu_advanced_layout() {
    if (function_exists('wppt_register_pro_version')) {
        WPPT_PRO_advanced_menu();
    }

}

function wppt_table_page() {
    if (function_exists('wppt_register_pro_version')) {
        echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("My Price Tables","wp-pricing-table")." <a href=\"admin.php?page=wp-pricing-table-menu&action=new\" class=\"add-new-h2\">".__("Add New","wp-pricing-table")."</a></h2>";
        wppt_check_versions();
        wppt_list_tables();
    } else {
        echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("My Price Tables","wp-pricing-table")."</h2>";
        echo"<p><i><a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=tablepage_1' title='".__("Pro Version","wp-pricing-table")."'>".__("Create unlimited price tables","wp-pricing-table")."</a> ".__("with the","wp-pricing-table")." <a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=tablepage_2' title='Pro Version'>".__("Pro Version","wp-pricing-table")."</a> ".__("of WP Pricing Table for only","wp-pricing-table")." <strong>$15.99!</strong></i></p>";
        wppt_list_tables();


    }
    echo "</div>";
    echo"<br /><div style='float:right;'><a href='http://www.wppricingtable.com/documentation/troubleshooting/' title='WP Pricing Table Troubleshooting Section'>".__("Problems with the plugin? See the troubleshooting manual.","wp-pricing-table")."</a></div>";
}


function wppt_list_tables() {
    global $wpdb;
    global $wppt_tblname_tables;

    if ($wppt_tblname_tables) { $table_name = $wppt_tblname_tables; } else { $table_name = $wpdb->prefix . "wppt_tables"; }


    $results = $wpdb->get_results(
        "
	SELECT *
	FROM $table_name
        WHERE `table_active` = 1
        ORDER BY `id` DESC
	"
    );
    echo "

      <table class=\"wp-list-table widefat fixed \" cellspacing=\"0\">
	<thead>
	<tr>
        <th scope='col' id='table_title' class='manage-column column-table_title sortable desc'  style=''><span>".__("Name","wp-pricing-table")."</span></th>
        </tr>
	</thead>
        <tbody id=\"the-list\" class='list:wp_list_text_link'>
";
    foreach ( $results as $result ) {
        if (function_exists('wppt_register_pro_version')) {
            $trashlink = "| <a href=\"?page=wp-pricing-table-menu&action=trash&table_id=".$result->id."\" title=\"Trash\">".__("Trash","wp-pricing-table")."</a>";
        }
        echo "<tr id=\"record_".$result->id."\">";
        echo "<td class='table_title column-table_title'><strong><big><a href=\"?page=wp-pricing-table-menu&action=edit&table_id=".$result->id."\" title=\"".__("Edit","wp-pricing-table")."\">".$result->table_name."</a></big></strong><br /><a href=\"?page=wp-pricing-table-menu&action=edit&table_id=".$result->id."\" title=\"".__("Edit","wp-pricing-table")."\">".__("Edit","wp-pricing-table")."</a> $trashlink</td>";
        echo "</tr>";


    }
    echo "</table>";
}



function wppt_check_versions() {
    $prov = get_option("WPPT_PRO");
    $wppt_pro_version = $prov['version'];
//    if (floatval($wppt_pro_version) < 4.06 || $wppt_pro_version == null) {
//        wppt_upgrade_notice();
//    }
}

function wppt_basic_menu() {
    global $wppt_tblname_tables;
    global $wpdb;
    if ($_GET['action'] == "edit" && isset($_GET['table_id'])) {
        $res = wppt_get_table_data($_GET['table_id']);
        $table_data = maybe_unserialize($res->table_data);
        if ($table_data['wppt_product_1_enabled'] == "on") { $prod_1_enabled = "checked"; }
        if ($table_data['wppt_product_1_highlighted'] == "on") { $prod_1_highlighted = "checked"; }
        if ($table_data['wppt_product_2_enabled'] == "on") { $prod_2_enabled = "checked"; }
        if ($table_data['wppt_product_2_highlighted'] == "on") { $prod_2_highlighted = "checked"; }
        if ($table_data['wppt_product_3_enabled'] == "on") { $prod_3_enabled = "checked"; }
        if ($table_data['wppt_product_3_highlighted'] == "on") { $prod_3_highlighted = "checked"; }
    }
        echo "
           <div class='wrap'>
                <h1>".__("WP Pricing Table","wp-pricing-table")."</h1>
                <div class='wide'>
                    <h2>".__("Create your Pricing Table","wp-pricing-table")."</h2>
                    <form action='' method='post' id='wppt_options'>
                    <p><strong>Shortcode:</strong> <input type='text' readonly name='wppt_shortcode' style='font-size:18px; text-align:center;' onclick=\"this.select()\" value='[wppt id=\"".$res->id."\"]' /> <small><i>".__("copy this into your post or page to display the pricing table","wp-pricing-table")."</small></i></p>
                    <p><strong>Table name:</strong> <input type='text' name='wppt_title' value='".$res->table_name."' /></p>
                    <input type=\"hidden\" name=\"wppt_id\" value=\"".$_GET['table_id']."\" />
                        <div style=\"  display:block; overflow:auto; min-height: 20px; padding: 19px; margin-bottom: 20px; background-color: #f5f5f5; border: 1px solid #e3e3e3; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); \">
                        <div style=\"display:block; width:300px; padding-right:10px; float:left;\" id=\"wppt_product_1_div\">
                            <table>
                            <tr><td></td><td><h3>Product 1</h3></td><td></td></tr>
                                <tr><td valign=\"top\">Enabled</td><td><input type=\"checkbox\" name=\"wppt_product_1_enabled\" ".$prod_1_enabled." /> ".__("Yes","wp-pricing-table")."</td></tr>
                                <tr><td valign=\"top\">Highlighted</td><td><input type=\"checkbox\" disabled readonly /> ".__("Yes","wp-pricing-table")."</td></tr>
                                <tr height=\"15\"><td></td></tr>
                                <tr><td valign=\"top\">Product Name</td><td><input type=\"text\" name=\"wppt_product_1_name\" value=\"".$table_data['wppt_product_1_name']."\"/></td></tr>
                                <tr><td valign=\"top\">Product Description</td><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td valign=\"top\">Product Price</td><td><input type=\"text\" name=\"wppt_product_1_price\" value=\"".$table_data['wppt_product_1_price']."\"/></td></tr>
                                <tr><td valign=\"top\">Button Text</td><td><input type=\"text\" name=\"wppt_product_1_btn_text\" value=\"".$table_data['wppt_product_1_btn_text']."\"/></td></tr>
                                <tr><td valign=\"top\">Button URL</td><td><input type=\"text\" name=\"wppt_product_1_btn_url\" value=\"".$table_data['wppt_product_1_btn_url']."\"/></td></tr>
                                <tr height=\"15\"><td></td></tr>
                                <tr><td valign=\"top\">Features</td><td><input type=\"text\" name=\"wppt_prod_1_feature_1_details\" value=\"".$table_data['wppt_prod_1_feature_1_details']."\"/></td></tr>
                                <tr><td></td><td><input type=\"text\" name=\"wppt_prod_1_feature_2_details\" value=\"".$table_data['wppt_prod_1_feature_2_details']."\"/></td></tr>
                                <tr><td></td><td><input type=\"text\" name=\"wppt_prod_1_feature_3_details\" value=\"".$table_data['wppt_prod_1_feature_3_details']."\"/></td></tr>
                                <tr><td></td><td><input type=\"text\" name=\"wppt_prod_1_feature_4_details\" value=\"".$table_data['wppt_prod_1_feature_4_details']."\"/></td></tr>
                                <tr><td></td><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td></td><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td></td><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td></td><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td></td><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td></td><td><input type=\"text\" readonly disabled /></td></tr>
                            </table>
                        </div>
                        <div style=\"display:block; width:200px; padding-right:10px; float:left;\" id=\"wppt_product_2_div\">
                            <table>
                                <tr><td><h3>Product 2</h3></td></tr>
                                <tr><td><input type=\"checkbox\" name=\"wppt_product_2_enabled\" ".$prod_2_enabled." /> ".__("Yes","wp-pricing-table")."</td></tr>
                                <tr><td><input type=\"checkbox\" disabled readonly /> ".__("Yes","wp-pricing-table")."</td></tr>
                                <tr height=\"15\"><td></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_product_2_name\" value=\"".$table_data['wppt_product_2_name']."\" /></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_product_2_price\" value=\"".$table_data['wppt_product_2_price']."\"/></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_product_2_btn_text\" value=\"".$table_data['wppt_product_2_btn_text']."\"/></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_product_2_btn_url\" value=\"".$table_data['wppt_product_2_btn_url']."\"/></td></tr>
                                <tr height=\"15\"><td></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_prod_2_feature_1_details\" value=\"".$table_data['wppt_prod_2_feature_1_details']."\"/></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_prod_2_feature_2_details\" value=\"".$table_data['wppt_prod_2_feature_2_details']."\"/></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_prod_2_feature_3_details\" value=\"".$table_data['wppt_prod_2_feature_3_details']."\"/></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_prod_2_feature_4_details\" value=\"".$table_data['wppt_prod_2_feature_4_details']."\"/></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td></tr>
                            </table>
                        </div>
                        <div style=\"display:block; width:430px; padding-right:10px; float:left;\" id=\"wppt_product_3_div\">
                            <table>
                                <tr><td><h3>Product 3</h3></td><td><input type='button' class='button-primary' value='".__("+ Product","wp-pricing-table")."' /> <small>Add more columns with the <a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=morecolumns'>Pro version</a>.</small></td></tr>
                                <tr><td><input type=\"checkbox\" name=\"wppt_product_3_enabled\" ".$prod_3_enabled." /> ".__("Yes","wp-pricing-table")."</td><td></td></tr>
                                <tr><td><input type=\"checkbox\" disabled readonly /> ".__("Yes","wp-pricing-table")."</td><td><small>Add highlighted columns with the <a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=highlighted'>Pro version</a>.</small></td></tr>
                                <tr height=\"15\"><td></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_product_3_name\" value=\"".$table_data['wppt_product_3_name']."\" /></td><td></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td><td><small>Add product descriptions with the <a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=description'>Pro version</a>.</small></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_product_3_price\" value=\"".$table_data['wppt_product_3_price']."\"/></td><td></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_product_3_btn_text\" value=\"".$table_data['wppt_product_3_btn_text']."\"/></td><td></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_product_3_btn_url\" value=\"".$table_data['wppt_product_3_btn_url']."\"/></td><td></td></tr>
                                <tr height=\"15\"><td></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_prod_3_feature_1_details\" value=\"".$table_data['wppt_prod_3_feature_1_details']."\"/></td><td></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_prod_3_feature_2_details\" value=\"".$table_data['wppt_prod_3_feature_2_details']."\"/></td><td></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_prod_3_feature_3_details\" value=\"".$table_data['wppt_prod_3_feature_3_details']."\"/></td><td></td></tr>
                                <tr><td><input type=\"text\" name=\"wppt_prod_3_feature_4_details\" value=\"".$table_data['wppt_prod_3_feature_4_details']."\"/></td><td></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td><td><small>Add more features with the <a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=morefeatures'>Pro version</a> for only $15.99.</small></td></tr>
                                <tr><td><input type=\"text\" readonly disabled /></td></tr><tr><td><input type=\"text\" readonly disabled /></td></tr><tr><td><input type=\"text\" readonly disabled /></td></tr><tr><td><input type=\"text\" readonly disabled /></td></tr><tr><td><input type=\"text\" readonly disabled /></td></tr>
                            </table>
                        </div>
                    <p class='submit' style=\"clear:both;\"><input type='submit' name='wppt_save_table' class='button-primary' value='".__("Save Table","wp-pricing-table")." &raquo;' /></p>
                    </form>
                </div>
                <div style=\"width:100%; text-align:center; display:block;\">
                    <p><span style=\"font-size:8em; line-height:3em;\">Take your Pricing Table from this</span></p>
                    <p><img src=\"".plugins_url('/images/basic_version.png',__FILE__)."\" />
                    <p><span style=\"font-size:8em; line-height:3em;\">to this</span></p>
                    <p><img src=\"".plugins_url('/images/pro_version.png',__FILE__)."\" />
                    <p><span style=\"font-size:9em; line-height:3em;\">For only <a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=bigmsg1'>$15.99 once off!</a> Updates free forever.</span></p>
                    <p><span style=\"font-size:9em; line-height:3em;\"><a href='http://www.wppricingtable.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=bigmsg2'>Get the Pro version now</a></span></p>
                </div>
            </div>
        ";
}
function wppt_admin_scripts() {
    if ($_GET['page'] == "wp-pricing-table-menu-settings") {
        wp_register_script('my-wppt-color', plugins_url('js/jscolor.js',__FILE__), false, '1.4.1', false);
        wp_enqueue_script('my-wppt-color');
    }
}
function wppt_user_styles_basic() {
    wp_register_style( 'wppt-style', plugins_url('css/wppt_style.css', __FILE__) );
    wp_enqueue_style( 'wppt-style' );

}
function wppt_admin_styles() {

}

if (isset($_GET['page']) && $_GET['page'] == 'wp-pricing-table-menu-settings') {
    add_action('admin_print_scripts', 'wppt_admin_scripts');
    add_action('admin_print_styles', 'wppt_admin_styles');
}

if (function_exists('wppt_register_pro_version')) {
    add_action('wp_print_styles', 'wppt_user_styles_pro');
} else {
    add_action('wp_print_styles', 'wppt_user_styles_basic');
}

if (function_exists('wppt_register_pro_version')) {
    add_action('template_redirect','wppt_check_shortcode');
    add_action('wp_footer', 'wppt_user_javascript_pro');
    add_action('admin_head', 'wppt_admin_javascript_pro');
    add_shortcode( 'wppt', 'wppt_tag_pro' );
} else {
    add_action('admin_head', 'wppt_admin_javascript_basic');
    add_action('template_redirect','wppt_check_shortcode');
    add_action('wp_footer', 'wppt_user_javascript_basic');
    add_shortcode( 'wppt', 'wppt_tag_basic' );
}


function wppt_check_shortcode() {
    global $posts;
    global $short_code_active;
    $short_code_active = false;
      $pattern = get_shortcode_regex();

      foreach ($posts as $wpgmpost) {
          preg_match_all('/'.$pattern.'/s', $wpgmpost->post_content, $matches);
          foreach ($matches as $match) {
            if (is_array($match)) {
                foreach($match as $key => $val) {
                    $pos = strpos($val, "wppt");
                    if ($pos === false) { } else { $short_code_active = true; }
                }
            }
          }
      }
}

// handle database check upon upgrade
function wppt_update_db_check() {
    global $wppt_version;
    if (get_option('wppt_db_version') != $wppt_version) {
        wppt_handle_db();
    }

}


add_action('plugins_loaded', 'wppt_update_db_check');

function wppt_handle_db() {
   global $wpdb;
   global $wppt_version;
   global $wppt_tblname_tables;

    
   
    $sql = "
        CREATE TABLE `".$wppt_tblname_tables."` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `table_name` varchar(700) NOT NULL,
          `table_active` int(11) NOT NULL,
          `table_data` LONGTEXT NOT NULL,

          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);


   add_option("wppt_db_version", $wppt_version);
   update_option("wppt_db_version",$wppt_version);
}

function wppt_get_table_data($table_id) {
    global $wpdb;
    global $wppt_tblname_tables;

    $result = $wpdb->get_results("
        SELECT *
        FROM $wppt_tblname_tables
        WHERE `id` = '".$table_id."' LIMIT 1
    ");
    
    $res = $result[0];

    return $result[0];

}
function wppt_trash_table($table_id) {
    global $wpdb;
    global $wppt_tblname_tables;
    if (isset($table_id)) {
        $rows_affected = $wpdb->query( $wpdb->prepare( "UPDATE $wppt_tblname_tables SET table_active = %d WHERE id = %d", 0, $table_id) );
        return true;
    } else {
        return false;
    }


}
