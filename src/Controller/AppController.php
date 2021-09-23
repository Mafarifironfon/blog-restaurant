<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\SearchCategoryType;
use App\Form\SearchType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/")
 */
class AppController extends AbstractController
{
    private $em;
    private $session;
    private $slugger;

    public function __construct(EntityManagerInterface $em, SessionInterface $session, SluggerInterface $slugger)
    {
        $this->em = $em;
        $this->session = $session;
        $this->slugger = $slugger;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('article/index.html.twig');
    }

    /**
     * @Route("/ajout", name="add")
     */
    public function add(Request $request, FileUploader $fileUploader)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $article->setimage($fileUploader->upload($imageFile));
            }
            $this->em->persist($article);
            $this->em->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('article/add.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/articles", name="list")
     */
    public function list(Request $request)
    {
        $filters = $this->session->get('filters', []);

        $form = $this->createForm(SearchType::class, $filters);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $this->session->set('filters', $filters);
        }

        $articles = $this->em->getRepository(Article::class)->findArticleByFilters($filters);

        return $this->render('article/list.html.twig', [
            'articles' => $articles,
            'categories' => $this->em->getRepository(Category::class)->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function searchByCategory(Request $request)
    {
        //$this->session->set('filters', []);
        $filters = $this->session->get('filters', []);

        $form = $this->createForm(SearchCategoryType::class, $filters);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $this->session->set('filters', $filters);
        }

        $articles = $this->em->getRepository(Article::class)->findArticleByCategory($filters);

        return $this->render('article/category.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/details", name="show")
     * @ParamConverter("Article", class="App\Entity\Article")
     */
    public function show(Article $article)
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @ParamConverter("Article", class="App\Entity\Article")
     */
    public function edit(Request $request, Article $article, FileUploader $fileUploader)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $article->setimage($fileUploader->upload($imageFile));
            }

            $this->em->persist($article);
            $this->em->flush();

            $this->addFlash(
                "success",
                'Article modifié'
            );

            return $this->redirectToRoute('show', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/remove", name="remove")
     * @ParamConverter("Article", class="App\Entity\Article")
     */
    public function remove(Article $article)
    {
        $this->em->remove($article);
        $this->em->flush();

        $this->addFlash(
            "success",
            'Article supprimé'
        );
            return $this->redirectToRoute('list');
    }
}