<?php

class AES
{
    private $key;
    private $methode;
    private $chaineOctet;

    /**
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
        $this->methode = 'aes-256-cbc';
        //generation d'une chaine d'octet a partir d'un nombre
        $this->chaineOctet = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    }
    function encrypt($mot) {
        $sSalt = substr(hash('sha256', $this->key, true), 0, 32);
        $encrypted = base64_encode(openssl_encrypt($mot, $this->methode, $sSalt, OPENSSL_RAW_DATA, $this->chaineOctet));
        return $encrypted;
    }

    function decrypt($mot) {
        $sSalt = substr(hash('sha256', $this->key, true), 0, 32);
        $decrypted = openssl_decrypt(base64_decode($mot), $this->methode, $sSalt, OPENSSL_RAW_DATA, $this->chaineOctet);
        return $decrypted;
    }


}