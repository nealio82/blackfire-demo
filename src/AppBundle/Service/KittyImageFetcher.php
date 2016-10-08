<?php

namespace AppBundle\Service;

/**
 * Created by PhpStorm.
 * User: neal
 * Date: 08/10/2016
 * Time: 14:43
 */
class KittyImageFetcher
{

    private $apiQuery;
    private $apiRequest;

    public function __construct($apiKey, $searchKey, $apiQuery, $apiRequest)
    {
        $this->apiQuery = $apiQuery;
        $this->apiRequest = $apiRequest;

        $this->apiQuery->set('key', $apiKey);
        $this->apiQuery->set('cx', $searchKey);

    }

    public function getImageForBreed($breedName)
    {

        if (false === $data = $this->cache->fetch(md5($breedName))) {

            $this->apiQuery->set('searchType', 'image');
            $this->apiQuery->set('start', 1);

            $this->apiQuery->set('q', $breedName . ' cat');

            $this->apiRequest->setQuery($this->apiQuery);

            $response = $this->apiRequest->getResponse();

            $data = $response->getResults()[0]->getLink();

            // store in cache for 15 minutes.
            $this->cache->save(md5($breedName), $data, 900);
        }

        return $data;

    }

}