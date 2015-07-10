<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Troiswa\BackBundle\Form\ContactType;

class StaticsController extends Controller
{
    public function cgvAction()
        {
           //die("ok");
            //return new Response("hello");
            return $this->render("TroiswaBackBundle:Main:statics.html.twig",["firstname"=>"Abdoul",
            "age"=>29, "lastname"=>"Camara"]);
        }

    public function trainingAction($chaine)
        {
            echo $chaine;

            die('ok');
        }

    public function layoutAction()
        {
        return $this->render("TroiswaBackBundle:static:heritage.html.twig");
        }
    public function OtherlayoutAction()
        {
            return $this->render("TroiswaBackBundle::test_templeting.html.twig");
        }
    //Request=requte et une variablen $request
    public function contactAction(Request $request)
    {
      // externalise le formulaire:contactType qui se trouve dans un notre à l'extérieur
        $formcontact = $this->createForm(new ContactType(),null, [
            "attr"=>["novalidate"=>"novalidate"]
        ]);
    // null: annul le terme de novalide pour annuler html5
        /*if($request->isMethod("POST"))
        {
            $formcontact->submit($request);
            if($formcontact->isValid())
            {
                $data=$formcontact->getData();
                dump($data);
                die();
            }
        } ce qui est en cmtaire egal à clui dessus */

        $formcontact->handleRequest($request);
        if ($formcontact->isValid())
        {
            $data = $formcontact->getData();
            //dump($data);
            //die();
// envoie de mail
            $message = \Swift_Message::newInstance()
                ->setSubject($data['sujet'])
                ->setFrom($data['email'])
                ->setTo('abdoulaye.camara1010@gmail.com')
                //->setBody("salt tu as des courriers chez moi ")
                ->setBody(
                    $this->renderView('TroiswaBackBundle:Mails:contact-email.html.twig', []), 'text/html'
                )
                ->addPart(
                    $this->renderView('TroiswaBackBundle:Mails:contact-email.txt.twig', []), 'text/plain'
                );

            // setBody enverra le message sous forme HTML
            // addPart enverra le message sous forme txt

            $this->get('mailer')->send($message);
            //die('ok');
            //dump($this->renderView(" mon msg"));

            $this->get("session")->getFlashBag()->add("success","votre mail été bien envoyé");

            return $this->redirectToRoute("trois_back_contact");
        }

        return $this->render("TroiswaBackBundle:Main:contact.html.twig", ["formcontact"=>$formcontact->createView()]);
    }

  /******  method envoi de feedback  */
    public function feedbackAction(Request $request)
    {
        $formcontactFeedBack = $this->createFormBuilder(null, ["attr" => ["novalidate" => "novalidate"]])
            ->add("Prenom", "text",
                [
                    "constraints" => [new Assert\NotBlank(["message"=>"Le Prenom ne doit pas etre vide"]), new Assert\Length(
                        array(
                            "min" => 2,
                            "max" => 2,
                            "minMessage" => "Votre nom doit faire au moins {{ limit }} caractères",
                            "maxMessage" => "Votre nom ne peut pas être plus long que {{ limit }} caractères"
                        )
                    )]
                ]
            )
            ->add("Nom", "text",
                [
                    "constraints" => new Assert\Length(array("max" => 5))
                ]
            )
            ->add("email", "email",
                [
                    "constraints" =>[new Assert\NotBlank(["message"=>"Le nom n edoit pas etre vide"]), new Assert\Email(array(
                        'message' => "'{{ value }}' n'est pas un email valide.",
                        'checkMX' => true,
                        )
                    )]
                ]
            )
            ->add("statut", "choice",
                [
                    "choices" => ["bug affichage", "bug fonctionnel", "rien ne marche","required"],
                    'expanded' => true
                ]
            )
            ->add("Description", "textarea",
                [
                    "constraints" =>[new Assert\NotBlank(["message"=>"La description n edoit pas etre vide"]), new Assert\Length(array("min" => 1, "max" => 50))]
                ]
            )
            ->add("date_bug", 'text')
            ->add("send", "submit")

            ->getForm();

        /*if($request->isMethod("POST"))
        {
            $formcontact->submit($request);
            if($formcontact->isValid())
            {
                $data=$formcontact->getData();
                dump($data);$formcontactFeedBack
                die();
            }
        } ce qui est en cmtaire egal à clui dessus */

        $formcontactFeedBack->handleRequest($request);
        if ($formcontactFeedBack->isValid())
        {
            // Traitement du formulaire valide
            $data = $formcontactFeedBack->getData();
            //dump($data);
            //die;

            $message = \Swift_Message::newInstance()
                ->setSubject('Feedback utilisateur')
                ->setFrom($data['email'])
                ->setTo('abdoulaye.camara1010@gmail.com')
                //->setBody("salt tu as des courriers chez moi ")
                ->setBody(
                    $this->renderView('TroiswaBackBundle:Mails:feedback.html.twig', []), 'text/html'
                )
                ->addPart(
                    $this->renderView('TroiswaBackBundle:Mails:feedback.txt.twig', []), 'text/plain'
                );

            // setBody enverra le message sous forme HTML
            // addPart enverra le message sous forme txt

            $this->get('mailer')->send($message);
                //die('ok');
                //dump($this->renderView(" mon msg"));

            $this->get("session")->getFlashBag()->add("success","votre feedback été bien envoyé");

            return $this->redirectToRoute("trois_back_feedback");
        }
        return $this->render("TroiswaBackBundle:Main:feedback.html.twig", ["formcontactFeedback"=>$formcontactFeedBack->createView()]);

    }
}




















/*
- Tous les champs ne doivent pas être vide
- Le prénom doit faire 2 caractères minimum
- Le nom doit faire 5 caractères minimum
- Le contenu doit faire 500 caractères maximum
- L'email doit être un email valide
- Le sujet doit être un sujet valide (compris dans les choix proposés) */