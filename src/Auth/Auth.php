<?php

    namespace PhalconDez\Auth;

    use Phalcon\Mvc\User\Component;
    use Phalcon\Mvc\Model as PhalconModel;
    use PhalconDez\Auth\Model\Credentials as CredentialsModel;

    class Auth extends Component {

        protected $initialized  = false;

        protected $options  = [];

        protected $adapter;

        protected $user;

        public function __construct( Adapter $adapter )
        {
            $adapter->setAuth($this);
            $this->setAdapter( $adapter );
        }

        /**
         * @param string $email
         * @param string $password
         * @return $this
         */
        public function authenticate($email, $password)
        {
            $this->getAdapter()->setEmail($email)->setPassword($password);
            $this->getAdapter()->authenticate();
            return $this;
        }

        /**
         * @return $this
         */
        public function logout()
        {
            return $this;
        }

        /**
         * @param $email
         * @param $password
         * @return $this
         */
        public function create($email, $password)
        {
            $this->getAdapter()->setEmail($email)->setPassword($password)->createCredentials();
            return $this;
        }

        /**
         * @return $this
         */
        public function initialize()
        {
            $this->setInitialized(true)->getAdapter()->initialize();
            return $this;
        }

        /**
         * @return boolean
         */
        public function isInitialized()
        {
            return $this->initialized;
        }

        /**
         * @param boolean $initialized
         * @return $this
         */
        public function setInitialized($initialized)
        {
            $this->initialized = $initialized;
            return $this;
        }

        /**
         * @param array $options
         * @return $this
         */
        public function setOptions(array $options = [])
        {
            foreach( $options as $name => $option ) {
                $this->setOption($name, $option);
            }
            return $this;
        }

        /**
         * @param $name
         * @param $value
         * @return $this
         */
        public function setOption($name, $value)
        {
            $this->options[$name]   = $value;
            return $this;
        }

        /**
         * @param $name
         * @return bool
         */
        public function hasOption($name)
        {
            return isset($this->options[$name]);
        }

        /**
         * @param $name
         * @param null $default
         * @return null
         */
        public function getOption($name, $default = null)
        {
            return $this->hasOption($name) ? $this->options[$name] : $default;
        }

        /**
         * @param PhalconModel $credentialsModel
         * @return $this
         */
        public function setCredentialsModel(PhalconModel $credentialsModel)
        {
            $this->getAdapter()->setCredentialsModel($credentialsModel);
            return $this;
        }

        /**
         * @param PhalconModel $sessionModel
         * @return $this
         */
        public function setSessionModel(PhalconModel $sessionModel)
        {
            $this->getAdapter()->setSessionModel($sessionModel);
            return $this;
        }

        /**
         * @return Adapter
         */
        public function getAdapter()
        {
            return $this->adapter;
        }

        /**
         * @param Adapter $adapter
         * @return $this
         */
        public function setAdapter(Adapter $adapter)
        {
            $adapter->setDI( $this->getDI() );
            $this->adapter = $adapter;
            return $this;
        }

        /**
         * @return CredentialsModel
         */
        public function getUser()
        {
            if( ! $this->isInitialized() ) {
                $this->initialize();
            }
            return $this->user;
        }

        /**
         * @param PhalconModel $user
         * @return static
         */
        public function setUser(PhalconModel $user)
        {
            $this->user = $user;
            return $this;
        }

        /**
         * @return bool
         */
        public function isGuest() {
            $userModel  = $this->getUser();
            return ! $userModel;
        }

        /**
         * @return bool
         */
        public function isUser() {
            return ! $this->isGuest();
        }

        /**
         * @return int
         */
        public function id() {
            return $this->isUser() ? $this->getUser()->id() : 0;
        }

    }