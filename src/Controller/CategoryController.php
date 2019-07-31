<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Tests\Compiler\D;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/category/add", name="add_category")
     */
    public function index(Request $poRequest,EntityManagerInterface $poEM)
    {
        $loCategory = new Category();

        $loForm = $this->createForm(CategoryType::class,$loCategory);

        $loForm->handleRequest($poRequest);

        if($loForm->isSubmitted()) {
            $poEM->persist($loCategory);
            $poEM->flush();
        }

        return $this->render('category/add.html.twig', [
            'form' => $loForm->createView()
        ]);
    }

    /**
     * @Route("/category/all", name="category_all")
     * @param EntityManagerInterface $poEM
     * @return object[]
     */
    public function getallCategorys(EntityManagerInterface $poEM)
    {
        $lorepo = $poEM->getRepository(Category::class);
        return $this->render('category/list.html.twig', [
            'categorys' => $lorepo->findAll()
        ]);
    }
}
