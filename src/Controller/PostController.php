<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Post::class)->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/new", name="post_new" , methods={"GET","POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
       $errorsString = [];
       $post = new Post();
       $form = $this->createFormBuilder($post)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Odeslat'])
            ->getForm();


        $form->handleRequest($request);
        $errors = $validator->validate($post);

        if (count($errors) > 0) {
            $errorsString = $errors;
        }

        if ($form->isSubmitted() && $form->isValid() ) {
            $formData = $form->getData();
            $post->setName($formData->getName());
            $post->setDescription($formData->getDescription());

            $em = $doctrine->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post');
        }


        return $this->renderForm('post/new.html.twig', ['form' => $form, 'errors' => $errorsString ]);
    }

}
