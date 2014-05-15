<?php

namespace Boondocking\LocationBundle\Controller\Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;

class LocationApiControllerProvider implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers
           ->get(
               '/',
               'Boondocking\LocationBundle\Controller\LocationApiController::collectionGetAction'
           )
           ->bind('api.location.collection.get')
        ;

        return $controllers;
    }
}
