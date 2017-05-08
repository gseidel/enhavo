<?php

/**
 * TranslationLocaleProvider.php
 *
 * @since 15/08/16
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\Provider;

use Sylius\Component\Locale\Provider\LocaleProviderInterface;

class TranslationLocaleProvider implements LocaleProviderInterface
{
    private $locale;

    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string[]
     */
    public function getAvailableLocalesCodes()
    {
        return [$this->locale];
    }

    /**
     * @return string
     */
    public function getDefaultLocaleCode()
    {
        return $this->locale;
    }
}