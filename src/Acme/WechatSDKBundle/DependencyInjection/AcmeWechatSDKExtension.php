<?php

namespace Acme\WechatSDKBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AcmeWechatSDKExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $property_access = PropertyAccess::createPropertyAccessor();

        $debug = $property_access->getValue($config, '[debug]');
        $clients = $property_access->getValue($config, '[clients]');

        $definitions = array();

        foreach ($clients as $name => $parameters) {
            // 要添加的ServiceId
            $service_id = sprintf('acme_wechat.%s.sdk', $name);

            // 判断这个ServiceId是否已经在容易类中出现，防止覆盖
            if (!$container->hasDefinition($service_id)) {
                $token = $property_access->getValue($parameters, '[token]');
                $appid = $property_access->getValue($parameters, '[appid]');
                $secret = $property_access->getValue($parameters, '[secret]');

                // 初始化Service定义类
                $definition = new Definition();
                $definition->setClass('Wiz\\WechatBundle\\SDK\\Wechat');
                $definition->addMethodCall('setContainer', array(new Reference('service_container')));
                $definition->setArguments(array($name, $token, $appid, $secret, $debug));

                $definitions[$service_id] = $definition;
            } else
                throw new \RuntimeException(sprintf('Service %s is exist', $service_id));
        }
        $container->addDefinitions($definitions);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
