<?php
/**
 * Phanbook : Delightfully simple forum and Q&A software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @author  Phanbook <hello@phanbook.com>
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
namespace Phanbook\Oauth\Forms;

use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;

class SignupForm extends Form
{
    public function initialize()
    {

        $email = new Email('email', [
            'placeholder'  => 'sample@gmail.com',
            'class'        => 'form-control',
            'autocomplete' => 'off'
        ]);
        $this->add($email);

        $name = new Text('name', [
            'placeholder'  => 'First name',
            'class'        => 'form-control'
        ]);
        $this->add($name);

        $u = new Text('username', [
            'placeholder'  => 'Username',
            'class'        => 'form-control'
        ]);
        $this->add($u);

    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }
}
