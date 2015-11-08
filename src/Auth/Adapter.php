<?php

    namespace PhalconDez\Auth;

    use Phalcon\Mvc\User\Component;
    use PhalconDez\Auth\Model\Session as SessionModel;
    use PhalconDez\Auth\Model\Credentials as CredentialsModel;
    use PhalconDez\Auth\Util\UUID;

    abstract class Adapter extends Component {

        const SALT  = 'phalcon-auth_RrXKb26DfSsrIwX4MCie';

        protected $auth;

        protected $email;

        protected $password;

        protected $credentialsModel;

        protected $sessionModel;

        public function __construct()
        {

        }

        /**
         * @return string
         */
        protected function uniqueToken()
        {
            return UUID::v5($this->request->getClientAddress(true).$this->request->getUserAgent());
        }

        /**
         * @return string
         */
        protected function cookieKey()
        {
            return 'phalcon-auth-'.UUID::v5(self::SALT);
        }

        /**
         * @param $password
         * @return bool
         */
        public function verifyPassword($password)
        {
            return ( $this->makeHash($password) === $this->getPasswordHash() );
        }

        /**
         * @param string $string
         * @return string
         */
        public function makeHash($string)
        {
            return UUID::v5($this->uniqueToken().self::SALT.$string.self::SALT);
        }

        /**
         * @return string
         */
        public function getPasswordHash()
        {
            return $this->makeHash($this->getPassword());
        }

        /**
         * @return Auth
         */
        public function getAuth()
        {
            return $this->auth;
        }

        /**
         * @param Auth $auth
         * @return static
         */
        public function setAuth(Auth $auth)
        {
            $this->auth = $auth;
            return $this;
        }

        /**
         * @return string
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @param mixed $password
         * @return static
         */
        public function setPassword($password)
        {
            $this->password = $password;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @param mixed $email
         * @return static
         */
        public function setEmail($email)
        {
            $this->email = $email;
            return $this;
        }

        /**
         * @return CredentialsModel
         */
        public function getCredentialsModel()
        {
            return $this->credentialsModel;
        }

        /**
         * @param CredentialsModel $credentialsModel
         * @return static
         */
        public function setCredentialsModel(CredentialsModel $credentialsModel)
        {
            $this->credentialsModel = $credentialsModel;
            $this->getAuth()->setUser($credentialsModel);
            return $this;
        }

        /**
         * @return SessionModel
         */
        public function getSessionModel()
        {
            return $this->sessionModel;
        }

        /**
         * @param SessionModel $sessionModel
         * @return static
         */
        public function setSessionModel(SessionModel $sessionModel)
        {
            $this->sessionModel = $sessionModel;
            return $this;
        }

        /**
         * @return $this
         */
        abstract public function authenticate();

        /**
         * @return $this
         */
        abstract public function initialize();

        /**
         * @return $this
         */
        abstract public function createCredentials();

    }