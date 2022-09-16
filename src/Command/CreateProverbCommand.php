<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Doctrine\ORM\EntityManagerInterface;

use \App\Entity\Proverb;


class CreateProverbCommand extends Command
{
    protected static $defaultName = 'app:proverb:create';
    protected static $defaultDescription = 'Enregistre un proverb en db';
    private $em;

    private $proverbs = [
        "proverb 1",
        "Un tiens vaut mieux que deux tu l'auras",
        "proverb 3"
    ];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct(); // invocation du constructeur parent
    }
    
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Corps du proverbe')
            ->addOption('populate', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1'); // body du proverbe

        if ($arg1) {
            //$io->note(sprintf('You passed an argument: %s', $arg1));
            $proverb = new Proverb();
            $proverb->setBody($arg1);
            $this->em->persist($proverb);
            $this->em->flush();

            $io->success('Proverbe ID ' . $proverb->getId() . ' enregistré :-))');
            return Command::SUCCESS;
        } 
        // else {
        //     $io->error("Body du proverbe non fourni :-((");
        //     return Command::FAILURE;
        // }

        if ($input->getOption('populate')) {
            //$io->note('option1 fournie');
            foreach($this->proverbs as $p) {
                $proverb = new Proverb();
                $proverb->setBody($p);
                $this->em->persist($proverb);
                $this->em->flush();
            }

            $io->success('Table proverb alimentée :-)');
            return Command::SUCCESS;
        }


    }
}
