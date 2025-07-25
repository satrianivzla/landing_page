<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create_database($db_data) {
        $this->load->dbforge();
        if ($this->dbforge->create_database($db_data['database'])) {
            return true;
        }
        return false;
    }

    public function create_tables($db_data) {
        // Connect to the new database
        $this->load->database($db_data);

        // Create users table
        $this->db->query("
            CREATE TABLE `users` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `ip_address` varchar(45) NOT NULL,
              `username` varchar(100) NULL,
              `password` varchar(255) NOT NULL,
              `email` varchar(254) NOT NULL,
              `activation_selector` varchar(255) DEFAULT NULL,
              `activation_code` varchar(255) DEFAULT NULL,
              `forgotten_password_selector` varchar(255) DEFAULT NULL,
              `forgotten_password_code` varchar(255) DEFAULT NULL,
              `forgotten_password_time` int(11) unsigned DEFAULT NULL,
              `remember_selector` varchar(255) DEFAULT NULL,
              `remember_code` varchar(255) DEFAULT NULL,
              `created_on` int(11) unsigned NOT NULL,
              `last_login` int(11) unsigned DEFAULT NULL,
              `active` tinyint(1) unsigned DEFAULT NULL,
              `first_name` varchar(50) DEFAULT NULL,
              `last_name` varchar(50) DEFAULT NULL,
              `company` varchar(100) DEFAULT NULL,
              `phone` varchar(20) DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `uc_email` (`email`),
              UNIQUE KEY `uc_username` (`username`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Create groups table
        $this->db->query("
            CREATE TABLE `groups` (
              `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(20) NOT NULL,
              `description` varchar(100) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Create users_groups table
        $this->db->query("
            CREATE TABLE `users_groups` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(11) unsigned NOT NULL,
              `group_id` mediumint(8) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `fk_users_groups_users1_idx` (`user_id`),
              KEY `fk_users_groups_groups1_idx` (`group_id`),
              CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
              CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Create login_attempts table
        $this->db->query("
            CREATE TABLE `login_attempts` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `ip_address` varchar(45) NOT NULL,
              `login` varchar(100) NOT NULL,
              `time` int(11) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Create settings table
        $this->db->query("
            CREATE TABLE `settings` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `logo` varchar(255) NOT NULL,
              `favicon` varchar(255) NOT NULL,
              `site_title` varchar(255) NOT NULL,
              `meta_description` text NOT NULL,
              `meta_keywords` text NOT NULL,
              `countdown_date` varchar(255) NOT NULL,
              `show_about` tinyint(1) NOT NULL DEFAULT '1',
              `show_services` tinyint(1) NOT NULL DEFAULT '1',
              `show_gallery` tinyint(1) NOT NULL DEFAULT '1',
              `show_contact` tinyint(1) NOT NULL DEFAULT '1',
              `about_us_content` text NOT NULL,
              `services_content` text NOT NULL,
              `contact_content` text NOT NULL,
              `privacy_policy` text NOT NULL,
              `terms_of_use` text NOT NULL,
              `cookie_policy` text NOT NULL,
              `account_whatsapp` varchar(255) DEFAULT NULL,
              `account_instagram` varchar(255) DEFAULT NULL,
              `account_tiktok` varchar(255) DEFAULT NULL,
              `account_facebook` varchar(255) DEFAULT NULL,
              `account_twitter` varchar(255) DEFAULT NULL,
              `account_linkedin` varchar(255) DEFAULT NULL,
              `contact_address` varchar(255) DEFAULT NULL,
              `contact_phone` varchar(255) DEFAULT NULL,
              `contact_email` varchar(255) DEFAULT NULL,
              `opening_days` varchar(255) DEFAULT NULL,
              `opening_hours` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Create gallery table
        $this->db->query("
            CREATE TABLE `gallery` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL,
              `category_id` int(11) NOT NULL,
              `image` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Create gallery_categories table
        $this->db->query("
            CREATE TABLE `gallery_categories` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Create visitors table
        $this->db->query("
            CREATE TABLE `visitors` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `ip_address` varchar(45) NOT NULL,
              `user_agent` text NOT NULL,
              `page_url` text NOT NULL,
              `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Create banned_ips table
        $this->db->query("
            CREATE TABLE `banned_ips` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `ip_address` varchar(45) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Create audit_trail table
        $this->db->query("
            CREATE TABLE `audit_trail` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) unsigned NOT NULL,
              `action` varchar(255) NOT NULL,
              `table_name` varchar(255) NOT NULL,
              `record_id` int(11) NOT NULL,
              `old_values` text,
              `new_values` text,
              `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Insert default data
        $this->db->query("
            INSERT INTO `groups` (`id`, `name`, `description`) VALUES
            (1, 'admin', 'Administrator'),
            (2, 'members', 'General User');
        ");
        $this->db->query("
            INSERT INTO `settings` (`id`, `logo`, `favicon`, `site_title`, `meta_description`, `meta_keywords`, `countdown_date`, `show_about`, `show_services`, `show_gallery`, `show_contact`, `about_us_content`, `services_content`, `contact_content`, `privacy_policy`, `terms_of_use`, `cookie_policy`, `account_whatsapp`, `account_instagram`, `account_tiktok`, `account_facebook`, `account_twitter`, `account_linkedin`, `contact_address`, `contact_phone`, `contact_email`, `opening_days`, `opening_hours`) VALUES
            (1, 'logo.png', 'favicon.ico', 'Coming Soon', 'Meta Description', 'Meta Keywords', '2025-12-31', 1, 1, 1, 1, 'About Us', 'Services', 'Contact', 'Privacy Policy', 'Terms of Use', 'Cookie Policy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
        ");

        return true;
    }

    public function create_admin($db_data, $admin_data) {
        $this->load->database($db_data);
        $this->load->library('ion_auth');
        $username = $admin_data['username'];
        $password = $admin_data['password'];
        $email = $admin_data['email'];
        $group = array('1'); // Set user to admin group
        $this->ion_auth->register($username, $password, $email, [], $group);
        return true;
    }

    public function finalize_installation($db_data) {
        // Write database config
        $db_config_path = APPPATH . 'config/database.php';
        $db_config_content = file_get_contents($db_config_path);
        $db_config_content = str_replace(
            "'hostname' => 'localhost'",
            "'hostname' => '" . $db_data['hostname'] . "'",
            $db_config_content
        );
        $db_config_content = str_replace(
            "'username' => 'root'",
            "'username' => '" . $db_data['username'] . "'",
            $db_config_content
        );
        $db_config_content = str_replace(
            "'password' => ''",
            "'password' => '" . $db_data['password'] . "'",
            $db_config_content
        );
        $db_config_content = str_replace(
            "'database' => 'codeigniter'",
            "'database' => '" . $db_data['database'] . "'",
            $db_config_content
        );
        file_put_contents($db_config_path, $db_config_content);

        // Set installation as complete
        $config_path = APPPATH . 'config/config.php';
        $config_content = file_get_contents($config_path);
        $config_content = str_replace(
            "\$config['installation_complete'] = FALSE;",
            "\$config['installation_complete'] = TRUE;",
            $config_content
        );
        file_put_contents($config_path, $config_content);
    }
}
