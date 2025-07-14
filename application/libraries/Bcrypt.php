<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bcrypt Class
 *
 * @package       CodeIgniter
 * @subpackage    Libraries
 * @category      Cryptography
 * @author        Jim Myhrberg <contact@jimeh.me>
 * @license       http://unlicense.org/
 * @link          https://github.com/jimeh/codeigniter-bcrypt
 */
class Bcrypt {

    /**
     * The expense of the hash.
     *
     * @var integer
     */
    private $_cost = 10;

    /**
     * The algorithm to use for hashing.
     *
     * @var string
     */
    private $_algo = '2y';

    /**
     * The salt to use for hashing.
     *
     * @var string
     */
    private $_salt;

    /**
     * Constructor
     *
     * @param array $params
     */
    public function __construct($params = array())
    {
        if (isset($params['cost']))
        {
            $this->_cost = (int) $params['cost'];
        }

        if (isset($params['algo']))
        {
            $this->_algo = (string) $params['algo'];
        }
    }

    /**
     * Hash a password
     *
     * @param  string $password The password to hash
     * @param  string $salt     The salt to use
     *
     * @return string The hashed password
     */
    public function hash($password, $salt = NULL)
    {
        if ($salt === NULL)
        {
            $salt = $this->_generate_salt();
        }

        $hash = crypt($password, $this->_get_salt_string($salt));

        if (strlen($hash) < 13)
        {
            return FALSE;
        }

        return $hash;
    }

    /**
     * Compare a password to a hash
     *
     * @param  string $password The password to compare
     * @param  string $hash     The hash to compare
     *
     * @return boolean Whether the password matches the hash
     */
    public function compare($password, $hash)
    {
        return ($hash === $this->hash($password, $this->_get_salt_from_hash($hash)));
    }

    /**
     * Get the salt from a hash
     *
     * @param  string $hash The hash
     *
     * @return string The salt
     */
    private function _get_salt_from_hash($hash)
    {
        return substr($hash, 0, 29);
    }

    /**
     * Generate a salt
     *
     * @return string The salt
     */
    private function _generate_salt()
    {
        if (function_exists('openssl_random_pseudo_bytes'))
        {
            $salt = openssl_random_pseudo_bytes(22);
        }
        else if (function_exists('mcrypt_create_iv'))
        {
            $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
        }
        else
        {
            $salt = '';
            for ($i = 0; $i < 22; $i++)
            {
                $salt .= substr('./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', mt_rand(0, 63), 1);
            }
        }

        return $salt;
    }

    /**
     * Get the salt string for crypt()
     *
     * @param  string $salt The salt
     *
     * @return string The salt string
     */
    private function _get_salt_string($salt)
    {
        return '$' . $this->_algo . '$' . str_pad($this->_cost, 2, '0', STR_PAD_LEFT) . '$' . $salt;
    }
}
