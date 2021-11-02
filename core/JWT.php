<?php

    class JWT {
        
        private $_header;
        private $_payload;
        private $_signature;
        private $_token;

        public function __construct() {
            $this->_header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];
        }

        public function getTokenForUser($user) {
            $headerEncoded = $this->_base64url_encode(json_encode($this->_header));
            $this->_payload = $user->toArray();
            $payloadEncoded = $this->_base64url_encode(json_encode($this->_payload));

            $this->_signature = hash_hmac(
                JWT_ALGORITHM,
                $headerEncoded . '.' . $payloadEncoded,
                JWT_SECRET_KEY, true
            );

            $signatureEncoded = $this->_base64url_encode($this->_signature);

            $this->_token = implode('.', [$headerEncoded, $payloadEncoded, $signatureEncoded]);
            return $this->_token;
        }

        private function _base64url_encode($data) {
            return str_replace('=', '', strtr(base64_encode($data), '+/', '-_'));
        }

        private function _base64url_decode($data, $strict = false){
            $b64 = strtr($data, '-_', '+/');
            return base64_decode($b64, $strict);
        }
    }
