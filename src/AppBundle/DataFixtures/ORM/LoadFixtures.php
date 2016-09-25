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
class LoadFixtures extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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

    const NAMES = [
        'Luna', 'Bushy', 'Izzy', 'Cleo', 'Jess', 'Kitty', 'Herbie', 'Bella', 'Lucy', 'Tiger', 'Leo', 'Sophie',
        'Charlie', 'Smokey', 'Max', 'Oliver', 'Cheeky', 'Serge', 'Kathia', 'Alvin', 'Freddie', 'Juan', 'Angel'
    ];

    public function load(ObjectManager $manager)
    {
        $this->loadFOSUsers($manager);
        $this->loadBreeds($manager);
        $this->loadKitties($manager);

    }

    public function getOrder()
    {
        return 1;
    }

    private function loadFOSUsers(ObjectManager $manager)
    {

        $userManager = $this->container->get('fos_user.user_manager');

        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setPlainPassword('admin');
        $admin->setEmail('admin@kittyonline.net');
        $admin->setEnabled(true);
        $admin->setRoles(array('ROLE_ADMIN'));

        $user = $userManager->createUser();
        $user->setUsername('user');
        $user->setPlainPassword('user');
        $user->setEmail('user@kittyonline.net');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));

        // Update the users
        $userManager->updateUser($user, true);
        $userManager->updateUser($admin, true);

        $this->addReference('user-0', $user);
        $this->addReference('user-1', $admin);

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

    private function loadKitties(ObjectManager $manager)
    {

        $max_breeds = max(array_keys(SELF::BREEDS));
        $max_names = max(array_keys(SELF::NAMES));

        for ($i = 0; $i < 2000; $i++) {

            $newKitty = new Kitty();
            $newKitty->setName(ucfirst(SELF::NAMES[rand(0, $max_names)]));
            $newKitty->setBio($this->getPostContent());
            $newKitty->setBreed($this->getReference('breed-' . rand(0, $max_breeds)));
            $newKitty->setBirthday(new \DateTime('now - ' . $i . 'days'));
            $newKitty->setOwner($this->getReference('user-' . rand(0, 1)));

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

    private function getPhrases()
    {
        return array(
            'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'Pellentesque vitae velit ex',
            'Mauris dapibus risus quis suscipit vulputate',
            'Eros diam egestas libero eu vulputate risus',
            'In hac habitasse platea dictumst',
            'Morbi tempus commodo mattis',
            'Ut suscipit posuere justo at vulputate',
            'Ut eleifend mauris et risus ultrices egestas',
            'Aliquam sodales odio id eleifend tristique',
            'Urna nisl sollicitudin id varius orci quam id turpis',
            'Nulla porta lobortis ligula vel egestas',
            'Curabitur aliquam euismod dolor non ornare',
            'Sed varius a risus eget aliquam',
            'Nunc viverra elit ac laoreet suscipit',
            'Pellentesque et sapien pulvinar consectetur',
        );
    }

    private function getRandomPostTitle()
    {
        $titles = $this->getPhrases();
        return $titles[array_rand($titles)];
    }

    private function getRandomPostSummary()
    {
        $phrases = $this->getPhrases();
        $numPhrases = rand(6, 12);
        shuffle($phrases);
        return implode(' ', array_slice($phrases, 0, $numPhrases - 1));
    }

    private function getRandomCommentContent()
    {
        $phrases = $this->getPhrases();
        $numPhrases = rand(2, 15);
        shuffle($phrases);
        return implode(' ', array_slice($phrases, 0, $numPhrases - 1));
    }
}