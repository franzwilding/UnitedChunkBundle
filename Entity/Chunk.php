<?php

namespace United\ChunkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use United\CoreBundle\Model\EntityInterface;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\Table(name="chunk")
 * @ORM\DiscriminatorColumn(name="chunk", type="string")
 */
abstract class Chunk implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sort;

    public function __construct() {
        $this->sort = 0;
    }

    /**
     * @param integer $sort
     * @return Chunk
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }
}