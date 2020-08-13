<?php
error_reporting(E_ALL);

defined('APP_PATH') || define('APP_PATH', realpath('./..'));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', 'development');

require __DIR__ . '/../vendor/autoload.php';

use Phalcon\Loader;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;
use App\Api\Routes as Api_Routes;
use App\Swagger\Routes as Swagger_Routes;

use Firebase\JWT\JWT as JWT;

class Application extends BaseApplication
{
    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    protected function registerServices()
    {
        $di = new FactoryDefault();
        $loader = new Loader();
        $config = include_once '../config/config.php';

        /**
         * We're a registering a set of directories taken from the configuration file
         */
        $loader
            ->registerDirs([
                    $config->application->libraryDir,
                    $config->application->migrationsDir,
                    $config->application->middlewaresDir
                ]
            )
            ->registerNamespaces([
                    'App\Helpers' => APP_PATH . '/helpers',
                    'App\Library' => APP_PATH . '/library',
                    'App\Library\Encrypter' => APP_PATH . '/library/encrypter',
                    'App\Api' => APP_PATH . '/modules/api',
                    'App\Swagger' => APP_PATH . '/modules/swagger',
                    'App\Mappers' => APP_PATH . '/mappers',
                    'App\Traits' => APP_PATH . '/traits'
                ]
            )
            ->register();

        // register services
        /**
         * Sets the view component
         */
        $di->setShared('view', function () use ($config) {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir($config->application->viewsDir);
            return $view;
        });

        /**
         * Sets config to shared
         */
        $di->setShared('config', function () use ($config) {
            return $config;
        });


        /**
         * Crypt service
         */
        $di->set('mycrypt', function () use ($config) {
            $crypt = new \Phalcon\Crypt();
            $crypt->setCipher('aes-256-ctr');
            $crypt->setKey($config->get('authentication')->encryption_key);
            return $crypt;
        }, true);

        /**
         * JWT service
         */
        $di->setShared('jwt', function () {
            return new JWT();
        });

        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di->setShared('db', function () use ($config) {
            $dbConfig = $config->database->toArray();
            $adapter = $dbConfig['adapter'];
            unset($dbConfig['adapter']);

            $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

            $connection = new $class($dbConfig);
            $connection->setNestedTransactionsWithSavepoints(true);

            return $connection;
        });

        $parts = explode('/', $_SERVER['REQUEST_URI']);

        if (in_array('api', $parts)) {
            $di->set('router', new Api_Routes(false));
        } else {
            $di->set('router', new Swagger_Routes(false));
        }

        $this->setDI($di);
    }

    public function main()
    {
        $this->registerServices();

        // Register the installed modules
        $this->registerModules([
            'api' => [
                'className' => 'App\Api\Module',
                'path' => APP_PATH . '/modules/api/Module.php'
            ],
            'swagger' => [
                'className' => 'App\Swagger\Module',
                'path' => APP_PATH . '/modules/swagger/Module.php'
            ]

        ]);
        echo $this->handle();
    }
}

$application = new Application();
$application->main();