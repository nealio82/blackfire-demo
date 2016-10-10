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
class LoadKitties extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    const NAMES = [
        'Luna', 'Bushy', 'Izzy', 'Cleo', 'Jess', 'Kitty', 'Herbie', 'Bella', 'Lucy', 'Tiger', 'Leo', 'Sophie',
        'Charlie', 'Smokey', 'Max', 'Oliver', 'Cheeky', 'Serge', 'Kathia', 'Alvin', 'Freddie', 'Juan', 'Angel',
        'Purr Lancelot', 'Snowball', 'Snowball II', 'Snowball III', 'Snowball IV', 'Snowball V', 'Snarf', 'Frankie',
        'Ossie', 'Pedro Sanchez', 'Mr Bigglesworth', 'Grumpy Cat', 'The cat from Spain', 'The cat from Greece',
        'The cat from Norway', 'The cat from France', 'The cat from Brazil', 'The cat from Berlin', 'The cat from Japan',
        'Spotty', 'Azrael', 'Cat Stevens', 'James', 'Kevin', 'Terry', 'Tim', 'Bruce', 'Eric', 'Bert', 'Howard', 'Trevor',
        'Gertrude', 'Mick', 'Andrew', 'Bob', 'Mr Tinkles', 'Slinki Malinki', 'Scar Face Claw', 'Mog', 'Six Dinner Sid',
        'Astrocat', 'Kuli the surfing cat from Honolulu', 'Tab', 'Monty', 'The Magical Mr. Mistoffelees',
        'Professor Henry Higgins', 'Neighbour Cat', 'Nyan Cat', 'Tommy The Cat', 'Cole', 'Marmalade', 'Pilchard',
        'Stripes', 'Puss In Boots', 'Puss', 'Mr Meowgi', 'Professor Catface', 'Felix', 'Garfield', 'Tom',
        'Sylvester', 'Top Cat', 'Islay', 'Jura', 'Sammo', 'Gladstone', 'Palmerstone', 'Smelly Cat', 'Pussy Galore',
        "Mrs Slocombe's Pussy", 'Bagheera', 'Simba', 'Nala', 'Tigger', 'Mittens', 'Chairman Meow', 'Fidel Catstro',
        'The Great Catsby', 'Catzilla', 'Orion', 'Scratchy', 'Salem', 'Mrs Whiskerson', 'Grisabella', 'Pink Panther',
        'Cheshire Cat', 'The cat in the hat', 'Cosmic Creepers', 'Benny', 'Cosmo', 'Jonesy', 'Catwoman', 'Catman',
        'Sassy the cat', 'Mr Jinx', 'Crookshanks', 'Isis', 'Binx', 'Felix', 'Lucifer', 'Cat', 'Mufasa', 'Clarence',
        'Shere Khan', 'Raj', 'Frankenstein', 'Figaro', 'Prince John', 'Scat Cat', 'Cat Baloo', 'Ginger', 'Fluffy',
        'Spinx', 'Hercules', 'Perseus', 'Fluff', 'Zoe'
    ];

    public function load(ObjectManager $manager)
    {
        $this->loadKitties($manager);

    }

    public function getOrder()
    {
        return 3;
    }


    private function loadKitties(ObjectManager $manager)
    {

        $max_breeds = max(array_keys(LoadBreeds::BREEDS));
        $max_names = max(array_keys(SELF::NAMES));
        $max_kitties = rand(4000, 8000);

        for ($i = 0; $i < $max_kitties; $i++) {

            $newKitty = new Kitty();
            $newKitty->setName(ucfirst(SELF::NAMES[rand(0, $max_names)]));
            $newKitty->setBio($this->getPostContent());
            $newKitty->setBreed($this->getReference('breed-' . rand(0, $max_breeds)));
            $newKitty->setBirthday(new \DateTime('now - ' . $i . 'days'));
            $newKitty->setOwner($this->getReference('user-' . rand(0, 10)));

            $manager->persist($newKitty);

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