<?php

namespace AppBundle\Twig;

use Doctrine\Bundle\DoctrineBundle\Registry;

class StatsExtension extends \Twig_Extension
{
    private $stats;
    /**
     * @var Registry
     */
    private $doctrine;

    public function __construct(Registry $doctrine)
    {

        $this->doctrine = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('stats_kitties_count', array($this, 'getKittiesCountStats'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('stats_breeds_count', array($this, 'getBreedsCountStats'), array('is_safe' => array('html'))),
        );
    }

    public function getKittiesCountStats()
    {
        return $this->doctrine->getRepository('AppBundle:Kitty')->countKitties();
    }

    public function getBreedsCountStats()
    {
        return $this->doctrine->getRepository('AppBundle:Breed')->countBreeds();
    }

    public function getName()
    {
        return 'app.stats_extension';
    }
}
