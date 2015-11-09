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

and then fetch auth from container

```php
/** @var \PhalconDez\Auth\Auth $auth */
$auth   = $container->get('auth');
```

authorization

```php
try{
    $auth->authenticate('test@gmail.com', 'qwerty');
}catch (\Exception $e){
    echo "You have some errors: {$e->getMessage()}";
}
```

creating new credentials

```php
try{
    $auth->authenticate($email, $password);
}catch (\Exception $e){
    $auth->create($email, $password);
    $container->get('response')->redirect('auth-page');
}
```

verify password

```php
if($auth->isUser() && $auth->getAdapter()->verifyPassword('qwerty') === true){
    echo 'Password is corrected';
}
```

check user user authorization

```php
if($auth->isGuest() === true){
    echo 'You are non-authorized user';
}

if($auth->isUser() === true){
    echo 'You are authorized user';
}
```

get some authorized user data

```php
if($auth->isUser() === true){
    $userModel  = $auth->getUser();
    echo "Hello, {$userModel->getEmail()}. You was registered at {$userModel->getCreatedAt()}";
}
```

#Issues and pull-request

####I will be glad of your criticism, tasks, bugs and pull-request.