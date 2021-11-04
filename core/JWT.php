<?php

    class JWT {
        
        private $_algotithms = [
            'HS256' => ['hash_hmac', 'SHA256'],
            'HS512' => ['hash_hmac', 'SHA512'],
        ];

        private $_header;
        private $_payload;
        private $_signature;
        private $_token;

        public function __construct() {
            $this->_header = [
                'typ' => 'JWT',
                'alg' => JWT_ALGORITHM
            ];
        }

        public function getTokenForUser($user) {
            $this->_payload = $user->toArray();
            $this->_encodeToken();
            return $this->_token;
        }

        private function _encodeToken() {
            $headerEncoded = $this->_base64url_encode(json_encode($this->_header));
            $payloadEncoded = $this->_base64url_encode(json_encode($this->_payload));

            $this->_generateSignature($headerEncoded, $payloadEncoded);
            $signatureEncoded = $this->_base64url_encode($this->_signature);

            $this->_token = implode('.', [$headerEncoded, $payloadEncoded, $signatureEncoded]);
        }

        private function _base64url_encode($data) {
            return str_replace('=', '', strtr(base64_encode($data), '+/', '-_'));
        }

        private function _generateSignature($headerEncoded, $payloadEncoded) {
            $function = $this->_algotithms[JWT_ALGORITHM][0];
            $algorithm = $this->_algotithms[JWT_ALGORITHM][1];

            $this->_signature = $function($algorithm, $headerEncoded . '.' . $payloadEncoded, JWT_SECRET_KEY, true);
        }

        private function _decodeToken() {

        }

        private function _base64url_decode($data, $strict = false){
            $b64 = strtr($data, '-_', '+/');
            return base64_decode($b64, $strict);
        }
    }
