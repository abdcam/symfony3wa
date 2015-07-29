<?php
// documentation : http://symfony.com/doc/current/components/http_kernel/introduction.html
// Rechercher KernelEvents::REQUEST
namespace Troiswa\FrontBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


class MaintenanceListener
{
    private $maintenance;

    public function __construct($paramMaintenance,\Twig_Environment $twig)
    {
        $this->maintenance = $paramMaintenance;
        $this->twig = $twig;
    }


    public function onMaintenance(GetResponseEvent $event)
    {
       // dump($this->maintenance);
       // die;
        if($this->maintenance == true) {
            $content = $this->twig->render('TroiswaFrontBundle:Maintenance:index.html.twig');
            $event->setResponse(new Response($content, 503));
            $event->stopPropagation();
        }

    }

}