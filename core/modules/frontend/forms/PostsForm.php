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

use Phanbook\Forms\FormBase;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Identical;
use Phanbook\Models\Categories;

class PostsForm extends FormBase
{
    public function initialize($entity = null)
    {
        // In edit page the id is hidden
        if (!is_null($entity)) {
            $this->add(new Hidden('id'));
        }

        //title
        $title = new Text(
            'title',
            array(
            'placeholder' => t('title'),
            'class'       => 'form-control',
            'required'    => true
            )
        );
        $title->addValidator(
            new PresenceOf(
                array(
                'message' => t('The title is required.')
                )
            )
        );
        $this->add($title);

        //content
        $content = new Textarea(
            'content',
            [
                'placeholder' => t(''),
                'required'    => true,
                'class' => 'form-control',
                'rows' => 3
            ]
        );
        $content->addValidator(
            new PresenceOf(
                array(
                'message' => t('content is required.')
                )
            )
        );
        $this->add($content);

        $cats = new Select('categoryId', Categories::find(),

            [
                'using' => ['id' ,'name'],
                'class' => 'form-control',
                'required' => true,
                'useEmpty'      => true,
                'emptyText'     => t('Please select a category'),
                'emptyValue'    => ''
            ]
        );

        $cats->addValidators([
           new PresenceOf([
               'message' => 'The category is required'
           ])
        ]);
        $this->add($cats);


        $status = new Select('status', $this->getStatus(),

            [
                'using' => ['id' ,'name'],
                'class' => 'form-control',
                'required' => true,
            ]
        );

        $status->addValidators([
           new PresenceOf([
               'message' => 'The category is required'
           ])
        ]);
        $this->add($status);

        $monetize = new Select('monetize', ['N' => 'No', 'Y' => 'Yes'],
            [
                'class' => 'form-control',
                'required' => true
            ]
        );
        $monetize->addValidators([
            new PresenceOf([
                'message' => 'The monetize is required'
            ])
        ]);
        $this->add($monetize);

        $this->add(new Hidden('object'));

        $tags = new Text('tags', [

            'class' => 'form-control',
            'placeholder' => 'Tags (e.g., albert einstein, flying pig, mashup)'
        ]);

        $this->add($tags);

    }
}
