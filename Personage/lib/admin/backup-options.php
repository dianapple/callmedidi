<?php
class pixflow_backup_restore_theme_options {

    function pixflow_backup_restore_theme_options() {
        add_action('admin_menu', array(&$this, 'admin_menu'));
    }

    function admin_menu() {

        // add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
        // $page = add_submenu_page('themes.php', 'Backup Options', 'Backup Options', 'manage_options', 'backup-options', array(&$this, 'options_page'));
        // add_theme_page($page_title, $menu_title, $capability, $menu_slug, $function);
        $page = add_theme_page('Backup Options', 'Backup Options', 'manage_options', 'backup-options', array(&$this, 'options_page'));

        add_action("load-{$page}", array(&$this, 'import_export'));
    }

    function import_export() {
        $option_name = OPTIONS_KEY;

        if (isset($_GET['action']) && ($_GET['action'] == 'download')) {
            header("Cache-Control: public, must-revalidate");
            header("Pragma: hack");
            header("Content-Type: text/plain");
            header('Content-Disposition: attachment; filename="'.$option_name.'-options-'.date("dMy").'.dat"');
            echo serialize($this->_get_options());
            die();
        }

        if (isset($_POST['upload']) && check_admin_referer('shapeSpace_restoreOptions', 'shapeSpace_restoreOptions')) {

            if ($_FILES["file"]["error"] > 0) {
                // error
            } else {
                $options = unserialize(file_get_contents($_FILES["file"]["tmp_name"]));
                if ($options) {
                    foreach ($options as $option) {
                        update_option($option->option_name, unserialize($option->option_value));
                    }
                }
            }
            wp_redirect(admin_url('themes.php?page=backup-options'));
            exit;
        }
    }

    function options_page() { ?>

        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Export/Import Theme Settings</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <style>#backup-options td { display: block; margin-bottom: 20px; }</style>
                <table id="backup-options">
                    <tr>
                        <td>
                            <h3>Export</h3>
                            <p>Use this option to make a backup of theme settings, you can import this file to another website which uses Personage theme.</p>
                            <p><textarea style="display: none;" class="widefat code hidden" rows="20″ cols="100″ onclick="this.select()"><?php echo serialize($this->_get_options()); ?></textarea></p>
                            <p><a href="?page=backup-options&action=download" class="button-secondary">Download as file</a></p>
                        </td>
                        <td>
                            <h3>Import</h3>
                            <p><label class="description" for="upload">Import the backup file which was created using personage export tool. It will overwrite all theme settings.</label></p>
                            <p><input type="file" name="file" /> <input type="submit" name="upload" id="upload" class="button-primary" value="Upload file" /></p>
                            <?php if (function_exists('wp_nonce_field')) wp_nonce_field('shapeSpace_restoreOptions', 'shapeSpace_restoreOptions'); ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    <?php }

    function _display_options() {
        $options = unserialize($this->_get_options());
    }

    function _get_options() {
        /*$options = get_option( OPTIONS_KEY );
        $options['front_page_type'] = get_option('show_on_front');
        $options['front_page_static_page'] = get_option('page_on_front');
        $options['front_page_posts_page'] = get_option('page_for_posts');
        update_option(OPTIONS_KEY, $options);*/
        global $wpdb;
        $ocwsqt_option_name = OPTIONS_KEY;
        return $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name = '". $ocwsqt_option_name ."'");
    }
}

new pixflow_backup_restore_theme_options();