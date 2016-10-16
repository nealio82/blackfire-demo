<?php

namespace AppBundle\Service;

use Doctrine\Common\Cache\Cache;

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
    /**
     * @var Cache
     */
    private $cache;

    public function __construct($apiKey, $searchKey, $apiQuery, $apiRequest, Cache $cache)
    {
        $this->apiQuery = $apiQuery;
        $this->apiRequest = $apiRequest;

        $this->apiQuery->set('key', $apiKey);
        $this->apiQuery->set('cx', $searchKey);

        $this->cache = $cache;
    }

    public function getImageForBreed($breedName)
    {

        if (false === $data = $this->cache->fetch(md5($breedName))) {

            $this->apiQuery->set('searchType', 'image');
            $this->apiQuery->set('start', 1);

            $this->apiQuery->set('q', $breedName . ' cat');

            $this->apiRequest->setQuery($this->apiQuery);

            $data = $this->apiRequest->getResponse();

            $this->cache->save(md5($breedName), $data, 3600);
        }

        return $data->getResults()[0]->getLink();

    }

}