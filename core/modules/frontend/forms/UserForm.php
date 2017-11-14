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
namespace Phanbook\Frontend\Forms;

use Phanbook\Models\Users;
use Phanbook\Validators\BirthDate;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Radio;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Forms\Element\TextArea;

class UserForm extends Form
{
    public function initialize($entity = null)
    {
        // In edit page the id is hidden
        if (!is_null($entity)) {
            $this->add(new Hidden('id'));
        }

        //Full Name
        $fullName = new Text(
            'name',
            [
                'placeholder' => t('Full Name'),
                'required' => 'true',
                'class' => 'form-control'
            ]
        );
        $fullName->addValidators(
            [
                new PresenceOf(
                    [
                    'message' => t('Full name is required.')
                    ]
                )
            ]
        );
        $this->add($fullName);

        //Username
        $username = new Text(
            'username',
            [
                'placeholder' => t('Username'),
                'required' => 'true',
            ]
        );
        $username->addValidators(
            [
                new PresenceOf(
                    [
                    'message' => t('Username is required.')
                    ]
                )
            ]
        );
        $this->add($username);


        //Bio
        $bio = new TextArea(
            'bio',
            [
                'placeholder' => 'Please add Bio information of your',
                'class'       => 'form-control',
                'rows'  => 3
            ]
        );

        $this->add($bio);

        $twitter = new Text(
            'twitter',
            [
            'placeholder' => 'Please add twitter of your',
            ]
        );
        $this->add($twitter);

        $facebook = new Text(
            'facebook',
            [
            'placeholder' => 'Please add facebook of your',
            ]
        );
        $this->add($facebook);

        $google = new Text(
            'google',
            [
                'placeholder' => 'Please add Google of your',
            ]
        );
        $this->add($google);

        //Phone
        // $phone = new Text('phone', [
        //     'placeholder' => 'Phone',
        //     'required' => 'true'
        // ]);
        // $phone->addValidators([
        //         new PresenceOf([
        //             'message' => 'Phone numer is required.'
        //         ]),
        //         new Phone(array(
        //             'message' => t('Phone number is invalid and it needs to be in format 0722000777')
        //         ))
        //     ]);
        // $this->add($phone);

        //birhtDate
        $birthDate = new Text(
            'birthDate',
            [
            'placeholder' => 'yyyy-mm-dd'
            ]
        );
        $birthDate->addValidators(
            [
                new BirthDate(
                    array(
                    'message' => t('Birth date is invalid.')
                    )
                )
            ]
        );
        $this->add($birthDate);
        //$this->add(new File('avatar'));


        //Submit
        $this->add(
            new Submit(
                'save',
                [
                'value' => 'Save',
                'class' => 'btn btn-sm btn-info'
                ]
            )
        );
        $this->add(
            new Submit(
                'saveAvatar',
                [
                'value' => 'Change avatar',
                'class' => 'button color small login-submit submit'
                ]
            )
        );
    }
}
