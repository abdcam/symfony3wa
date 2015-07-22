<?php

namespace Troiswa\BackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Troiswa\BackBundle\Entity\User;

class TroiswaCreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        // php app/console troiswa:user:create --help
        //tout ce qui sont en dessous sont saisi dans le console
        $this
            ->setName("troiswa:user:create")
            ->setDescription("Création des utilisateurs")
            ->addArgument('login', InputArgument::REQUIRED, 'Entrer le login')
            ->addArgument('password', InputArgument::REQUIRED, 'Entrer votre mot de pass')
            ->addArgument('email', InputArgument::REQUIRED, 'Entrer votre email')
            //->addOption('message', '-m', InputOption::VALUE_NONE,
            // 'Si définie, un petit message apparaitra')

            ->addOption('existe', null, InputOption::VALUE_NONE, 'Metre à jour un utilisateur');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $factory = $this->getContainer()->get('security.encoder_factory');

        $style = new OutputFormatterStyle('yellow', 'red', ['bold', 'blink']);
        $output->getFormatter()->setStyle('fire', $style);

        $option = $input->getOption('existe');

        if ($option) {
            $utilisateur = $em->getRepository('TroiswaBackBundle:$utilisateur')
                ->findOneBy(['pseudo' => $input->getArgument('pseudo')]);

            /*
            $utilisateur = $em->getRepository('TroiswaBackBundle:utilisateur')
              ->findOneByPseudo($input->getArgument('pseudo'));
          */

            if ($utilisateur) {
                $encoder = $factory->getEncoder($utilisateur);
                $newPassword = $encoder->encodePassword($input->getArgument('password'), $utilisateur->getSalt());
                $utilisateur->setPassword($newPassword);
                $em->persist($utilisateur);
                $em->flush();
                $output->writeln("<info>L'utilisateur " . $input->getArgument('pseudo') . " a bien été mis à jour</info>");
            } else {
                $output->writeln("<fire>L'utilisateur " . $input->getArgument('pseudo') . " n'existe pas</fire>");
            }

        } else {
            $utilisateur = new User();

            $encoder = $factory->getEncoder($utilisateur);
            $newPassword = $encoder->encodePassword($input->getArgument('password'), $utilisateur->getSalt());

            $loginArgument = $input->getArgument("login");
            $passwordArgument = $input->getArgument("password");

            $utilisateur = new User();
            $utilisateur->setPrenom('Totoprem')
                        ->setnom('Nama')
                        //->setEmail('cranouha@yahoo.fr')
                        ->setBirthday(new \DateTime('now'))
                        ->setTelephone('0606060606')
                        ->setAdresse('10,rue de 3wa')
                        ->setPseudo($loginArgument)
                        ->setPassword($newPassword)
                        ->setUsername('totousername');

            $em->persist($utilisateur);
            $em->flush();

            $output->writeln("<fire> L'utilisateur a bien été créé </fire>");
        }
    }
}

// voir doc: http://symfony.com/fr/doc/2.7/components/console/introduction.html#creer-une-commande-basique