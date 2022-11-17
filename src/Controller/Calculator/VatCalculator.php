<?php

namespace App\Controller\Calculator;

use App\Entity\Calculation;
use App\Entity\CalculationResult;
use App\Form\CalculationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Handles VAT Calculation, data export and clearing of history
 */
class VatCalculator extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $calculation        = new Calculation();
        $calculationHistory = $doctrine->getRepository(CalculationResult::class)->findAll();

        $form = $this->createForm(CalculationType::class, $calculation, [
            'action' => $this->generateUrl('index'),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $calculation  = $form->getData();
            $value        = $calculation->getValue();
            $percentage   = $calculation->getVatPercentage();
            $vatRate      = $percentage / 100;
            $valueIncVat  = $value * (1 + $vatRate);
            $valueExclVat = $value / (1 + $vatRate);
            $vatAdded     = $value * $vatRate;
            $vatRemoved   = ($value * $vatRate) / (1 + $vatRate);

            // Add the calculation to the results table
            $calculationResult = new CalculationResult();
            $calculationResult->setOriginalValue($value);
            $calculationResult->setVatPercentage($percentage);
            $calculationResult->setValueIncVat($valueIncVat);
            $calculationResult->setValueExclVat($valueExclVat);
            $calculationResult->setAmountOfVatAdded($vatAdded);
            $calculationResult->setAmountOfVatExcluded($vatRemoved);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($calculationResult);

            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->renderForm('base.html.twig', [
            'form'    => $form,
            'history' => $calculationHistory,
        ]);
    }

    /**
     * @Route("/export", name="export")
     *
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function export(ManagerRegistry $doctrine): Response
    {
        $calculationHistory = $doctrine->getRepository(CalculationResult::class)->findAll();

        $fp = fopen('php://temp', 'w');

        // Set the headers
        fputcsv($fp, [
            'id',
            'value',
            'vat',
            'incVat',
            'exclVat',
            'vatAdded',
            'vatRemoved',
        ]);

        // Add the fields
        foreach ($calculationHistory as $fields) {
            fputcsv($fp, [
                $fields->getId(),
                number_format($fields->getOriginalValue(), 2),
                number_format($fields->getVatPercentage(), 2),
                number_format($fields->getValueIncVat(), 2),
                number_format($fields->getValueExclVat(), 2),
                number_format($fields->getAmountOfVatAdded(), 2),
                number_format($fields->getAmountOfVatExcluded(), 2),
            ]);
        }

        rewind($fp);
        $response = new Response(stream_get_contents($fp));
        fclose($fp);

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="vat-export-' . date('Y-m-d-s') . '.csv"');

        return $response;
    }

    /**
     * @Route("/clear-history", name="clear-history")
     *
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function clearHistory(ManagerRegistry $doctrine): Response
    {
        $calculationHistory = $doctrine->getRepository(CalculationResult::class)->findAll();
        $entityManager      = $doctrine->getManager();

        foreach ($calculationHistory as $history) {
            $entityManager->remove($history);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index');
    }
}
