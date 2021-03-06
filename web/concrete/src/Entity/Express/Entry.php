<?php
namespace Concrete\Core\Entity\Express;

use Concrete\Core\Attribute\ObjectTrait;
use Concrete\Core\Entity\Attribute\Value\ExpressValue;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="\Concrete\Core\Entity\Express\EntryRepository")
 * @Table(name="ExpressEntityEntries")
 */
class Entry implements \JsonSerializable
{

    use ObjectTrait;

    public function getObjectAttributeCategory()
    {
        $category = \Core::make('\Concrete\Core\Attribute\Category\ExpressCategory');
        $category->setEntity($this->getEntity());
        return $category;
    }

    public function getAttributeValueObject($ak, $createIfNotExists = false)
    {
        if (!is_object($ak)) {
            $ak = $this->getEntity()->getAttributeKeyCategory()->getByHandle($ak);
        }
        $value = false;
        if (is_object($ak)) {
            foreach($this->getAttributes() as $attribute) {
                if ($attribute->getAttributeKey()->getAttributeKeyID() == $ak->getAttributeKeyID()) {
                    return $attribute;
                }
            }
        }

        if ($createIfNotExists) {
            $attributeValue = new ExpressValue();
            $attributeValue->setEntry($this);
            $attributeValue->setAttributeKey($ak);
            return $attributeValue;
        }
    }

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $exEntryID;

    /**
     * @Column(type="datetime")
     */
    protected $exEntryDateCreated;

    /**
     * @ManyToOne(targetEntity="Entity", inversedBy="entries")
     * @JoinColumn(name="exEntryEntityID", referencedColumnName="id")
     */
    protected $entity;

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    public function getID()
    {
        return $this->exEntryID;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @OneToMany(targetEntity="\Concrete\Core\Entity\Attribute\Value\ExpressValue", mappedBy="entry", cascade={"all"})
     * @JoinColumn(name="exEntryID", referencedColumnName="exEntryID")
     */
    protected $attributes;

    /**
     * @OneToMany(targetEntity="\Concrete\Core\Entity\Express\Entry\Association", mappedBy="entry", cascade={"all"})
     */
    protected $associations;

    /**
     * @return mixed
     */
    public function getAssociations()
    {
        return $this->associations;
    }

    /**
     * @param mixed $associations
     */
    public function setAssociations($associations)
    {
        $this->associations = $associations;
    }

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->associations = new ArrayCollection();
        $this->exEntryDateCreated = new \DateTime();
    }

    public function getLabel()
    {
        $firstAttribute = $this->getEntity()->getAttributes()[0];
        if (is_object($firstAttribute)) {
            return $this->getAttribute($firstAttribute);
        }
    }

    public function jsonSerialize()
    {
        $data = array(
            'exEntryID' => $this->getID(),
            'label' => $this->getLabel()
        );
        return $data;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->exEntryDateCreated;
    }

    /**
     * @param mixed $exEntryDateCreated
     */
    public function setDateCreated($exEntryDateCreated)
    {
        $this->exEntryDateCreated = $exEntryDateCreated;
    }


}
