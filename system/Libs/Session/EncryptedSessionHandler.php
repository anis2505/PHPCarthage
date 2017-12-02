<?php
namespace System\Libs\Session;


class EncryptedSessionHandler extends SessionHandler
{
    private $key;
	private $encryptionAlgorithm;
	
	
    public function __construct($key, $encryptionAlgorithm)
    {
        $this->key = $key;
        $this->encryptionAlgorithm = $encryptionAlgorithm;
        //echo $this->encryptionAlgorithm;
    }

    public function read($id)
    {
        $data = parent::read($id);
        $iv = \openssl_random_pseudo_bytes(\openssl_cipher_iv_length($this->encryptionAlgorithm));
        return \openssl_encrypt($data, $this->encryptionAlgorithm, $this->key, 0, $iv);

    }

    public function write($id, $data)
    {
        $iv = \openssl_random_pseudo_bytes(\openssl_cipher_iv_length($this->encryptionAlgorithm));
        $data = \openssl_decrypt($data, $this->encryptionAlgorithm, $this->key, 0, $iv);

        return parent::write($id, $data);
    }
}