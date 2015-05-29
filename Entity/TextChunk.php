<?php

namespace United\ChunkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="chunk_text")
 */
class TextChunk extends Chunk
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $text;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->text;
    }

    /**
     * @return integer|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return TextChunk
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param $text
     * @return TextChunk
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
}