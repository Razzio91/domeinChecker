<?php
/**
 * WhoIsController File Doc Comment
 * PHP version 8.1.9
 *
 * @category WhoIs
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     This controller processes the searched domainNames
 * and compares this to the WhoIs results,
 * and the response will be the results for the search,
 * the results will be saved in the databases
 * and presented in a link form,
 * which after being clicked will show a textarea with WhoIs data
 * @link     https://127.0.0.1:8000
 */

namespace App\Controller;

use App\WhoIsResult\WhoIs;
use PDO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Database\DataBaseConnector;

/**
 * WhoIsController Class Doc Comment
 *
 * @category Class_WhoIsController
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     This class processes the searched domain through
 * the WhoIs function, if the result of the search is in the database,
 * then the database will show the results,
 * otherwise the result displayed will be from the whoIs function
 * @link     https://127.0.0.1:8000
 */
class WhoIsController extends AbstractController
{
    #[Route('/who/is', name: 'app_who_is')]
    /**
     * Index File Doc Comment
     * PHP version 8.1.9
     *
     * @param Request $request the request that has been
     *                         sent through the WhoIs command
     *                         will give back the response in the var $domainName,
     *                         which will be used to compare the results
     *                         in the mysql database, and either processes
     *                         the given info into the database,
     *                         or just shows the results from the database
     *
     * @return   Response
     * @package  Website_DomeinChecker
     * @author   Aras Vahidnia <avahidnia@transip.nl>
     * @link     https://127.0.0.1:8000
     * @category WhoIsController
     */
    public function index(Request $request): Response
    {

        $domainName = $request->query->get('domainName');
        $whoIs = new WhoIs();
        $whoIsQuery = $whoIs->query($domainName);

        $dbHost = $this->getParameter('app.db_host');
        $dbUser = $this->getParameter('app.db_user');
        $dbPass = $this->getParameter('app.db_pass');
        $dbName = $this->getParameter('app.db_name');
        $dbCon = new DataBaseConnector($dbHost, $dbUser, $dbPass, $dbName);

        $db = $dbCon->getInstance();
        $sqlWhoIs = "SELECT * FROM checkDomain WHERE domainName = :dom";
        $whoIsQueryToDb = $db->prepare($sqlWhoIs);
        $whoIsQueryToDb->execute([':dom' => $domainName]);
        $whoIsFetch = $whoIsQueryToDb->fetch(PDO::FETCH_ASSOC);

        if ($whoIsFetch['bericht'] == null) {
            $dbCon = new DataBaseConnector($dbHost, $dbUser, $dbPass, $dbName);
            $db = $dbCon->getInstance();
            $sqlInsertIntoDb = $db->prepare(
                "UPDATE checkDomain SET bericht = ? WHERE id = ?"
            );
            $sqlInsertIntoDb->execute([$whoIsQuery, $whoIsFetch['id']]);
        }
        return $this->render(
            'who_is/index.html.twig', [
                'fetchedWhoIs' => $whoIsFetch['bericht'],
                'whoIsQuery' => $whoIsQuery,
                'controller_name' => 'WhoIsController',
            ]
        );
    }
}
