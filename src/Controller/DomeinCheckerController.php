<?php
/**
 * DomeinCheckerController File Doc Comment
 * PHP version 8.1.9
 *
 * @category DomeinChecker
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     this file wants user input to be able
 *             to check the API for domain names and availability
 * @link     https://127.0.0.1:8000
 */

namespace App\Controller;

use App\Database\DataBaseConnector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Transip\Api\Library\TransipAPI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use App\Entity\Task;
use App\Form\Type\TaskType;


/**
 * DomeinChecker Class Doc Comment
 *
 * @category Class_DomeinCheckerController
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     this Class processes the information received from the user
 *           and gives a response on availability on domain names,
 *           and shows this in a table
 * @link     https://127.0.0.1:8000
 */
class DomeinCheckerController extends AbstractController
{
    /**
     * Function filterDomain Doc Comment
     *
     * @param string $domainName is used to search for
     *                           domainNames and availability
     *
     * @return void
     * @desc   This function filters the domains that the user requests,
     * the filter cleans up special chars, spaces and turns all letters to lowercase.
     * The function uses a comma as a separator
     * which allows the user to search for more domain names.
     */
    private function filterDomain(string &$domainName)
    {
        $domainName = trim($domainName);
        $domainName = preg_replace('/[^A-Za-z\d.-]/', '', $domainName);
    }

    #[Route('/', name: 'app_domein_checker')]
    /**
     * Index File Doc Comment
     * PHP version 8.1.9
     *
     * @param Request $request the request that the user sends to the system
     *
     * @return   Response
     * @package  Website_DomeinChecker
     * @author   Aras Vahidnia <avahidnia@transip.nl>
     * @link     https://127.0.0.1:8000
     * @category DomeinCheckerController
     */
    public function index(Request $request): Response
    {
        $apiUser = $this->getParameter('app.api_user');
        $apiKey = $this->getParameter('app.api_key');
        $dbHost = $this->getParameter('app.db_host');
        $dbUser = $this->getParameter('app.db_user');
        $dbPass = $this->getParameter('app.db_pass');
        $dbName = $this->getParameter('app.db_name');

        $api = new TransipAPI(
            $apiUser,
            $apiKey,
            false,
            '',
            'https://api.transip.nl/v6'
        );

        $unusedStatuses = [];
        $checkDomain = new Task();
        $form = $this->createFormBuilder(
            $checkDomain,
            ['attr' => ['class' => 'form-control',
                'style' => 'margin-top: 1vw',
            ],
            ]
        )
            ->add(
                'task', TextareaType::class,
                ['label' => 'Check for domain name(s) availability:
                 example.com, example2.nl, example3.eu']
            )
            ->add(
                'search', SubmitType::class,
                ['label' => 'Search',
                    'attr' => ['class' => 'btn btn-success col-12',
                    ],
                ]
            )
            ->add(
                'history', ButtonType::class,
                ['label' => 'History',
                    'attr' => ['class' => 'btn btn-dark col-12',
                        'onclick' => "window.location.href='history'",
                    ],
                ]
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->getClickedButton() === $form->get('history')) {
            return $this->redirectToRoute('app_history');
        }
        $historyLinks = [];
        if ($form->isSubmitted() && $form->isValid()) {

            $domains = explode(",", $checkDomain->task);
            array_walk($domains, [$this, 'filterDomain']);
            $results = $api->domainAvailability()
                ->checkMultipleDomainNames($domains);
            $dbCon = new DataBaseConnector($dbHost, $dbUser, $dbPass, $dbName);
            foreach ($results as $result) {
                $unusedStatuses = [
                    'inyouraccount',
                    'internalpull',
                    'internalpush',
                    'unavailable',
                ];

                $db = $dbCon->getInstance();
                $domainName = $result->getDomainName();
                $status = $result->getStatus();
                if (in_array($status, $unusedStatuses)) {
                    $status = 'not free';
                }

                $sqlInsertIntoDb = $db->prepare(
                    'INSERT INTO checkDomain(domainName, result)
VALUES(?, ?)'
                );
                

                $sqlInsertIntoDb->execute([$domainName, $status]);
                $historyLinks[$domainName] = $db->lastInsertId();
            }
        }
        return $this->render(
            'domein_checker/index.html.twig', [
                'results' => $results ?? null,
                'form' => $form->createView(),
                'unusedStatuses' => $unusedStatuses,
                'historyIdList' => $historyLinks,
                'controller_name' => 'DomeinCheckerController',
            ]
        );
    }
}