<?php
namespace Phanbook\Models;

class PostsPlaylist extends ModelBase
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $postId;

    /**
     *
     * @var integer
     */
    protected $playlistId;
    

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field postId
     *
     * @param integer $postId
     * @return $this
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * Method to set the value of field playlistId
     *
     * @param integer $playlistId
     * @return $this
     */
    public function setPlaylistId($playlistId)
    {
        $this->playlistId = $playlistId;

        return $this;
    }


    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field postId
     *
     * @return integer
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * Returns the value of field playlistId
     *
     * @return integer
     */
    public function getPlaylistId()
    {
        return $this->playlistId;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("'postsPlaylist'");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'postsPlaylist';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Postsplaylist[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Postsplaylist
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * @param $data
     * @return bool
     */
    public static function addData($data)
    {
        $postId = $data['postId'];
        $playlistId = $data['playlistId'];
        if (!isset($postId) || !isset($playlistId)) {
            return false;
        }
        //@TODO refactor
        $obj = PostsPlaylist::findFirst("postId = {$postId} AND playlistId = {$playlistId}");
        if (!$obj) {
            $obj = new PostsPlaylist();
            $obj->setPostId($postId);
            $obj->setPlaylistId($playlistId);
            if (!$obj->save()) {
                return false;
            }
        }
        return true;
    }
    public function getNumberPostByPlaylist($id)
    {
        return PostsPlaylist::count('playlistId = ' . $id);
    }
    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'postId' => 'postId',
            'playlistId' => 'playlistId',
            'createdAt' => 'createdAt'
        );
    }

}
