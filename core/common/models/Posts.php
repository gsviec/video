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

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phanbook\Amazon\CloudFront;
use Phanbook\Tools\ZFunction;
use Phanbook\Search\Posts as SearchPosts;
use Phanbook\Tools\ShortId;
use Phanbook\Utils\Slug;

class Posts extends ModelBase
{

    const POST_ALL   = 'all';
    const POST_BLOG  = 'blog';
    const POST_PAGE  = 'pages';
    const POST_VIDEO = 'video';
    const POST_QUESTIONS = 'questions';

    const VIDEO_VIMEO   = 'vimeo';
    const VIDEO_YOUTUBE = 'youtube';
    const VIDEO_DEFAULT = 'default';
    const VIDEO_GOOGLE_HOST = 'google';
    const VIDEO_JWPLAYER = 'jwplayer';

    const THUMBNAIL_DEFAULT = 'video-thumbnail.png';

    const CAT_SPORT = 17;
    const CAT_NEW = 25;
    const CAT_DOG = 3;
    const CAT_CATS = 4;
    const CAT_COMEDY = 23;
    const CAT_PET = 15;
    const CAT_ANIMAL = 5;

    const CAT_PHP = 1;
    const CAT_WP = 2;
    const CAT_GIT = 4;
    const CAT_DEVOPS = 6;
    const CAT_HTML = 7;
    const CAT_CSS  = 8 ;
    const CAT_PHALCON = 9;
    const CAT_TOOL = 10;
    const CAT_JS = 11;
    /**
     * Use Locked posts, just reading and can not comment to this post
     */
    const NO_LOCKED  = 'N';
    const YES_LOCKED = 'Y';

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $usersId;

    /**
     *
     * @var integer
     */
    protected $type;

    /**
     * @var string
     */
    protected $techOrder;
    /**
     *
     * @var string
     */
    protected $title;

    /**
     *
     * @var string
     */
    protected $link;

    /**
     *
     * @var string
     */
    protected $slug;

    /**
     *
     * @var string
     */
    protected $content;

    /**
     *
     * @var string
     */
    protected $excerpt;

    /**
     *
     * @var string | null
     */
    protected $thumbnail;
    /**
     *
     * @var integer
     */
    protected $numberViews;

    /**
     *
     * @var integer
     */
    protected $numberReply;

    /**
     *
     * @var string
     */
    protected $sticked;

    /**
     *
     * @var integer
     */
    protected $createdAt;

    /**
     *
     * @var integer
     */
    protected $modifiedAt;

    /**
     *
     * @var integer
     */
    protected $editedAt;

    /**
     *
     * @var string
     */
    protected $status;

    /**
     *
     * @var string
     */
    protected $locked;

    /**
     *
     * @var integer
     */
    protected $deleted;

    /**
     *
     * @var string
     */
    protected $acceptedAnswer;
    /**
     * @var string
     */
    protected $monetize;

    /**
     *
     * @var string
     */
    protected $filename;

    /**
     *
     * @var string
     */
    protected $duration;

    /**
     *
     * @var int
     */
    protected $categoryId;
    /**
     * @var string
     */
    protected $tags;

    /**
     * @var string
     */
    protected $videoFilename;

    /**
     * Method to set the value of field id
     *
     * @param  integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Method to set the value of field usersId
     *
     * @param  integer $usersId
     * @return $this
     */
    public function setUsersId($usersId)
    {
        $this->usersId = $usersId;

        return $this;
    }

    /**
     * @param string $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Method to set the value of field tagsId
     *
     * @param  integer $tagsId
     * @return $this
     */
    public function setType($type)
    {
        $this->type= $type;

        return $this;
    }

    /**
     * @param mixed $techOrder
     */
    public function setTechOrder($techOrder)
    {
        $this->techOrder = $techOrder;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getTechOrder()
    {
        return $this->techOrder;
    }
    /**
     * Method to set the value of field title
     *
     * @param  string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Method to set the value of field slug
     *
     * @param  string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Method to set the value of field content
     *
     * @param  string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Method to set the value of field thumbnail
     *
     * @param  string $thumbnail
     * @return $this
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Method to set the value of field excerpt
     *
     * @param  string $excerpt
     * @return $this
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Method to set the value of field numberViews
     *
     * @param  integer $numberViews
     * @return $this
     */
    public function setNumberViews($numberViews)
    {
        $this->numberViews = $numberViews;

        return $this;
    }

    /**
     * Method to set the value of field numberReply
     *
     * @param  integer $numberReply
     * @return $this
     */
    public function setNumberReply($numberReply)
    {
        $this->numberReply = $numberReply;

        return $this;
    }

    /**
     * Method to set the value of field sticked
     *
     * @param  string $sticked
     * @return $this
     */
    public function setSticked($sticked)
    {
        $this->sticked = $sticked;

        return $this;
    }

    /**
     * Method to set the value of field createdAt
     *
     * @param  integer $createdAt
     * @return $this
     */
    public function setCreatedaAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Method to set the value of field modifiedAt
     *
     * @param  integer $modifiedAt
     * @return $this
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Method to set the value of field editedAt
     *
     * @param  integer $editedAt
     * @return $this
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param  string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Method to set the value of field locked
     *
     * @param  string $locked
     * @return $this
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Method to set the value of field deleted
     *
     * @param  integer $deleted
     * @return $this
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Method to set the value of field acceptedAnswer
     *
     * @param  string $acceptedAnswer
     * @return $this
     */
    public function setAcceptedAnswer($acceptedAnswer)
    {
        $this->acceptedAnswer = $acceptedAnswer;

        return $this;
    }
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }
    public function getFilename()
    {

        return $this->filename;
    }

    /**
     * Get information a duration video
     *
     * @param  string
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }
    public function getDuration()
    {
        return $this->duration;
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
     * Returns the value of field usersId
     *
     * @return integer
     */
    public function getUsersId()
    {
        return $this->usersId;
    }

    public function getType()
    {
        return $this->type;
    }
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Returns the value of field slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Returns the value of field content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * Returns the value of field content
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * @return null|string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
    /**
     * @return string
     */
    public function getThumbnailUrl()
    {
        if ($this->techOrder == self::VIDEO_YOUTUBE) {
            $thumbnail = $this->getThumbnail();
        } elseif ($this->techOrder == self::VIDEO_VIMEO) {

        } elseif ($this->techOrder == self::VIDEO_GOOGLE_HOST) {

        } elseif ($this->techOrder == self::VIDEO_JWPLAYER) {
            $thumbnail = $this->getThumbnail();

        }
        else {
            if (!isset($this->thumbnail) || !file_exists(public_path('images/'. $this->thumbnail))) {
                $this->setThumbnail(self::THUMBNAIL_DEFAULT);
            }
            $staticBaseUri = $this->getDI()->getConfig()->application->staticBaseUri;
            $thumbnail = $staticBaseUri . 'images/' . $this->getThumbnail();

        }
        return $thumbnail;
    }

    /**
     * Returns the value of field numberViews
     *
     * @return integer
     */
    public function getNumberViews()
    {
        return $this->numberViews;
    }

    /**
     * Returns the value of field numberReply
     *
     * @return integer
     */
    public function getNumberReply()
    {
        return $this->numberReply;
    }

    /**
     * Returns the value of field sticked
     *
     * @return string
     */
    public function getSticked()
    {
        return $this->sticked;
    }

    /**
     * Returns the value of field createdAt
     *
     * @return integer
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Returns the value of field modifiedAt
     *
     * @return integer
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Returns the value of field editedAt
     *
     * @return integer
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * Returns the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the value of field locked
     *
     * @return string
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Returns the value of field deleted
     *
     * @return integer
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Returns the value of field acceptedAnswer
     *
     * @return string
     */
    public function getAcceptedAnswer()
    {
        return $this->acceptedAnswer;
    }

    /**
     * @param string $videoFilename
     */
    public function setVideoFilename($videoFilename)
    {
        $this->videoFilename = $videoFilename;
        return $this;
    }

    /**
     * @return string
     */
    public function getVideoFilename()
    {
        return $this->videoFilename;
    }

    /**
     * @param string $monetize
     */
    public function setMonetize(string $monetize)
    {
        $this->monetize = $monetize;
        return $this;
    }

    /**
     * @return string
     */
    public function getMonetize(): string
    {
        return $this->monetize;
    }
    /**
     * Implement hook beforeValidationOnCreate
     */
    public function beforeValidationOnCreate()
    {
        $this->sticked     = 'N';
        $this->status      = self::STATUS_ACTIVE;
        $this->locked      = self::NO_LOCKED;
        $this->numberViews = 0;
        $this->numberReply = 0;
        $this->acceptedAnswer = 'N';

        if (empty($this->techOrder)) {
            $this->techOrder = self::VIDEO_DEFAULT;
        }
        if (empty($this->categoryId)) {
            $this->categoryId = 1;
        }
        if (0 != $this->deleted) {
            $this->deleted = time(); //default video will not display it need review before public
        }
    }
    public function beforeValidation()
    {
        $this->slug = Slug::generate($this->title);
        if (empty($this->type)) {
            $this->type = self::POST_VIDEO;
        }
        if (empty($this->usersId)) {
            $this->usersId = $this->getDI()->getAuth()->getUserId();
        }
        if (ZFunction::isAdmin()) {
            $this->deleted = 0;
        }
    }


    /**
     * Implement hook beforeCreate
     *
     * Create a posts-views logging the ipaddress where the post was created
     * This avoids that the same session counts as post view
     */
    public function beforeCreate()
    {
        $postView            = new PostsViews();
        $postView->setIpaddress($this->getDI()->getRequest()->getClientAddress());
        $this->postview      = $postView;

        $this->createdAt  = time();
        $this->editedAt   = time();
    }

    /**
     * This method aids in setting up the model with a custom behavior i.e. a different table.
     * Is only called once during the request.
     */
    public function initialize()
    {
        parent::initialize();
        $this->useDynamicUpdate(true);
        $this->belongsTo('id', __NAMESPACE__ . '\PostsHistory', 'postsId', ['alias' => 'postHistory']);
        $this->belongsTo('usersId', __NAMESPACE__ . '\Users', 'id', ['alias' => 'user', 'reusable' => true]);
        $this->hasMany('id', __NAMESPACE__ . '\Comment', 'objectId', ['alias' => 'comment']);
        $this->hasMany('id', __NAMESPACE__ . '\PostsViews', 'postsId', ['alias' => 'postview']);
        $this->hasMany('id', __NAMESPACE__ . '\PostsReply', 'postsId', ['alias' => 'replies']);
        $this->hasMany('id', __NAMESPACE__ . '\PostsSubscribers', 'postsId', ['alias' => 'postSubscriber']);


        $this->hasManyToMany(
            'id',
            __NAMESPACE__ . '\PostsTags',
            'postsId',
            'tagsId',
            __NAMESPACE__ . '\Tags',
            'id',
            ['alias' => 'tag']
        );
        //SoftDelete api Phalcon
        $this->addBehavior(
            new SoftDelete(
                array(
                'field' => 'deleted',
                'value' => time()
                )
            )
        );
        $this->belongsTo('categoryId', __NAMESPACE__ . '\Categories', 'id', ['alias' => 'category', 'reusable' => true]);

    }
    /**
     * Implement hook beforeUpdate of Model Phalcon
     *
     * @return mixed
     */
    public function afterCreate()
    {
        if ($this->id > 0) {
            /**
             * Register the activity
             */
            $activity = new Activities();
            $activity->setUsersId($this->usersId);
            $activity->setPostsId($this->id);
            $activity->setType(Activities::NEW_POSTS);
            $activity->save();

            /**
             * Update the total of posts related to a category
             * Right now it just running the first time created a new post, not good to update total post
             * In a category :)
             */
            $this->category->numberPosts++;
            $this->category->save();

            /**
             * Register the user in the post's notifications
             */
            $notification = new PostsNotifications();
            $notification->setUsersId($this->usersId);
            $notification->setPostsId($this->id);
            $notification->save();

            $toNotify = [];

            /**
             * Notify users that always want notifications
             */
//            foreach (Users::find(['notifications = "Y"', 'columns' => 'id'])->toArray() as $user) {
//                if ($this->usersId != $user['id']) {
//                    $notificationId = $this->setNotification(
//                        $user['id'],
//                        $this->id,
//                        null,
//                        Notifications::TYPE_POSTS
//                    );
//                    $toNotify[$user['id']] = $notificationId;
//                }
//            }

            /**
             * Queue notifications to be sent
             */
            //$this->getDI()->getQueue()->put($toNotify);
        }
    }
    public function afterUpdate()
    {
        //Put jobs to upload the image after get form video
        if (!empty($this->getThumbnail()) && self::VIDEO_DEFAULT == $this->getTechOrder()) {
            $this->getDI()->getQueue()->enqueue(
                'upload_image_video',
                'Phanbook\\Queue\\UploadImage',
                ['filename' => $this->getThumbnail(), 'videoImage' => true],
                true
            );
        }
    }
    /**
     * @return string
     */
    public function getHumanNumberViews()
    {
        return $this->setHumanViewNumber($this->numberViews);
    }

    public function getHumanReplies()
    {
        return $this->setHumanViewNumber($this->numberReply);
    }

    /**
     * @return bool|string
     */
    public function getHumanEditedAt()
    {
        //d($this->editedAt);
        return ZFunction::getHumanDate($this->editedAt);
    }

    /**
     * @return bool|string
     */
    public function getHumanModifiedAt()
    {
        if ($this->modifiedAt != $this->createdAt) {
            return ZFunction::getHumanDate($this->modifiedAt);
        }
        return false;
    }

    /**
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getPetsVideos()
    {
        return $this->getVideoByCategory(self::CAT_PET);
    }

    /**
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getNewVideos()
    {
        $where = $this->getWhereVideo();
        $catIds = [self::CAT_PHP, self::CAT_WP, self::CAT_NEW, self::CAT_TOOL, self::CAT_GIT];
        $posts  = Posts::query()
            ->where($where)
            ->notInWhere('categoryId', $catIds)
            ->orderBy('createdAt DESC')
            ->limit($this->getLimit() / 2, $this->getOffset())
            ->execute()
        ;
        if ($posts->valid()) {
            return $posts;
        }
        return false;
    }

    /**
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getFeatureVideos()
    {
        $where = $this->getWhereVideo();
        $andWhere = "sticked = 'Y' OR numberViews > 10000";
        $posts  = Posts::query()
            ->where($where)
            ->andWhere($andWhere)
            ->orderBy('modifiedAt DESC')
            ->limit($this->getLimit(), $this->getOffset())
            ->execute();
        if ($posts->valid()) {
            return $posts;
        }
        return false;
    }
    /**
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getSportVideos()
    {
        return $this->getVideoByCategory(self::CAT_SPORT);
    }

    /**
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getComedyVideos()
    {
        return $this->getVideoByCategory(self::CAT_COMEDY);
    }
    public function getAnimalVideos()
    {
        return $this->getVideoByCategory(self::CAT_ANIMAL);
    }

    /**
     * @param $id
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getVideoByCategory($id)
    {
        $where = $this->getWhereVideo();
        $posts  = Posts::query()
            ->where($where)
            ->andWhere('categoryId = :id:')
            ->orderBy('numberReply DESC, modifiedAt DESC')
            ->limit($this->getLimit(), $this->getOffset())
            ->bind(['id' => $id])
            ->execute();

        if ($posts->valid()) {
            return $posts;
        }
        return false;
    }

    /**@TODO add cache to redis
     * @param $id
     * @return bool|int
     */
    public function countVideoByCategory($id)
    {
        $where = $this->getWhereVideo();
        $posts  = Posts::query()
            ->columns(['count(*)'])
            ->where($where)
            ->andWhere('categoryId = :id:')
            ->orderBy('numberReply DESC, modifiedAt DESC')
            ->bind(['id' => $id])
            ->execute();
        if ($posts->valid()) {
            return $posts;
        }
        return false;
    }
    public function getPopularVideos()
    {
        $where = $this->getWhereVideo();
        $posts  = Posts::query()
            ->where($where)
            ->orderBy('numberViews DESC, modifiedAt DESC')
            ->limit($this->getLimit(), $this->getOffset())
            ->execute();
        if ($posts->valid()) {
            return $posts;
        }
        return false;
    }

    /**
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getDogVideos()
    {
        return $this->getVideoByCategory(self::CAT_DOG);
    }

    /**
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getCatVideos()
    {
        return $this->getVideoByCategory(self::CAT_CATS);
    }

    /**
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getAllVideo()
    {
        $where = $this->getWhereVideo();
        $posts  = Posts::query()
            ->where($where)
            ->orderBy('numberViews DESC, modifiedAt DESC')
            ->execute();
        if ($posts->valid()) {
            return $posts;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getWhereVideo()
    {
        $status = self::STATUS_ACTIVE;
        return "deleted = 0 AND status = '{$status}' AND type = 'video'";
    }

    /**
     * Checks if the post can have a bounty
     *
     * @return boolean
     */
    public function canHaveBounty()
    {
        $canHave = $this->acceptedAnswer != "Y"
            && $this->sticked != 'Y'
            && $this->numberReply == 0
            && $this->type != self::POST_HACKERNEWS;
            //&& $this->tagsId != 15;
            //@todo late for condition vote
            //(vote) >= 0;
        if ($canHave) {
            $diff = time() - $this->createdAt;
            if ($diff > 86400) {
                if ($diff < (86400 * 30)) {
                    return true;
                }
            } else {
                if ($diff < 3600) {
                    return true;
                }
            }
            return false;
        }
    }
    /**
     * Calculates a bounty for the post
     *
     * @return array|bool
     */
    public function getBounty()
    {
        $diff = time() - $this->createdAt;
        if ($diff > 86400) {
            if ($diff < (86400 * 30)) {
                //@sory this hardcode :)
                return ['type' => 'old', 'value' => 150 + intval($diff / 86400 * 3)];
            }
        } else {
            if ($diff < 3600) {
                return ['type' => 'fast-reply', 'value' => 100];
            }
        }
        return false;
    }
    /**
     * To checking isset class, the symbol _ maybe it will avoid method default Phalcon
     *
     * @return boolean
     */
    public function _isPost()
    {
        return true;
    }

    /**
     * @return array
     */
    public function getRecentUsers()
    {
        $users  = [$this->user->getId() => [$this->user->getUsername(), $this->user->getEmail()]];
        foreach ($this->getReplies(['order' => 'createdAt DESC', 'limit' => 3]) as $reply) {
            if (!isset($users[$reply->user->getId()])) {
                $users[$reply->user->getId()] = [$reply->user->getUsername(), $reply->user->getEmail()];
            }
        }
        return $users;
    }
    //@todo add condition
    public static function totalPost()
    {
        return Posts::count();
    }
    /**
     * Get post related via elastic
     *
     * @param  object $post
     * @return object
     */
    public function getPostRelated(Posts $post)
    {
        $indexer = new SearchPosts();
        $params['title'] = $post->title;

        if (!empty($post->content)) {
            $params['content'] = $post->content;
        }
        $posts = $indexer->search($params, $this->limit, 0, true);
        if (0 == count($posts[0])) {
            unset($params['content']);
            $posts = $indexer->search($params, $this->limit, 0, true);
            if (0 == count($posts[0])) {
                $posts[0] = $this->getVideoRandomCategoriesElastic($post->categoryId);
                $posts[1] = 1;
            }
        }
        return $posts;
    }

    /**
     * This is function just use for this function above
     * @param int $id This is category Id
     * @param int $limit
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getVideoRandomCategoriesElastic($id = 1)
    {
        $where = $this->getWhereVideo();

        $builder = self::getBuilder();
        $builder
            ->from(Posts::class)
            ->where($where)
            ->andWhere('categoryId = :id:', ['id' => $id])
            ->orderBy('numberReply DESC, modifiedAt DESC')
            ->limit($this->getLimit())
            ;
        $result = $builder->getQuery()->execute();
        if ($result->count() == 0) {
            return null;
        }
        return $result;

    }
    /**
     * Get value favorite this post
     *
     * @return number
     */
    public function postFavorite()
    {
        return $this->postSubscriber->count();
    }

    /**
     * @return bool
     */
    public function isPublish()
    {
        if ($this->status == self::STATUS_ACTIVE) {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getShortId()
    {
        return ShortId::encode($this->id);
    }

    /**
     * @return string
     */
    public function getStreamUrl()
    {
        if ($this->techOrder == self::VIDEO_YOUTUBE) {
            $url = 'https://www.youtube.com/watch?v=' . $this->videoFilename . '&autoplay=1';
        } elseif ($this->techOrder == self::VIDEO_VIMEO) {

        } elseif ($this->techOrder == self::VIDEO_GOOGLE_HOST) {
            $url = 'https://drive.google.com/uc?export=download&id=' . $this->videoFilename;
        } elseif ($this->techOrder == self::VIDEO_JWPLAYER) {
            $url = 'http://content.jwplatform.com/videos/' . $this->videoFilename;
        } else {
            $cf = new CloudFront();
            $url = $cf->signedUrl($this->videoFilename);
        }
        return $url;
    }
    /**
     * @param Posts $post
     * @return mixed
     */
    public function getTechOrderAndType()
    {
        $item['tech'] = $item['type'] = $this->techOrder;
        if ($item['tech'] == Posts::VIDEO_DEFAULT || $item['tech'] == Posts::VIDEO_GOOGLE_HOST) {
            $item['type'] = 'mp4';
            $item['tech'] = 'html5';
        }
        return $item;
    }
    public function getPhalconVideos()
    {
        return $this->getVideoByCategory(self::CAT_PHALCON);
    }
    public function getWordpressVideos()
    {
        return $this->getVideoByCategory(self::CAT_WP);
    }
    public function getPhpVideos()
    {
        return $this->getVideoByCategory(self::CAT_PHP);
    }
    public function getDevopsVideos()
    {
        return $this->getVideoByCategory(self::CAT_DEVOPS);
    }
    public function getHtmlVideos()
    {
        return $this->getVideoByCategory(self::CAT_HTML);
    }
    public function getToolVideos()
    {
        return $this->getVideoByCategory(self::CAT_TOOL);
    }
    public function getJavaScriptVideos()
    {
        return $this->getVideoByCategory(self::CAT_JS);
    }
    public function getGitVideos()
    {
        return $this->getVideoByCategory(self::CAT_GIT);
    }
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'usersId' => 'usersId',
            'type'  => 'type',
            'techOrder' => 'techOrder',
            'title' => 'title',
            'link'  => 'link',
            'slug' => 'slug',
            'content' => 'content',
            'excerpt' => 'excerpt',
            'thumbnail' => 'thumbnail',
            'filename' => 'filename',
            'videoFilename' => 'videoFilename',
            'duration' => 'duration',
            'categoryId' => 'categoryId',
            'tags' => 'tags',
            'numberViews' => 'numberViews',
            'numberReply' => 'numberReply',
            'sticked' => 'sticked',
            'createdAt' => 'createdAt',
            'modifiedAt' => 'modifiedAt',
            'editedAt' => 'editedAt',
            'status' => 'status',
            'locked' => 'locked',
            'deleted' => 'deleted',
            'acceptedAnswer' => 'acceptedAnswer',
            'monetize' => 'monetize'
        ];
    }
}
