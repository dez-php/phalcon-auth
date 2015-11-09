# phalcon-auth
### Auth Component for Phalcon 2.x Framework

#Usage

Register Auth in dependency injection container

```php
include_once '../vendor/autoload.php';

$container  = new \Phalcon\Di\FactoryDefault();

$container->set('auth', function(){
    
    // Pass session adapter into Auth
    $auth   = new \PhalconDez\Auth\Auth(
        new \PhalconDez\Auth\Adapter\Session()
    );
    
    // Pass empty instance of Credentials Model implement PhalconModel
    $auth->setCredentialsModel(
        new \PhalconDez\Auth\Model\Credentials()
    );
    
    // Pass empty instance of Session Model implement PhalconModel
    $auth->setSessionModel(
        new \PhalconDez\Auth\Model\Session()
    );
    
    // Run initialize
    $auth->initialize();
    
    return $auth;
});
```

and when fetch auth from container

```php
/** @var \PhalconDez\Auth\Auth $auth */
$auth   = $container->get('auth');
```