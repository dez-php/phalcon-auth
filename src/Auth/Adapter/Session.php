<?php

    namespace PhalconDez\Auth\Adapter;

    use PhalconDez\Auth\InvalidDataException;
    use PhalconDez\Auth\Model\Session as SessionModel;
    use PhalconDez\Auth\Adapter;
    use PhalconDez\Auth\RuntimeErrorException;
    use PhalconDez\Auth\Util\UUID;

    class Session extends Adapter {

        /**
         * @return $this
         * @throws InvalidDataException
         * @throws RuntimeErrorException
         */
        public function authenticate()
        {
            $credentials    = $this->getCredentialsModel()->findFirst([
                    'email = :email: AND password = :password:',
                    'bind'  => [
                        'email'     => $this->getEmail(),
                        'password'  => $this->getPasswordHash(),
                    ]
                ]);

            if( $credentials !== false ) {
                $this->setCredentialsModel($credentials);
                $this->setSessionModel($this->makeSession());
            } else {
                throw new InvalidDataException( "Invalid password or email" );
            }

            return $this;
        }

        /**
         * @return $this
         */
        public function initialize()
        {
            if( $this->cookies->has($this->cookieKey()) ) {
                $cookieToken    = $this->cookies->get($this->cookieKey());

                $sessionModel   = $this->getSessionModel()->findFirst([
                    'auth_hash = :hash',
                    'bind'  => [ 'hash' => $this->makeHash( $cookieToken ) ]
                ]);

                if( $sessionModel !== false ) {
                    $credential = $this->getCredentialsModel()->findFirst($sessionModel->getAuthId());
                    $this->setSessionModel($sessionModel)->setCredentialsModel($credential);
                }
            }
            return $this;
        }

        /**
         * @return \DateTime
         */
        protected function expiryDate()
        {
            return (new \DateTime('+30 days'));
        }

        public function createCredentials()
        {
            $credentials    = $this->getCredentialsModel()
                ->setEmail($this->getEmail())
                ->setPassword($this->getPasswordHash())
                ->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'))
                ->setUpdatedAt((new \DateTime())->format('Y-m-d H:i:s'))
                ->setStatus('active');

            $credentials->save();
            $this->setCredentialsModel($credentials);
            return $this;
        }

        /**
         * @param SessionModel $sessionModel
         * @return $this
         */
        protected function updateSession(SessionModel $sessionModel)
        {
            $sessionModel->setLastVisit((new \DateTime())->format('Y-m-d H:i:s'))->save();
            return $this;
        }

        /**
         * @return SessionModel
         * @throws RuntimeErrorException
         */
        protected function makeSession()
        {
            $cookieToken    = UUID::v5(mt_rand().self::SALT);
            $this->cookies->set($this->cookieKey(), $cookieToken, $this->expiryDate()->getTimestamp())->send();

            $sessionModel   = $this->getSessionModel()
                ->setAuthId($this->getCredentialsModel()->getId())
                ->setAuthHash($this->makeHash($cookieToken))
                ->setUserHash($this->uniqueToken())
                ->setUserIp(ip2long($this->request->getClientAddress(true)))
                ->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'))
                ->setLastVisit((new \DateTime())->format('Y-m-d H:i:s'));

            if(!$sessionModel->save()) {
                throw new RuntimeErrorException( "Session can not been saved. Check your models" );
            }

            return $sessionModel;
        }

    }