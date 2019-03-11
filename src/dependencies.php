<?php
// DIC configuration
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Doctrine\ORM\Tools\Setup;
use Valitron\Validator as V;

V::lang('pt-br');
$container = $app->getContainer();

// monolog
$container['logger'] = function ($container) {
    $settings = $container->settings['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['entityManager'] = function ($container) : EntityManager {
    
    $config = Setup::createYAMLMetadataConfiguration(
        $container->get('settings')['doctrine']['metadata_dirs'],
        $container->get('settings')['doctrine']['dev_mode']
    );
    
    $config->setMetadataDriverImpl(
        new YamlDriver(
            $container->get('settings')['doctrine']['metadata_dirs']
        )
    );

    $config->setMetadataCacheImpl(
        new FilesystemCache(
            $container->get('settings')['doctrine']['cache_dir']
        )
    );

    return EntityManager::create(
        $container->get('settings')['doctrine']['connection'],
        $config
    );
};