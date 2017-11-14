<?php
/**
 * Phanbook : Delightfully simple forum software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
namespace Phanbook\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phanbook\Tools\ZFunction;

class UsersMigrate extends ModelBase
{
    
    public function migreateUsers()
    {

        $UsersMigrate = UsersMigrate::find();
        foreach ($UsersMigrate as $key => $u) {
            $users = Users::find("email='" . $u->email ."'");

            //var_dump($users->toArray());

            if (count($users) == 0) {
                 $obj = new Users();
                 $obj->username = $u->login;
                 $obj->name = $u->name;
                 $obj->tokenType = $u->token_type;
                 $obj->tokenGithub = $u->access_token;
                 $obj->createdAt = $u->created_at;
                 $obj->karma = $u->karma;
                 $obj->vote = $u->votes;
                 $obj->email = $u->email;
                 $obj->status = 'active';
                 $obj->passwd = '$2y$12$Y2pGNld1V09KaEUwY2pxM.yS5v/Q.UIX7QIfc81R1cJyIH5A0s97q';
                 if (!$obj->save()) {
                    d($obj->getMessages());
                 }
            }
        }
    }
}
