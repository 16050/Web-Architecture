<?php

namespace App\Controller;

use App\Entity\Gear;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sport;
use App\Entity\Category;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Form\GearType;
use Faker\Provider\DateTime;
use App\Form\SportType;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;

class ApiController extends AbstractController
{
    /**
     * @Route("api/",name="api_index", methods={"GET", "OPTIONS"})
     */
    public function APIindex(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response= new Response();
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
            return $response;   
        }

        $repo = $this->getDoctrine()->getRepository(Gear::class);
        $gears = $repo->findAll();

        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($gears, 'json');
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/text');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Route("api/sports/",name="api_sports", methods={"GET", "OPTIONS"})
     */
    public function APIsports(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response= new Response();
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
            return $response;
        }

        $repo = $this->getDoctrine()->getRepository(Sport::class);
        $sports = $repo->findAll();

        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($sports, 'json');
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/text');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Route("api/categories/",name="api_categories", methods={"GET", "OPTIONS"})
     */
    public function APIcategories(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response= new Response();
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
            return $response;
        }

        $repo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repo->findAll();

        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($categories, 'json');
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/text');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS");
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Rest\Get("/api/sports/{id}")
     */
    public function APIshowSport($id)
    {
        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $elements = $this->getDoctrine()->getManager();
        $sport = $elements->getRepository('App:Sport')->find($id);

        $jsonContent = $serializer->serialize($sport, 'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Rest\Get("/api/categories/{id}")
     */
    public function APIshowCategory($id)
    {
        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $elements = $this->getDoctrine()->getManager();
        $category = $elements->getRepository('App:Category')->find($id);

        $jsonContent = $serializer->serialize($category, 'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Rest\Put("/api/new")
     * @Rest\Post("/api/{id}/edit")
     */
    public function APIformGear(Gear $gear = null, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (!$gear) {
            $gear = new Gear();
        }
        $form = $this->createForm(GearType::class, $gear);
        $form->submit($data);
        if (false === $form->isValid()) {
            dump((string)$form->getErrors(true, false));
            die;
            return new JsonResponse(
                [
                    'status' => 'error',
                    'errors' => $this->formErrorSerializer->convertFormToArray($form),
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($gear);
        $doctrine->flush();
        return new JsonResponse(
            [
                'status' => 'Gear added',
                'HTTP' => JsonResponse::HTTP_CREATED
            ]

        );
    }

    /**
     * @Rest\Put("/api/new_category")
     */
    public function APIformCategory(Category $category = null, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($data);
        if (false === $form->isValid()) {
            dump((string)$form->getErrors(true, false));
            die;
            return new JsonResponse(
                [
                    'status' => 'error',
                    'errors' => $this->formErrorSerializer->convertFormToArray($form),
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($category);
        $doctrine->flush();
        return new JsonResponse(
            [
                'status' => 'Category added',
                'HTTP' => JsonResponse::HTTP_CREATED
            ]

        );
    }

    /**
     * @Rest\Put("/api/new_sport")
     */
    public function APIformSport(Sport $sport = null, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $sport = new Sport();
        $form = $this->createForm(SportType::class, $sport);
        $form->submit($data);
        if (false === $form->isValid()) {
            dump((string)$form->getErrors(true, false));
            die;
            return new JsonResponse(
                [
                    'status' => 'error',
                    'errors' => $this->formErrorSerializer->convertFormToArray($form),
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($sport);
        $doctrine->flush();
        return new JsonResponse(
            [
                'status' => 'Sport added',
                'HTTP' => JsonResponse::HTTP_CREATED
            ]
        );
    }

    /**
     * @Rest\Get("/api/{id}")
     */
    public function APIshow($id)
    {
        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $elements = $this->getDoctrine()->getManager();
        $gear = $elements->getRepository('App:Gear')->find($id);

        $jsonContent = $serializer->serialize($gear, 'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Rest\Get("/api/delete/gear/{id}")
     */
    public function DeleteGame(Gear $gear, Request $request, ObjectManager $manager)
    {
        $manager->remove($gear);
        $manager->flush();
        return new Response('', Response::HTTP_CREATED);
    }
}