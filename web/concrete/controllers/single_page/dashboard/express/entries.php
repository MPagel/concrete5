<?php
namespace Concrete\Controller\SinglePage\Dashboard\Express;

use Concrete\Controller\Element\Dashboard\Express\Entries\Header;
use Concrete\Core\Entity\Express\Entity;
use Concrete\Core\Entity\Express\Entry;
use Concrete\Core\Express\EntryList;
use Concrete\Core\Page\Controller\DashboardExpressEntityPageController;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Search\Result\Result;
use Concrete\Core\Tree\Node\Node;

class Entries extends DashboardExpressEntityPageController
{

    /**
     * @var $entity Entity
     */
    protected $entity;

    public function getEntity()
    {
        return $this->entity;
    }

    protected function getBackToListURL(Entity $entity)
    {
        return \URL::to($this->getPageObject()
            ->getCollectionPath(), 'view', $entity->getID(),
            $entity->getEntityResultsNodeID());
    }


    public function view($entity = null, $folder = null)
    {
        $r = $this->entityManager->getRepository('\Concrete\Core\Entity\Express\Entity');
        if ($entity) {
            $entity = $r->findOneById($entity);
        }
        if (isset($entity) && is_object($entity)) {
            $this->entity = $entity;
            $this->set('entity', $entity);
            $this->renderList($folder);
            $header = new Header($entity, $this->getPageObject());
            $this->set('headerMenu', $header);
        } else {
            $this->set('entities', $r->findByIncludeInPublicList(true));
        }
    }


}
