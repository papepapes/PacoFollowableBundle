<?php

namespace Paco\Bundle\FollowableBundle\Behaviors;

use Doctrine\Common\Collections\ArrayCollection;

trait FollowableBehaviorTrait
{
	protected $followers;
	protected $followees;

	protected function checkCollections()
	{
		if(!$this->followers)
			$this->followers = new ArrayCollection();
		if(!$this->followees)
			$this->followees = new ArrayCollection();
	}
	public function getFollowers()
	{
		$this->checkCollections();
		return $this->followers;
	}
	public function setFollowers(ArrayCollection $followers)
	{
		$this->followers = $followers;
	}
	public function getFollowees()
	{
		
		$this->checkCollections();
		return $this->followees;
	}
	public function setFollowees(ArrayCollection $followees)
	{
		$this->followees = $followees;
	}
	public function addFollower(FollowableBehaviorInterface $follower)
	{
		$this->checkCollections();
		$this->followers->add($follower);
	}
	public function removeFollower(FollowableBehaviorInterface $follower)
	{
		$this->checkCollections();
		$this->followers->removeElement($follower);
	}
	public function addFollowee(FollowableBehaviorInterface $followee)
	{
		$this->checkCollections();
		$this->followees->add($followee);
	}
	public function removeFollowee(FollowableBehaviorInterface $followee)
	{
		$this->checkCollections();
		$this->followees->removeElement($followee);
	}
}