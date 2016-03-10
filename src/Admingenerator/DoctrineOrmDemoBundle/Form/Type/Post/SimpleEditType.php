<?php

namespace Admingenerator\DoctrineOrmDemoBundle\Form\Type\Post;

use Admingenerator\GeneratorBundle\Form\BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SimpleEditType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder->add('title', $this->getTypeTitle(), $this->getOptionsTitle($options));
    }

    /**
     * Get form type for title field.
     *
     * @return string|FormTypeInterface Field form type.
     */
    protected function getTypeTitle()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\TextType';
    }

    /**
     * Get options for title field.
     *
     * @param  array $builderOptions The builder options.
     * @return array Field options.
     */
    protected function getOptionsTitle(array $builderOptions = array())
    {
        $optionsClass = 'Admingenerator\DoctrineOrmDemoBundle\Form\Type\Post\Options';
        $options = class_exists($optionsClass) ? new $optionsClass() : null;

        return $this->resolveOptions('title', array(  'label' => 'Title',  'translation_domain' => 'AdmingeneratorOrmDemoBundle',  'required' => true,), $builderOptions, $options);
    }

    public function getBlockPrefix()
    {
        return 'simpleedit_doctrineormdemobundle_post';
    }
}
