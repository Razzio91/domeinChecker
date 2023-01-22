<?php

namespace App\Controller;

use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history')]
    public function index(): Response
    {
        require __DIR__ . '/../../public/db.php';

        $sqlShowHistory = "SELECT domainName, result, checkDate FROM checkDomain";

        $results = $dbh->query($sqlShowHistory);

        if ($results->rowCount() > 0) {

            $historyEntries = $results->fetchAll(PDO::FETCH_ASSOC);

        }


        return $this->render('history/index.html.twig', [
            'results' => $historyEntries ?? NULL,
            'controller_name' => 'HistoryController',
        ]);
    }
}
