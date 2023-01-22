<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Transip\Api\Library\TransipAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Form\Type\TaskType;


class DomeinCheckerController extends AbstractController
{
    private function filterDomain(string &$domainName)
    {
        $domainName = trim($domainName);
        $domainName = preg_replace('/[^A-Za-z\d.-]/', "", $domainName);

    }


    #[Route('/', name: 'app_domein_checker')]
    public function index(Request $request): Response
    {
        require __DIR__ . '/../../public/key.php';
        require __DIR__ . '/../../public/db.php';

        $api = new TransipAPI(
            $login,
            $privateKey,
            false,
            '',
            'https://api.transip.nl/v6'
        );

        $checkDomain = new Task();

        $form = $this->createFormBuilder($checkDomain)
            ->add('task', TextType::class)
            ->add('search', SubmitType::class, ['label' => 'Search For Domain'])
            ->add('history', SubmitType::class,['label' => 'History'] )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('history')->isClicked()){

                return $this->redirectToRoute('app_history');

            }else {

                $domains = explode(",", $checkDomain->task);


                array_walk($domains, [$this, "filterDomain"]);

                $results = $api->domainAvailability()->checkMultipleDomainNames($domains);


                foreach ($results as $result) {

                    $domainName = $result->getDomainName();
                    $status = $result->getStatus();
                    $sqlInsertIntoDb = $dbh->prepare("INSERT INTO checkDomain(domainName, result) VALUES(?, ?)");
                    if($status == "inyouraccount" || $status == "internalpull" || $status == "internalpush"){
                        $status = "not free";
                    }
                    $sqlInsertIntoDb->execute([$domainName, $status]);
//                    var_dump($domainName, $status, PHP_EOL);


                }

            }
        }
        return $this->render('domein_checker/index.html.twig', [
            'results' => $results ?? null,
            'form' => $form->createView(),
            'controller_name' => 'DomeinCheckerController',
        ]);
    }
}
//Manier 2:
//            $filteredDomains =[];
//            foreach($domains as $domain){
//                $filteredDomains[] = trim($domain);
//            }

//            foreach($domains as &$domain){
//                $domain = trim($domain);
//            }

//Manier 3:
//            array_walk($domains, function (string &$value, $key) {
//                $value = trim($value);
//                $value = preg_replace('/[^A-Za-z\d.-]/', "", $value);
//
//            });
