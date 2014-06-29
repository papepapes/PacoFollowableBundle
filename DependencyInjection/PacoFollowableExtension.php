<?php

namespace Paco\Bundle\FollowableBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PacoFollowableExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');


        $container->setParameter('paco_followable.followable_id_attribute_name', $config['followable_id_attribute_name']);
        $container->setParameter('paco_followable.users_table_name', $config['users_table_name']);
        $container->setParameter('paco_followable.joint_table_name', $config['joint_table_name']);
        $container->setParameter('paco_followable.joint_table_follower_column_name', $config['joint_table_follower_column_name']);
        $container->setParameter('paco_followable.joint_table_followee_column_name', $config['joint_table_followee_column_name']);


    }
}
