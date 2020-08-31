<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        $articles = $this->getDoctrine()
        -> getRepository(Article::class)
        -> findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/add_article", name="add_article")
     */

     public function addArticle(Request $request, EntityManagerInterface $em, SluggerInterface $slugger){
        $form = $this->createForm(ArticleType::class, new Article());
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form->get('image')->getData();
                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $imageFile->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'ima$imageFilename' property to store the PDF file name
                    // instead of its contents
                    
                }
                $article = $form->getData();
                $article->setImage($newFilename);
                $em->persist($article);
                $em->flush();
            return $this->redirectToRoute('article');
        }else {
        return $this->render('article/add.html.twig', [
        'form' => $form->createView(),
        'errors'=>$form->getErrors()
        ]);
        
    }
    }
        /**
    * @Route("/delete_article/{article}", name="article_delete")
     */
 public function delete(Article $article){
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($article);
    $entityManager->flush();
    return $this->redirect('/article');
}
    /**
     * @Route("/article_detail/{article}", name="article_detail")
     */
    public function articleDetail(Article $article) {
        return $this->render('article/detail.html.twig', [
            'article' => $article
        ]);

    }
}
