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

use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;

class CommentForm extends Form
{
    public function initialize($entity = null)
    {
        if (!is_null($entity)) {
            $this->add(new Hidden('id'));
        }
        //content
        $content = new Textarea('content',[
            'placeholder' => t('Share what you think?'),
            'class'       => 'form-control',
            'required'    => true,
            'rows'        => 3

        ]);
        $content->addValidator(
            new PresenceOf(
                array(
                    'message' => t('Content is required.')
                )
            )
        );
        $this->add($content);

        $this->add(new Hidden('idObject'));
        $this->add(new Hidden('object'));
        //Submit
        $this->add(
            new Submit(
                'postAnswer',
                [
                    'value' => t('Post Your comment'),
                    'class' => 'btn btn-sm btn-info'
                ]
            )
        );
    }
}
