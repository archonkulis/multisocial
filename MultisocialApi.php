<?php

/**
 * Multisocialapp.com API library for PHP
 *
 * version 0.0.1
 */
class MultisocialApi {

    /**
     * @var $publicKey - api public key
     */
    private $publicKey;

    /**
     * @var $privateKey - api private key
     */
    private $privateKey;

    /**
     * @var $secretKey - api secret key
     */
    private $secretKey;

    /**
     * Multisocialapp.com API URL to fetch user data
     */
    const API_URL = 'http://multisocialapp.com/api/v1/data?';

    /**
     * @param $publicKey
     * @param $privateKey
     * @param $secretKey
     */
    public function __construct($publicKey, $privateKey, $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->secretKey = $secretKey;
    }

    /**
     * Get user data from Multisocial server ( or from session if user logged in )
     *
     * @return bool|mixed
     */
    public function getUserData()
    {
        if (isset($_SESSION['social_user'])) {
            return $_SESSION['social_user'];
        }
        if (isset($_POST['user_token']) && isset($_POST['secret'])) {
            // Is POST really from Multisocial?
            if (!$this->isMultisocial($_POST['secret'])) {
                exit('Something went wrong. Please double check your public/private/secret keys.'); // hacker?
            }

            // Get user data that just logged in
            $data = $this->apiRequest($_POST['user_token']);

            // If data fetched succesfully
            if (key($data['message']) === 'success') {
                $_SESSION['social_user'] = $data;
            } else { // If not, return error message
                return $data['message'];
            }
            return $data;
        }
        return false;
    }

    /**
     * Api request to get user data
     *
     * @param $userToken
     * @return mixed
     */
    public function apiRequest($userToken)
    {
        $queryString = 'user_token=' . $userToken . '&api_key=' . $this->publicKey;
        $hash = hash('sha256', $queryString . $this->privateKey);

        if (function_exists('curl_init')) { // If curl is enabled
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::API_URL . $queryString . '&hash=' . $hash);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Retrieve data and decode it from json
            $data = json_decode(curl_exec($ch), true);

            curl_close($ch);

            return $data;
        } else if (ini_get('allow_url_fopen')) { // If file_get_contents() is enabled
            return json_decode(file_get_contents(self::API_URL . $queryString . '&hash=' . $hash), true);
        }
    }

    public function isMultisocial($secret)
    {
        $hash = hash('sha256', $this->secretKey . $this->publicKey . $this->privateKey);

        // If hashes match
        if (strcmp($secret, $hash) === 0) {
            return true;
        }

        return false;
    }
}