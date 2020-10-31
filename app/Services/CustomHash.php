<?php

namespace App\Services;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\DB;
use MikeMcLin\WpPassword\Facades\WpPassword;


class CustomHash extends BcryptHasher implements Hasher
{
    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function check($value, $hashedValue, $options = array())
    {
        if ($this->needsRehash($hashedValue)) {
            if ($this->user_check_password($value, $hashedValue)) {

                $newHashedValue = $this->make($value, $options);
                DB::table('users')->where('password', $hashedValue)->update([
                    'password' => $newHashedValue
                ]);
                $hashedValue = $newHashedValue;
            }
        }

        return parent::check($value, $hashedValue, $options = array());
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = array())
    {
        return substr($hashedValue, 0, 4) != '$2y';
    }

    // WP PASSWORD FUNCTIONS
    function user_check_password($password, $stored_hash)
    {
        if (WpPassword::check($password, $stored_hash)) {
            info('password: ' . $password . ' stored_hash: ' . $stored_hash);
            return true;
        } else {
            return false;
        }
    }
}
