<?php

namespace Boondocking\LocationBundle\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Exception;
use UseAllFive\Silex\HttpFoundation\Responses\SerializedJsonResponse;

class LocationApiController
{
    public function collectionGetAction(Request $request, Application $app)
    {
        $locationsArray = $this->readCsvFile($app['boondocking']['dataFile']);

        //-- FIXME: Find a better way to do this
        $json = $app['serializer']->serialize($locationsArray, 'json');

        return new SerializedJsonResponse($app, $json);
    }

    public function readCsvFile($filename)
    {
        $fp = fopen($filename, 'r');
        if (false === $fp) {
            throw new \Exception('Error opening: '. $filename);
        }

        //-- Get the first row since it's the header
        $header = array_map(
            'trim',
            fgetcsv($fp, 0, ',', '"', '"')
        );

        //-- Read the rest of the data
        $data = array();
        while (!feof($fp)) {
            $row = fgetcsv($fp, 0, ',', '"', '"');
            if (false === $row) {
                break;
            }
            $row = array_map('trim', $row);
            $data[] = array_combine($header, $row);
        }

        fclose($fp);

        return $data;
    }
}
