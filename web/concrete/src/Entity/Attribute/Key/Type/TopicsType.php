<?php
namespace Concrete\Core\Entity\Attribute\Key\Type;

use Concrete\Core\Entity\Attribute\Value\Value\TopicsValue;
use Concrete\Core\Tree\Tree;

/**
 * @Entity
 * @Table(name="TopicsAttributeKeyTypes")
 */
class TopicsType extends Type
{
    /**
     * @Column(type="integer")
     */
    protected $akTopicParentNodeID = 0;

    /**
     * @Column(type="integer")
     */
    protected $akTopicTreeID = 0;

    /**
     * @return mixed
     */
    public function getTopicTreeID()
    {
        return $this->akTopicTreeID;
    }

    /**
     * @param mixed $topicTreeID
     */
    public function setTopicTreeID($topicTreeID)
    {
        $this->akTopicTreeID = $topicTreeID;
    }

    /**
     * @return mixed
     */
    public function getParentNodeID()
    {
        return $this->akTopicParentNodeID;
    }

    /**
     * @param mixed $parentNodeID
     */
    public function setParentNodeID($parentNodeID)
    {
        $this->akTopicParentNodeID = $parentNodeID;
    }

    public function getAttributeValue()
    {
        return new TopicsValue();
    }

    public function getTopicTreeObject()
    {
        return Tree::getByID($this->topicTreeID);
    }
}
