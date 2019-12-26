<?php

namespace App\Controller;

use App\Entity\Gear;
use App\Form\GearType;
use App\Entity\Sport;
use App\Form\SportType;
use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/site", name="site")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Gear::class);

        $gears = $repo->findAll();

        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
            'gears' => $gears
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('site/home.html.twig');
    }

    /**
     * @Route("/site/new", name="new_gear")
     * @Route("/site/{id}/edit", name="gear_edit")
     */
    public function form(Gear $gear = null, Request $request, ObjectManager $manager)
    {
        if(!$gear){
            $gear = new Gear();
        }

        $form = $this->createForm(GearType::class, $gear);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($gear);
            $manager->flush();

            return $this->redirectToRoute('site_show', ['id' => $gear->getId()]);
        }

        return $this->render('site/create.html.twig', [
            'formGear' => $form->createView(),
            'editMode' => $gear->getId() !== null
        ]);
    }

    /**
     * @Route("/site/sports", name="sports")
     */
    public function sports()
    {
        $repo = $this->getDoctrine()->getRepository(Sport::class);

        $sports = $repo->findAll();

        return $this->render('site/sports.html.twig', [
            'controller_name' => 'SiteController',
            'sports' => $sports
        ]);
    }

    /**
     * @Route("/site/categories", name="categories")
     */
    public function categories()
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);

        $categories = $repo->findAll();

        return $this->render('site/categories.html.twig', [
            'controller_name' => 'SiteController',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/site/sports/{id}", name="sport_show")
     */
    public function show_sport($id)
    {
        $repo = $this->getDoctrine()->getRepository(Sport::class);

        $sport = $repo->find($id);

        return $this->render('site/show_sport.html.twig', [
            'sport' => $sport
        ]);
    }

    /**
     * @Route("/site/categories/{id}", name="category_show")
     */
    public function show_category($id)
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);

        $category = $repo->find($id);

        return $this->render('site/show_category.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("/site/new_sport", name="new_sport")
     */
    public function form2( $sport = null, Request $request, ObjectManager $manager)
    {
        $sport = new Sport();

        $form = $this->createForm(SportType::class, $sport);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($sport);
            $manager->flush();

            return $this->redirectToRoute('sports');
        }

        return $this->render('site/create_sport.html.twig', [
            'formSport' => $form->createView(),
        ]);
    }

    /**
     * @Route("/site/new_category", name="new_category")
     */
    public function form3( $category = null, Request $request, ObjectManager $manager)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('categories');
        }

        return $this->render('site/create_category.html.twig', [
            'formCategory' => $form->createView(),
        ]);
    }

    /**
     * @Route("/site/{id}", name="site_show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Gear::class);

        $gear = $repo->find($id);

        return $this->render('site/show.html.twig', [
            'gear' => $gear
        ]);
    }

    /**
     * @Route("/site/delete/gear/{id}", name="delete_gear")
     */
    public function Delete(Gear $gear, Request $request, ObjectManager $manager)
    {
        $manager->remove($gear);
        $manager->flush();
        $this->addFlash('suppression', 'gear deleted'); // flash message
        return $this->redirectToRoute('site');
    }
}
