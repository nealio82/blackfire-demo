<?php

namespace AppBundle\Twig;

use Doctrine\Bundle\DoctrineBundle\Registry;

class StatsExtension extends \Twig_Extension
{
    private $stats;

    public function __construct(Registry $doctrine)
    {

        $this->stats = array(
            'kitties' => count($doctrine->getRepository('AppBundle:Kitty')->findAll()),
            'breeds' => count($doctrine->getRepository('AppBundle:Breed')->findAll()),
        );

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
        return $this->stats['kitties'];
    }

    public function getBreedsCountStats()
    {
        return $this->stats['breeds'];
    }

    public function getName()
    {
        return 'app.stats_extension';
    }
}
