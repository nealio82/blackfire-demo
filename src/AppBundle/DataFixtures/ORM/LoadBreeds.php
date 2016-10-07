<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Breed;
use AppBundle\Entity\Kitty;
use AppBundle\Entity\User;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the sample data to load in the database when running the unit and
 * functional tests. Execute this command to load the data:
 *
 *   $ php app/console doctrine:fixtures:load
 *
 * See http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class LoadBreeds extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    const BREEDS = [
        'Abyssinian',
        'Aegean',
        'American Curl',
        'American Bobtail',
        'American Shorthair',
        'American Wirehair',
        'Arabian Mau',
        'Australian Mist',
        'Asian',
        'Asian Semi-longhair',
        'Balinese',
        'Bambino',
        'Bengal',
        'Birman',
        'Bombay',
        'Brazilian Shorthair',
        'British Semi-longhair',
        'British Shorthair',
        'British Longhair',
        'Burmese',
        'Burmilla',
        'California Spangled',
        'Chantilly-Tiffany',
        'Chartreux',
        'Chausie',
        'Cheetoh',
        'Colorpoint Shorthair',
        'Cornish Rex',
        'Cymric',
        'Cyprus',
        'Devon Rex',
        'Donskoy',
        'Dragon Li',
        'Dwarf cat',
        'Egyptian Mau',
        'European Shorthair',
        'Exotic Shorthair',
        'Foldex',
        'German Rex',
        'Havana Brown',
        'Highlander',
        'Himalayan',
        'Japanese Bobtail',
        'Javanese',
        'Kurilian Bobtail',
        'Khao Manee',
        'Korat',
        'Korean Bobtail',
        'Korn Ja',
        'Kurilian Bobtail',
        'LaPerm',
        'Lykoi',
        'Maine Coon',
        'Manx',
        'Mekong Bobtail',
        'Minskin',
        'Munchkin',
        'Nebelung',
        'Napoleon',
        'Norwegian Forest cat',
        'Ocicat',
        'Ojos Azules',
        'Oregon Rex',
        'Oriental Bicolor',
        'Oriental Shorthair',
        'Oriental Longhair',
        'Persian (Modern Persian Cat)',
        'Persian (Traditional Persian Cat)',
        'Peterbald',
        'Pixie-bob',
        'Raas',
        'Ragamuffin',
        'Ragdoll',
        'Russian Blue',
        'Russian White, Black and Tabby',
        'Sam Sawet',
        'Savannah',
        'Scottish Fold',
        'Selkirk Rex',
        'Serengeti',
        'Serrade petit',
        'Siamese',
        'Siberian',
        'Singapura',
        'Snowshoe',
        'Sokoke',
        'Somali',
        'Sphynx',
        'Suphalak',
        'Thai',
        'Thai Lilac',
        'Tonkinese',
        'Toyger',
        'Turkish Angora',
        'Turkish Van',
        'Ukrainian Levkoy',
    ];


    public function load(ObjectManager $manager)
    {
        $this->loadBreeds($manager);

    }

    public function getOrder()
    {
        return 2;
    }


    private function loadBreeds(ObjectManager $manager)
    {

        for ($i = 0; $i < count(SELF::BREEDS); $i++) {

            $breed = SELF::BREEDS[$i];

            $newBreed = new Breed();
            $newBreed->setName($breed);
            $newBreed->setCharacteristics($this->getPostContent());
            $manager->persist($newBreed);

            $this->addReference('breed-' . $i, $newBreed);
        }

        $manager->flush();

    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    private function getPostContent()
    {
        return <<<MARKDOWN
Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor
incididunt ut labore et **dolore magna aliqua**: Duis aute irure dolor in
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
deserunt mollit anim id est laborum.
  * Ut enim ad minim veniam
  * Quis nostrud exercitation *ullamco laboris*
  * Nisi ut aliquip ex ea commodo consequat
Praesent id fermentum lorem. Ut est lorem, fringilla at accumsan nec, euismod at
nunc. Aenean mattis sollicitudin mattis. Nullam pulvinar vestibulum bibendum.
MARKDOWN;
    }


}