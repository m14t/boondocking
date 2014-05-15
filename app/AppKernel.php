<?php

namespace Boondocking;

class AppKernel extends \Silex\Application
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->register(
            new \Igorw\Silex\ConfigServiceProvider(
                __DIR__ . '/config/config.json',
                array(
                    '__DIR__' => __DIR__,
                )
            )
        );

        foreach ($this['services'] as $classname => $opts) {
            if (isset($opt['constructorArguments'])) {
                $constructorArguments = $opts['constructorArguments'];
                $this->register(
                    new $classname($constructorArguments),
                    isset($opts['values']) ? $opts['values'] : array()
                );
            } else {
                $this->register(
                    new $classname(),
                    isset($opts['values']) ? $opts['values'] : array()
                );
            }
        }

        $this
            ->mount(
                '/api/locations',
                new \Boondocking\LocationBundle\Controller\Provider\LocationApiControllerProvider()
            )
        ;
    }
}
