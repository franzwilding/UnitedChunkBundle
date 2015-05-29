<?php

namespace United\ChunkBundle\Form\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use United\ChunkBundle\Entity\Chunk;

class ChunkCollectionResizeFormListener implements EventSubscriberInterface
{
    private $entityManager;
    private $allowDelete;
    private $original_ids;

    public function __construct(EntityManager $entityManager, $allowDelete = false)
    {
        $this->entityManager = $entityManager;
        $this->allowDelete = $allowDelete;
        $this->original_ids = array();
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
          FormEvents::POST_SUBMIT => 'postSubmit',
          FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }

    public function preSetData(FormEvent $event) {

        if($this->allowDelete) {

            /**
             * @var Chunk[] $data
             */
            $data = $event->getData();
            foreach ($data as $entity) {
                if ($id = $entity->getId()) {
                    $this->original_ids[$id] = $entity;
                }
            }
        }
    }

    public function postSubmit(FormEvent $event) {

        if($this->allowDelete) {
            $data = $event->getData();

            foreach ($data as $row) {
                $id = $row['chunk_'.$row['chunk']]->getId();
                $this->original_ids[$id] = false;
            }

            foreach ($this->original_ids as $entity) {
                if ($entity) {
                    $this->entityManager->remove($entity);
                }
            }
        }
    }
}