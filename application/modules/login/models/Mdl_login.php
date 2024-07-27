<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Class Mdl_Sessions
 */
class Mdl_Sessions extends CI_Model
{
    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function auth($email, $password)
    {
        $this->db->where('email_id', $email);

        $query = $this->db->get('mech_user');

        if ($query->num_rows()) {
            $user = $query->row();

            $this->load->library('crypt');

            /**
             * Password hashing changed after 1.2.0
             * Check to see if user has logged in since the password change
             */
            if (!$user->user_psalt) {
                /**
                 * The user has not logged in, so we're going to attempt to
                 * update their record with the updated hash
                 */
                 
                if (md5($password) == $user->password) {
                    /**
                     * The md5 login validated - let's update this user
                     * to the new hash
                     */
                    $salt = $this->crypt->salt();
                    $hash = $this->crypt->generate_password($password, $salt);

                    $db_array = array(
                        'user_psalt' => $salt,
                        'password' => $hash
                    );

                    $this->db->where('user_id', $user->user_id);
                    $this->db->update('mech_user', $db_array);

                    $this->db->where('email_id', $email);
                    $user = $this->db->get('mech_user')->row();

                } else {
                    /**
                     * The password didn't verify against original md5
                     */
                    return false;
                }
            }

            if ($this->crypt->check_password($user->password, $password)) {
                $session_data = array(
                    'user_type' => $user->user_type,
                    'user_id' => $user->user_id,
                    'user_name' => $user->name,
                    'user_email' => $user->email_id,
                    'mobile_no' => $user->mobile_no
                    //'user_language' => isset($user->user_language) ? $user->user_language : 'system',
                );

                $this->session->set_userdata($session_data);

                return true;
            }
        }

        return false;
    }

}
