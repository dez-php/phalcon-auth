<?php

if(!extension_loaded('phalcon')) {
    die('Phalcon not installed in your server. Follow the link: https://github.com/phalcon/cphalcon#linuxunixmac');
}

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include_once '../vendor/autoload.php';

$container  = new \Phalcon\Di\FactoryDefault();

$container->set('auth', function(){

    $auth   = new \PhalconDez\Auth\Auth(
        // Adapter
        new \PhalconDez\Auth\Adapter\Session()
    );

    $auth->setCredentialsModel(
        // Model for credentials
        new \PhalconDez\Auth\Model\Credentials()
    );

    $auth->setSessionModel(
        // Model for sessions
        new \PhalconDez\Auth\Model\Session()
    );
    $auth->initialize();

    return $auth;
});

$container->set('cookies', function () {
    $cookies = new \Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(false);
    return $cookies;
});

$container->setShared('session', function () {
    $session = new \Phalcon\Session\Adapter\Files();
    $session->setName( 'phalcon_session' );
    $session->start();
    return $session;
});

$container->set('crypt', function () {
    $crypt = new \Phalcon\Crypt();
    $crypt->setMode(MCRYPT_MODE_CFB);
    $crypt->setKey('%31.1e$i86e$f!8j');
    return $crypt;
});

$container->set('security', function(){
    $security = new \Phalcon\Security();
    $security->setWorkFactor(12);
    return $security;
}, true);

$container->set('db', function(){
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host"      => 'localhost',
        "username"  => 'root',
        "password"  => 'root',
        "dbname"    => 'dez-auth'
    ));
});

$app        = new \Phalcon\Mvc\Micro();
$app->setDI($container);

$app->session->start();

$app->get('/', function() use ($container, $app){

    /** @var \PhalconDez\Auth\Auth $auth */
    $auth   = $container->get('auth');

    if( $app->request->get( 'auth' ) > 0 ) {
        $auth->authenticate('mail@mail.com', '123qwe');
    }

    if( $app->request->get( 'create' ) > 0 ) {
        $auth->create('mail@mail.com', '123qwe');
    }

    var_dump($auth);

    return new \Phalcon\Http\Response('test auth component');
});

$app->handle()->getContent();