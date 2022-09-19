<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

use \App\Entity\Proverb;


class ProverbLastCommand extends Command
{
    protected static $defaultName = 'app:proverb:last';
    protected static $defaultDescription = 'Add a short description for your command';
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('limit', InputArgument::OPTIONAL, 'Nombre limite de proverbes à affichier')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = null;
        $io = new SymfonyStyle($input, $output);
        $limit = $input->getArgument('limit');

    
        $repo = $this->em->getRepository(Proverb::class);
        $proverbs = $repo->findBy([], [], $limit);

        foreach($proverbs as $proverb) {
            $io->writeln($proverb->getBody());
        }

        return Command::SUCCESS;
    }
}
