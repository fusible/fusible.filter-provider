<?php
// @codingStandardsIgnoreFile

namespace Fusible\FilterProvider;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;
use Aura\Filter;

class Config extends ContainerConfig
{

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function define(Container $di)
    {
        $di->set(
            Filter\FilterFactory::class,
            $di->lazyNew(Filter\FilterFactory::class)
        );

        $di->params[Filter\SubjectFilter::class] = [
            'validate_spec' => $di->lazyGetCall(
                Filter\FilterFactory::class, 'newValidateSpec'
            ),
            'sanitize_spec' => $di->lazyGetCall(
               Filter\FilterFactory::class, 'newSanitizeSpec'
            ),
            'failures' => $di->lazyGetCall(
                Filter\FilterFactory::class, 'newFailureCollection'
            )
        ];
    }
}
