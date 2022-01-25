<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
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
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/post", name="post")
     */
    public function index(): Response
    {
        $posts = $this->doctrine->getRepository(Post::class)->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/new", name="post_new" , methods={"GET","POST"})
     */
    public function new(Request $request, ValidatorInterface $validator)
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

            $em = $this->doctrine->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post');
        }


        return $this->renderForm('post/new.html.twig', ['form' => $form, 'errors' => $errorsString ]);
    }

        /**
         * @Route("/post/{id}", name="post_show")
         */
        public function show($id)
        {
            $post = $this->doctrine->getRepository(Post::class)->find($id);

            return $this->render('post/show.html.twig', [
                'post' => $post,
            ]);
        }

    /**
     * @Route("/post/{id}/delete", name="post_delete")
     */
    public function delete($id, PostRepository $postRepository)
    {
        $post = $postRepository->find($id);
        $this->doctrine->getManager()->remove($post);
        $this->doctrine->getManager()->flush();
        $this->addFlash('success', 'Smazáno');
        return $this->redirectToRoute('post');
    }

    /**
     * @Route("/post/{id}/edit", name="post_edit")
     */
    public function edit(Post $post, Request $request, ValidatorInterface $validator)
    {
        $errorsString = [];

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

            $em = $this->doctrine->getManager();

            $em->flush();

            return $this->redirectToRoute('post');
        }


        return $this->renderForm('post/edit.html.twig', ['form' => $form, 'errors' => $errorsString ]);
    }

}
