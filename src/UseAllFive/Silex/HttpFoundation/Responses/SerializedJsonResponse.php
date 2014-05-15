<?php

namespace UseAllFive\Silex\HttpFoundation\Responses;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class SerializedJsonResponse extends Response
{
    /**
     * @inheritdoc
     */
    public function __construct(Application $app, $content = '', $status = 200, $headers = array())
    {
        return parent::__construct(
            $app['serializer']->serialize($content, 'json'),
            $status,
            array_merge(
                array(
                    'Content-Type' => $app['request']->getMimeType('json')
                ),
                $headers
            )
        );
    }
}
