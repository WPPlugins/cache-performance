<?php
if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly
class Optimisationio_Admin
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'menu'));
        add_action('admin_enqueue_scripts', array($this, 'load_custom_wp_admin_style'));
        add_action('init', array($this, 'optimisation_cron'));
        add_filter('cron_schedules', array($this, 'add_custom_interval'));
        add_action('optimisation_purge_time_event', array($this, 'do_optimisation_purge_cron'));
        add_action('admin_init', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_optimise_db_ajx', array($this, 'updateDbOptimise'));
        add_action('wp_ajax_noprev_optimise_db_ajx', array($this, 'updateDbOptimise'));

    }

    public function enqueue_admin_scripts()
    {
        wp_enqueue_script('optimisationio_admin_js', plugins_url('../../js/optimisationio_admin_js.js', __FILE__), array(), 1.1);
        wp_localize_script('optimisationio_admin_js', 'optimisationioscript', array(
            'imageUrl' => plugins_url('../../images/facebook.gif', __FILE__),
        ));
    }

    public function menu()
    {
        add_management_page(__('Optimisation.io', 'optimise'), __('Optimisation.io - Performance Cache', 'optimise'), 'manage_options', 'optimisationio', array($this, 'caheEnabler'));

        add_submenu_page('', __('Update Cache Enabler', 'optimise'), __('Update Cache Enabler', 'optimise'), 'manage_options', 'optimisationio-cache-settings', array($this, 'updateCacheEnabler'));

        add_management_page(__('Recommended Plugins', 'optimise'), __('Recommended Plugins', 'optimise'), 'manage_options', 'optimisationio-recommended-plugins', array($this, 'recommendedPlugins'));

        add_submenu_page('', __('CDN Enabler', 'optimise'), __('CDN Enabler', 'optimise'), 'manage_options', 'optimisationio-cdn-enabler', array($this, 'cdnEnabler'));

        add_submenu_page('', __('Update CDN Enabler', 'optimise'), __('Update CDN Enabler', 'optimise'), 'manage_options', 'optimisationio-update-cdn-enabler', array($this, 'updateCdnEnabler'));

        add_submenu_page('', __('Db Optimise', 'optimise'), __('Db Optimise', 'optimise'), 'manage_options', 'optimisationio-db-optimise', array($this, 'optimiseDb'));

        // add_submenu_page('', __('Update Db Optimise', 'optimise'), __('Update Db Optimise', 'optimise'), 'manage_options', 'optimisationio-update-db-optimise', array($this, 'updateDbOptimise'));

    }

    public function add_custom_interval($schedules)
    {
        $schedules['weekly'] = array(
            'interval' => 604800,
            'display'  => __('Once Weekly'),
        );
        $schedules['daily'] = array(
            'interval' => 86499,
            'display'  => __('Once Daily'),
        );
        $schedules['monthly'] = array(
            'interval' => 2592000,
            'display'  => __('Once Daily'),
        );
        $schedules['fortnightly'] = array(
            'interval' => 1209600,
            'display'  => __('Once Fortnightly'),
        );
        return $schedules;
    }

    public function optimisation_cron()
    {
        $settings = get_option(Optimisationio::OPTION_KEY . '_dboptimisesetting', array());
        if (isset($settings['auto_optimise']) && $settings['auto_optimise'] == 1) {
            if (!wp_next_scheduled('optimisation_purge_time_event')) {
                if (isset($settings['optimise_schedule_type'])) {
                    $time = time() * (3600 * 3);
                    wp_schedule_event($time, $settings['optimise_schedule_type'], 'optimisation_purge_time_event');
                }
            }
        }
    }
    public function do_optimisation_purge_cron()
    {
        $this->optimise();
    }

    public function updateDbOptimise()
    {
        $array = array(
            'clean_draft_posts'       => ($_POST['clean_draft_posts']) ? 1 : 0,
            'clean_auto_draft_posts'  => ($_POST['clean_auto_draft_posts']) ? 1 : 0,
            'clean_trash_posts'       => ($_POST['clean_trash_posts']) ? 1 : 0,
            'clean_post_revisions'    => ($_POST['clean_post_revisions']) ? 1 : 0,
            'clean_transient_options' => ($_POST['clean_transient_options']) ? 1 : 0,
            'clean_trash_comments'    => ($_POST['clean_trash_comments']) ? 1 : 0,
            'clean_spam_comments'     => ($_POST['clean_spam_comments']) ? 1 : 0,
            'clean_post_meta'         => ($_POST['clean_post_meta']) ? 1 : 0,
            'optimise_database'       => ($_POST['optimise_database']) ? 1 : 0,
            'auto_optimise'           => ($_POST['auto_optimise']) ? 1 : 0,
            'optimise_schedule_type'  => sanitize_text_field(($_POST['optimise_schedule_type']) ? $_POST['optimise_schedule_type'] : null),
        );
        $options  = $array;
        $settings = update_option(Optimisationio::OPTION_KEY . '_dboptimisesetting', $options);

        if ($_POST['auto_optimise'] != 1) {
            $this->optimise();
            wp_clear_scheduled_hook('optimisation_purge_time_event');
            $return['msg'] = 'Database optimisation is successfull';
        } else {
            $return['msg'] = 'Database optimisation settings saved successfully';
        }
        $return['status'] = 'success';
        echo json_encode($return);
        die;
        // $this->redirectUrl(admin_url('tools.php?page=optimisationio-db-optimise'));

    }

    public function optimise()
    {
        global $wpdb;
        $db_name                 = $wpdb->prefix . 'wp_optimisation_sizes_info';
        $db_size_info_before     = $this->get_db_size_info();
        $db_size_before_optimise = $db_size_info_before['total_size'];
        $retention_enabled       = false;
        $retention_period        = 1;

        $settings = get_option(Optimisationio::OPTION_KEY . '_dboptimisesetting', array());
        if (isset($settings['clean_draft_posts']) && $settings['clean_draft_posts'] == 1) {
            $wpdb->query("Delete from $wpdb->posts where post_status='draft'");
        }
        if (isset($settings['clean_auto_draft_posts']) && $settings['clean_auto_draft_posts'] == 1) {
            $clean = "DELETE FROM $wpdb->posts WHERE post_status = 'auto-draft'";
            if ($retention_enabled == 'true') {
                $clean .= ' and post_modified < NOW() - INTERVAL ' . $retention_period . ' WEEK';
            }
            $clean .= ';';
            $autodraft = $wpdb->query($clean);
        }
        if (isset($settings['clean_trash_posts']) && $settings['clean_trash_posts'] == 1) {
            $clean = "DELETE FROM $wpdb->posts WHERE post_status = 'trash'";

            if ($retention_enabled == 'true') {

                $clean .= ' and post_modified < NOW() - INTERVAL ' . $retention_period . ' WEEK';
            }

            $clean .= ';';

            $posttrash = $wpdb->query($clean);
        }
        if (isset($settings['clean_post_revisions']) && $settings['clean_post_revisions'] == 1) {
            $clean = "DELETE FROM $wpdb->posts WHERE post_type = 'revision'";

            if ($retention_enabled == 'true') {

                $clean .= ' and post_modified < NOW() - INTERVAL ' . $retention_period . ' WEEK';
            }

            $clean .= ';';

            $revisions = $wpdb->query($clean);
        }
        if (isset($settings['clean_transient_options']) && $settings['clean_transient_options'] == 1) {
            $wpdb->query("Delete from $wpdb->options where `option_name` like ('%\_transient\_%')");
        }

        if (isset($settings['clean_trash_comments']) && $settings['clean_trash_comments'] == 1) {
            // TODO:  query trashed comments and cleanup metadata
            $clean = "DELETE FROM $wpdb->comments WHERE comment_approved = 'trash'";

            if ($retention_enabled == 'true') {

                $clean .= ' and comment_date < NOW() - INTERVAL ' . $retention_period . ' WEEK';
            }

            $clean .= ';';

            $commentstrash = $wpdb->query($clean);
        }
        if (isset($settings['clean_spam_comments']) && $settings['clean_spam_comments'] == 1) {

            $clean = "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'";

            if ($retention_enabled == 'true') {

                $clean .= ' and comment_date < NOW() - INTERVAL ' . $retention_period . ' WEEK';
            }

            $clean .= ';';

            $comments = $wpdb->query($clean);
        }
        if (isset($settings['clean_post_meta']) && $settings['clean_post_meta']) {
            $clean    = "DELETE pm FROM `" . $wpdb->postmeta . "` pm LEFT JOIN `" . $wpdb->posts . "` wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL;";
            $postmeta = $wpdb->query($clean);
        }

        $table_string = null;
        if (isset($settings['optimise_database']) && $settings['optimise_database'] == 1) {

            $query = 'SHOW TABLE STATUS';

            $tables = $wpdb->get_results($query, ARRAY_A);
            foreach ($tables as $table) {

                if (in_array($table['Engine'], array('MyISAM', 'ISAM', 'HEAP', 'MEMORY', 'ARCHIVE'))) {

                    $table_string .= $table['Name'] . ",";
                } elseif ($table['Engine'] == 'InnoDB') {

                    $optimize = $wpdb->query("ALTER TABLE {$table['Name']} ENGINE=InnoDB");
                }
            }
            if ($table_string) {
                $table_string = rtrim($table_string, ',');
                $optimize     = $wpdb->query("OPTIMIZE TABLE $table_string");
            }
        }
        $db_size_info_after     = $this->get_db_size_info();
        $db_size_after_optimise = $db_size_info_after['total_size'];

        $sql = 'INSERT INTO `' . $db_name . '` (`size`, `optimised_size`) VALUES ( ' . $db_size_before_optimise . ', ' . $db_size_after_optimise . ' );';

        $exe = $wpdb->query($sql);

    }

    private function get_db_size_info()
    {
        global $wpdb;

        $ret = array(
            'usage_row'      => 0,
            'usage_data'     => 0,
            'usage_index'    => 0,
            'usage_overhead' => 0,
            'gain_size'      => 0,
            'total_size'     => 0,
        );

        $db_status = $wpdb->get_results("SHOW TABLE STATUS");

        foreach ($db_status as $s) {

            $ret['usage_row'] += $s->Rows;
            $ret['usage_data'] += $s->Data_length;
            $ret['usage_index'] += $s->Index_length;

            if ($s->Engine != 'InnoDB') {
                $ret['usage_overhead'] += $s->Data_free;
                $ret['gain_size'] += $s->Data_free;
            }
        }

        $ret['total_size'] = $ret['usage_data'] + $ret['usage_index'];

        return $ret;
    }

    public function optimiseDb()
    {
        $settings = get_option(Optimisationio::OPTION_KEY . '_dboptimisesetting', array());

        $data = array('settings' => $settings);
        echo Optimisationio_View::render('db_optimize', $data);
    }

    public function recommendedPlugins()
    {
        echo Optimisationio_View::render('recommended_plugins');
    }

    public function load_custom_wp_admin_style($hook)
    {
        if (preg_match('/optimisationio/i', $hook)) {
            wp_enqueue_style('custom_wp_admin_css', plugins_url('css/optimisationio.css', __FILE__ . '/../../../../'));
            wp_enqueue_style('cache_admin_css', plugins_url('css/style.css', __FILE__ . '/../../../../'));
        }

    }

    public function cdnEnabler()
    {
        $settings = get_option(Optimisationio::OPTION_KEY . '_cdnsettings', array());
        $data     = array('settings' => $settings);
        echo Optimisationio_View::render('cdn_enabler', $data);
    }

    public function updateCdnEnabler()
    {

        $array = array(
            'cdn_root_url'            => sanitize_text_field($_POST['cdn_root_url']),
            'cdn_file_extensions'     => sanitize_text_field($_POST['cdn_file_extensions']),
            'cdn_css_root_url'        => sanitize_text_field($_POST['cdn_css_root_url']),
            'cdn_css_file_extensions' => sanitize_text_field($_POST['cdn_css_file_extensions']),
            'cdn_js_root_url'         => sanitize_text_field($_POST['cdn_js_root_url']),
            'cdn_js_file_extensions'  => sanitize_text_field($_POST['cdn_js_file_extensions']),
        );

        $options  = $array;
        $settings = update_option(Optimisationio::OPTION_KEY . '_cdnsettings', $options);
        $this->addMessage('CDN ReWrite Rules added');

        $this->redirectUrl(admin_url('tools.php?page=optimisationio-cdn-enabler'));

    }

    public function caheEnabler()
    {
        // wp cache check
        if (!defined('WP_CACHE') || !WP_CACHE) {
            echo sprintf(
                '<div class="notice notice-warning"><p>%s</p></div>',
                sprintf(
                    __("%s is not set in %s.", 'optimisation.io'),
                    "<code>define('WP_CACHE', true);</code>",
                    "wp-config.php"
                )
            );
        }
        $selectoptions = Optimisationio_CacheEnabler::_minify_select();
        $settings      = get_option(Optimisationio::OPTION_KEY . '_settings', array());
        $data          = array('settings' => $settings, 'selectoptions' => $selectoptions, 'cacheSize' => (Optimisationio_CacheEnabler::get_cache_size() / 1000) . ' Kb');
        echo Optimisationio_View::render('cache_enabler', $data);
    }

    public function updateCacheEnabler()
    {
        $array = array(
            'cache_expires'           => sanitize_text_field($_POST['cache_expires']),
            'cache_new_post'          => ($_POST['cache_new_post']) ? 1 : 0,
            'cache_new_comment'       => ($_POST['cache_new_comment']) ? 1 : 0,
            'cache_webp'              => ($_POST['cache_webp']) ? 1 : 0,
            'cache_compress'          => ($_POST['cache_compress']) ? 1 : 0,
            'enable_gzip_compression' => ($_POST['enable_gzip_compression']) ? 1 : 0,
            'excl_ids'                => sanitize_text_field($_POST['excl_ids']),
            'minify_html'             => sanitize_text_field($_POST['minify_html']),
        );

        $options  = $array;
        $settings = update_option(Optimisationio::OPTION_KEY . '_settings', $options);
        $this->addMessage('Cache Settings updated successfully');

        $this->redirectUrl(admin_url('tools.php?page=optimisationio'));
    }

    private function sendemail($to, $subject, $message, $from)
    {
        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        @mail($to, $subject, $message, $headers);
    }

    private function addMessage($msg, $type = 'success')
    {
        if ($type == 'success') {
            printf(
                "<div class='updated'><p><strong>%s</strong></p></div>",
                $msg
            );
        } else {
            printf(
                "<div class='error'><p><strong>%s</strong></p></div>",
                $msg
            );
        }
    }

    private function redirectUrl($url)
    {
        //header('Location:'.$url);
        echo '<script>';
        echo 'window.location.href="' . $url . '"';
        echo '</script>';
    }

}
