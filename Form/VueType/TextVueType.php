<?php

namespace Enhavo\Bundle\VueFormBundle\Form\VueType;

use Enhavo\Bundle\VueFormBundle\Form\VueData;
use Enhavo\Bundle\VueFormBundle\Form\VueTypeInterface;
use Symfony\Component\Form\FormView;

class TextVueType implements VueTypeInterface
{
    public function getComponent(): ?string
    {
        return 'form-simple';
    }

    public static function getBlocks(): array
    {
        return ['text' => 1];
    }

    public function buildView(FormView $view, VueData $data)
    {

    }
}
