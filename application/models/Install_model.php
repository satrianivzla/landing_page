<?php

class Install_model extends CI_Model {

    public function check_server_requirements()
    {
        $requirements = array(
            'php_version' => version_compare(phpversion(), '5.6', '>='),
            'mysqli_extension' => extension_loaded('mysqli')
        );
        return $requirements;
    }

    public function validate_database_credentials($hostname, $username, $password, $database)
    {
        $config['hostname'] = $hostname;
        $config['username'] = $username;
        $config['password'] = $password;
        $config['database'] = $database;
        $config['dbdriver'] = 'mysqli';
        $config['dbprefix'] = '';
        $config['pconnect'] = FALSE;
        $config['db_debug'] = FALSE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';

        $this->load->database($config);

        if ($this->db->conn_id)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function run_migrations()
    {
        $this->load->library('migration');
        if ($this->migration->latest() === FALSE)
        {
            return $this->migration->error_string();
        }
        else
        {
            return TRUE;
        }
    }

    public function save_site_info($site_title, $logo)
    {
        //save to database
        $this->db->where('id', 1);
        $this->db->update('settings', array('logo' => $logo, 'site_title' => $site_title));
    }

    public function checkRemoteFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        if($result !== FALSE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
