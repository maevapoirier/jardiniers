<?php

namespace App\Controller;

use App\Entity\Localization;
use App\Form\LocalizationType;
use App\Repository\LocalizationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LocalizationController extends AbstractController
{
    #[Route('/', name: 'app_localization_index', methods: ['GET'])]
    public function index(LocalizationRepository $localizationRepository): Response
    {
        return $this->render('localization/index.html.twig', [
            'localizations' => $localizationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_localization_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LocalizationRepository $localizationRepository): Response
    {
        $localization = new Localization();
        $form = $this->createForm(LocalizationType::class, $localization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $localizationRepository->save($localization, true);

            return $this->redirectToRoute('app_localization_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('localization/new.html.twig', [
            'localization' => $localization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_localization_show', methods: ['GET'])]
    public function show(Localization $localization): Response
    {
        return $this->render('localization/show.html.twig', [
            'localization' => $localization,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_localization_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Localization $localization, LocalizationRepository $localizationRepository): Response
    {
        $form = $this->createForm(LocalizationType::class, $localization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $localizationRepository->save($localization, true);

            return $this->redirectToRoute('app_localization_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('localization/edit.html.twig', [
            'localization' => $localization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_localization_delete', methods: ['POST'])]
    public function delete(Request $request, Localization $localization, LocalizationRepository $localizationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$localization->getId(), $request->request->get('_token'))) {
            $localizationRepository->remove($localization, true);
        }

        return $this->redirectToRoute('app_localization_index', [], Response::HTTP_SEE_OTHER);
    }
}
