<?php

namespace AppBundle\Command;

use AppBundle\Entity\Kitty;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrintKittyStatsCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('kittyonline:printkittystats')
            ->setDescription('shows some stats about the cats')
            ->setHelp('This command shows some catty stats');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');

        foreach ($doctrine->getRepository(Kitty::class)->findAll() AS $kitty) {

            $output->writeln($kitty->getName() . " the " . $kitty->getBreed()->getName() . " cat");

        }

        $output->writeln(count($doctrine->getRepository(Kitty::class)->findAll()) . " kitties in the database");

    }

}