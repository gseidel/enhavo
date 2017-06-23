<?php
/**
 * CompositeLocaleContext.php
 *
 * @since 23/06/17
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\Locale;


use Sylius\Component\Locale\Context\LocaleContextInterface;

class LocaleContext implements LocaleContextInterface
{
    public function getLocaleCode()
    {
        return 'de';
    }
}