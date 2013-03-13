<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace BjyAuthorize\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory responsible of a set of {@see \BjyAuthorize\Provider\Resource\ProviderInterface}
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class ResourceProvidersServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \BjyAuthorize\Provider\Resource\ProviderInterface[]
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config    = $serviceLocator->get('BjyAuthorize\Config');
        $providers = array();

        foreach ($config['resource_providers'] as $providerName => $providerConfig) {
            if ($serviceLocator->has($providerName)) {
                $providers[] = $serviceLocator->get($providerName);
            } else {
                $providers[] = new $providerName($providerConfig, $serviceLocator);
            }
        }

        return $providers;
    }
}
