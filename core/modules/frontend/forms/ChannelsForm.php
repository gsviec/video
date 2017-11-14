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

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Identical;
use Phanbook\Models\Province;

class ChannelsForm extends Form
{
    public function initialize($entity = null)
    {
        // In edit page the id is hidden
        if (!is_null($entity)) {
            $this->add(new Hidden('id'));
        }

        //title
        $name = new Text(
            'name',
            array(
            'placeholder' => t('title'),
            'class'       => 'form-control',
            'required'    => true
            )
        );
        $name->addValidator(
            new PresenceOf(
                array(
                'message' => t('The title is required.')
                )
            )
        );
        $this->add($name);

        $slug = new Text(
            'slug',
            array(
            'class'       => 'form-control',
            'required'    => true
            )
        );
        $slug->addValidator(
            new PresenceOf(
                array(
                'message' => t('The slug is required.')
                )
            )
        );
        $this->add($slug);

        //content
        $description = new Textarea(
            'description',
            array(
            'placeholder' => t('Adding information for link your submit!'),
            'required'    => true,
            'rows'  =>5,
            'class' => 'form-control'

            )
        );
        $description->addValidator(
            new PresenceOf(
                array(
                'message' => t('Description is required.')
                )
            )
        );
        $this->add($description);
    }
}
