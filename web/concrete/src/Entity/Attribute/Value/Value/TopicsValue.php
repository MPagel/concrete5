<?php
namespace Concrete\Core\Entity\Attribute\Value\Value;

use Concrete\Core\Tree\Node\Node;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="TopicAttributeValues")
 */
class TopicsValue extends Value
{
    /**
     * @OneToMany(targetEntity="\Concrete\Core\Entity\Attribute\Value\Value\SelectedTopic", mappedBy="value", cascade={"all"})
     * @JoinColumn(name="avID", referencedColumnName="avID")
     */
    protected $topics;

    /**
     * TopicsValue constructor.
     *
     * @param $topics
     */
    public function __construct()
    {
        parent::__construct();
        $this->topics = new ArrayCollection();
    }

    public function getValue()
    {
        return $this->getSelectedTopicNodes();
    }


    public function getSelectedTopics()
    {
        return $this->topics;
    }

    public function setSelectedTopics($topics)
    {
        $this->topics = $topics;
    }

    public function getSelectedTopicNodes()
    {
        $topics = array();
        foreach($this->topics as $selectedTopic) {
            $node = Node::getByID($selectedTopic->getTreeNodeID());
            if (is_object($node)) {
                $topics[] = $node;
            }
        }
        return $topics;
    }
}
