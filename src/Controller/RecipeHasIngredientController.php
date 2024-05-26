<?php

namespace App\Controller;

use App\Entity\RecipeHasIngredient;
use App\Form\RecipeHasIngredientType;
use App\Repository\RecipeHasIngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipe/has/ingredient')]
class RecipeHasIngredientController extends AbstractController
{
    #[Route('/', name: 'app_recipe_has_ingredient_index', methods: ['GET'])]
    public function index(RecipeHasIngredientRepository $recipeHasIngredientRepository): Response
    {
        return $this->render('recipe_has_ingredient/index.html.twig', [
            'recipe_has_ingredients' => $recipeHasIngredientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_recipe_has_ingredient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recipeHasIngredient = new RecipeHasIngredient();
        $form = $this->createForm(RecipeHasIngredientType::class, $recipeHasIngredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipeHasIngredient);
            $entityManager->flush();

            return $this->redirectToRoute('app_recipe_has_ingredient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe_has_ingredient/new.html.twig', [
            'recipe_has_ingredient' => $recipeHasIngredient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recipe_has_ingredient_show', methods: ['GET'])]
    public function show(RecipeHasIngredient $recipeHasIngredient): Response
    {
        return $this->render('recipe_has_ingredient/show.html.twig', [
            'recipe_has_ingredient' => $recipeHasIngredient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recipe_has_ingredient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RecipeHasIngredient $recipeHasIngredient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecipeHasIngredientType::class, $recipeHasIngredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recipe_has_ingredient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe_has_ingredient/edit.html.twig', [
            'recipe_has_ingredient' => $recipeHasIngredient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recipe_has_ingredient_delete', methods: ['POST'])]
    public function delete(Request $request, RecipeHasIngredient $recipeHasIngredient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipeHasIngredient->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($recipeHasIngredient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recipe_has_ingredient_index', [], Response::HTTP_SEE_OTHER);
    }
}
