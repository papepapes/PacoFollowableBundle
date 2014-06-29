<?php

namespace Paco\Bundle\FollowableBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('paco_followable');

        $rootNode
            ->children()
                ->scalarNode('followable_id_attribute_name')
                    ->cannotBeEmpty()
                    ->info('You can specify another id for your followable class')
                    ->defaultValue("id")
                ->end()
                ->scalarNode('users_table_name')
                    ->cannotBeEmpty()
                    ->info('The table name used in your database to store your users.')
                    ->defaultValue("users")
                ->end()          
                ->scalarNode('joint_table_name')
                    ->cannotBeEmpty()
                    ->info('You can specify another name for the joint table')
                    ->defaultValue("follows")
                ->end()
                ->scalarNode('joint_table_follower_column_name')
                    ->cannotBeEmpty()
                    ->info('You can specify another name for the follower reference inside the joint table')
                    ->defaultValue("follower_id")
                ->end()
                ->scalarNode('joint_table_followee_column_name')
                    ->cannotBeEmpty()
                    ->info('You can specify another name for the followee reference inside the joint table')
                    ->defaultValue("followee_id")
                ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
