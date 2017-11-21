<?php
// @codingStandardsIgnoreFile

namespace Fusible\FilterProvider;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;
use Aura\Filter;

class Config extends ContainerConfig
{
    const FACTORY = Filter\FilterFactory::class;

    const VALIDATE_FACTORIES = self::class . '::VALIDATE_FACTORIES';
    const SANITIZE_FACTORIES = self::class . '::SANITIZE_FACTORIES';

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function define(Container $di)
    {
        $specs = [self::VALIDATE_FACTORIES, self::SANITIZE_FACTORIES];
        foreach ($specs as $spec) {
            isset($di->values[$spec]) || $di->values[$spec] = [];
        }

        $di->set(
            self::FACTORY,
            $di->lazyNew(
                Filter\FilterFactory::class,
                [
                    'validate_factories' => $di->lazyValue(self::VALIDATE_FACTORIES),
                    'sanitize_factories' => $di->lazyValue(self::SANITIZE_FACTORIES),
                ]
            )
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
