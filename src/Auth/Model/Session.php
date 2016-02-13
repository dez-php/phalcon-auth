<?php

namespace PhalconDez\Auth\Model;

use Phalcon\Mvc\Model as PhalconModel;

class Session extends PhalconModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $auth_id;

    /**
     *
     * @var string
     */
    public $adapter;

    /**
     *
     * @var string
     */
    public $auth_hash;

    /**
     *
     * @var string
     */
    public $user_hash;

    /**
     *
     * @var integer
     */
    public $user_ip;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $last_visit;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return static
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthId()
    {
        return $this->auth_id;
    }

    /**
     * @return string
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param string $adapter
     * @return $this
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * @param int $auth_id
     * @return static
     */
    public function setAuthId($auth_id)
    {
        $this->auth_id = $auth_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthHash()
    {
        return $this->auth_hash;
    }

    /**
     * @param string $auth_hash
     * @return static
     */
    public function setAuthHash($auth_hash)
    {
        $this->auth_hash = $auth_hash;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserHash()
    {
        return $this->user_hash;
    }

    /**
     * @param string $user_hash
     * @return static
     */
    public function setUserHash($user_hash)
    {
        $this->user_hash = $user_hash;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserIp()
    {
        return $this->user_ip;
    }

    /**
     * @param int $user_ip
     * @return static
     */
    public function setUserIp($user_ip)
    {
        $this->user_ip = $user_ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return static
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastVisit()
    {
        return $this->last_visit;
    }

    /**
     * @param string $last_visit
     * @return static
     */
    public function setLastVisit($last_visit)
    {
        $this->last_visit = $last_visit;
        return $this;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'auth_sessions';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Session[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Session
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
