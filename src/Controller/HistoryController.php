<?php
/**
 * HistoryController File Doc Comment
 * PHP version 8.1.9
 *
 * @category HistoryController
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     this file processes the information received from the database
 * @link     https://127.0.0.1:8000/history
 */

namespace App\Controller;

use App\Database\DataBaseConnector;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * History Class Doc Comment
 *
 * @category Class_HistoryController
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     this Class processes the information received from the Mysql database
 *           and returns it in a table
 * @link     https://127.0.0.1:8000/history
 */
class HistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history')]
    /**
     * Index File Doc Comment
     * PHP version 8.1.9
     *
     * @return   Response
     * @package  Website_DomeinChecker
     * @author   Aras Vahidnia <avahidnia@transip.nl>
     * @link     https://127.0.0.1:8000/history
     * @category HistoryController
     */
    public function index(): Response
    {
        $dbHost = $this->getParameter('app.db_host');
        $dbUser = $this->getParameter('app.db_user');
        $dbPass = $this->getParameter('app.db_pass');
        $dbName = $this->getParameter('app.db_name');
        $dbCon = new DataBaseConnector($dbHost, $dbUser, $dbPass, $dbName);
        $db = $dbCon->getInstance();
        $sqlPages = 'SELECT COUNT(id) AS maxPages FROM checkDomain';
        $resultTotalPages = $db->query($sqlPages);
        $row = $resultTotalPages->fetch();
        $maxPages = $row['maxPages'];
        $sqlShowHistory = 'SELECT * FROM checkDomain 
                                     ORDER BY id ASC';
        $resultsHistory = $db->query($sqlShowHistory);

        if ($resultsHistory->rowCount() > 0) {
            $historyEntries = $resultsHistory->fetchAll(PDO::FETCH_BOTH) ?? [];
        }
        return $this->render(
            'history/index.html.twig', [
                'resultsHistory' => $historyEntries ?? null,
                'totalPages' => $maxPages,
                'controller_name' => 'HistoryController',]
        );
    }
}