<?php

namespace United\ChunkBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use United\ChunkBundle\Form\DataTransformer\ChunkPolyCollectionTransformer;
use United\ChunkBundle\Form\EventListener\ChunkCollectionResizeFormListener;

class ChunkCollectionType extends CollectionType
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new ChunkCollectionResizeFormListener($this->entityManager, $options['allow_delete']));
        $builder->addModelTransformer(new ChunkPolyCollectionTransformer($options));
        parent::buildForm($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $typeNormalizer = function (Options $options) {
            return new ChunkSelectType($options['chunks']);
        };

        $resolver->setDefaults(array(
          'chunks' => array(),
        ));

        $resolver->setNormalizers(array(
          'type' => $typeNormalizer,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'united_chunk_collection';
    }

    public function getParent()
    {
        return 'collection';
    }
}