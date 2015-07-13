<?php

namespace Troiswa\BackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QuantityProductCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('product:quantity')
            ->setDescription("Permet d'envoyer un mail des produits dont la quantité est inférieur à 5")
            ->addArgument('nombre', InputArgument::OPTIONAL, 'Nombre de produit?')
            ->addOption('message', '-m', InputOption::VALUE_NONE,
                'Si définie, un petit message apparaitra'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $nb=$input->getArgument("nombre");

        $option = $input->getOption("message");
        if ($option) {
            $output->writeln("<comment> Un autre message</comment>");
        }

        //dump($nb);
        //die();

        $templating = $this->getContainer()->get('templating');

        $products = $em->getRepository("TroiswaBackBundle:Product")->findProductByQuantity($nb);
        dump($products);

        $message = \Swift_Message::newInstance()
            ->setSubject('Feedback utilisateur')
            ->setTo('abdoulaye.camara1010@gmail.com')
            //->setBody("salt tu as des courriers chez moi ")
            ->setBody(
                $templating->render('TroiswaBackBundle:Mails:console-product-quabtity.html.twig', []), 'text/html'
            )
            ->addPart(
                $templating->render('TroiswaBackBundle:Mails:console-product-quabtity.txt.twig', []), 'text/plain'
            );
        $this->getContainer()->get('mailer')->send($message);
        $output->writeln("Bravo votre mail est envoyé");

    }
}