<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Entity\Membre;
use AppBundle\Form\MembreType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MembreController extends Controller
{
    /**
     * @Route("/membre/inscription/", name="membre_inscription")
     */
    public function inscriptionMembreAction(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $membre = new Membre;

        $form = $this->createForm(
            MembreType::class, $membre);

        $form->handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid())
        {
            $em = $this ->getDoctrine() -> getManager();

            $em -> persist($membre);
            $membre ->setStatut('0');

            $password = $membre -> getPassword();
            // password saisi dans le formulaire

            $password_crypte = $encoder -> encodePassword($membre, $password);

            $membre -> setPassword($password_crypte);
            // cryptage du password

            $membre -> setSalt(NULL);
            $membre -> setRoles(['ROLE_USER']);

        $em -> flush();
        // je l' enregistre puis execute vers la bdd

        $request -> getSession() -> getFlashBag() -> add('success', $membre -> getNom() . ' vous avez réussi votre inscription !');
        // message de validation

        return $this -> redirectToRoute('connexion');
        // redirection 
        }

        $params = array(
            'membreForm' => $form->createView(),
        );
        return $this->render('@App/Membre/inscription_membre.html.twig', $params);
    }

    
    
    /**
     * @Route("/membre/profil/", name="membre_profil")
     */
    public function profilMembreAction()
    {
        $params = array();
        return $this->render('@App/Membre/profil_membre.html.twig', $params);
    }
}
