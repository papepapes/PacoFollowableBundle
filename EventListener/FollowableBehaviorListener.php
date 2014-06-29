<?php

namespace Paco\Bundle\FollowableBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;


class FollowableBehaviorListener implements EventSubscriber
{
	
    public function __construct($followableIdAttributeName, $jointTableName, $refFollowerIdColumnName, $refFolloweeIdColumnName)
    {
        $this->followableIdAttributeName = $followableIdAttributeName;
        $this->jointTableName = $jointTableName;
        $this->refFollowerIdColumnName = $refFollowerIdColumnName;
        $this->refFolloweeIdColumnName = $refFolloweeIdColumnName;
    }

	/**
	 * {@inheritdoc}
	 */
	function getSubscribedEvents()
	{
		return array(
            Events::loadClassMetadata,
        );
	}

	/**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
    	// the $metadata is the whole mapping info for this class
        $metadata = $eventArgs->getClassMetadata();

        if(!(in_array('Paco\Bundle\FollowableBundle\Behaviors\FollowableBehaviorInterface', class_implements($metadata->getName())))){
            die(var_dump(class_implements($metadata->getName())));
            return;
        }

        $namingStrategy = $eventArgs
            ->getEntityManager()
            ->getConfiguration()
            ->getNamingStrategy();

        $metadata->mapManyToMany(array(
            'targetEntity'  => $metadata->getName(),
            'fieldName'     => 'followees',
            'mappedBy'       => 'followers'
        ));    

        $metadata->mapManyToMany(array(
            'targetEntity'  => $metadata->getName(),
            'fieldName'     => 'followers',
            'inversedBy'     => 'followees',
            'cascade'       => array('persist'),
            'joinTable'     => array(
                'name'        => $this->jointTableName,
                'joinColumns' => array(
                    array(
                        'name'                  => $this->refFollowerIdColumnName,
                        'referencedColumnName'  => $this->followableIdAttributeName
                    ),
                ),
                'inverseJoinColumns'    => array(
                    array(
                        'name'                  => $this->refFolloweeIdColumnName,
                        'referencedColumnName'  => $this->followableIdAttributeName
                    ),
                )
            )
        ));
    }
}