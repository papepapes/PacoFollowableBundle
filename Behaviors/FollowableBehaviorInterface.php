<?php

namespace Paco\Bundle\FollowableBundle\Behaviors;

use Doctrine\Common\Collections\ArrayCollection;


interface FollowableBehaviorInterface
{
	public function getFollowers();
	public function setFollowers(ArrayCollection $followers);
	public function getFollowees();
	public function setFollowees(ArrayCollection $followees);
	public function addFollower(FollowableBehaviorInterface $follower);
	public function addFollowee(FollowableBehaviorInterface $followee);
	public function removeFollower(FollowableBehaviorInterface $follower);
	public function removeFollowee(FollowableBehaviorInterface $followee);
} 