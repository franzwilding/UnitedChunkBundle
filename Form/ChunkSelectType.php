<?php

namespace United\ChunkBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ChunkSelectType extends AbstractType
{

    private $chunks;

    public function __construct($chunks)
    {
        $this->chunks = $chunks;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $values = array();
        $builder->add('sort', 'united_sort');

        foreach($this->chunks as $key => $chunk) {

            $parts = explode('\\', get_class($chunk));
            $label = array_pop($parts);
            if(substr($label, -4, 4) == 'Type') {
                $label = substr($label, 0, -4);
            }

            if(substr($label, -5, 5) == 'Chunk') {
                $label = substr($label, 0, -5);
            }

            $values[$key] = 'united.chunk.' . strtolower($label);
        }

        $builder->add('chunk', 'choice', array(
            'multiple' => false,
            'expanded' => true,
            'required' => true,
            'choices'  => $values,
            'attr'     => array(
                'data-chunk-select' => true,
            )
        ));

        foreach($this->chunks as $key => $chunk) {
            $builder->add('chunk_' . $key, $chunk, array(
                'attr' => array(
                    'data-chunk-chunk' => true,
                    'data-chunk-id' => $key,
                ),
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['data-chunk'] = true;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'united_chunk_select';
    }
}