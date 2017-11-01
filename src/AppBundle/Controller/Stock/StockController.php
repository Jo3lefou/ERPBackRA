<?php

namespace AppBundle\Controller\Stock;

use AppBundle\Entity\RarStockLog;
use AppBundle\Entity\RarWorkroom;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class StockController extends Controller
{
    /**
     * @Route("/admin/{_locale}/stocks/", name="stocks")
     *
     * Security("has_role('ROLE_ADMIN')")
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;
        $repoWorkroom = $this->getDoctrine()->getRepository(RarWorkroom::class);
        $repoStock = $this->getDoctrine()->getRepository(RarStockLog::class);
        $workrooms = $repoWorkroom->findBy( array( 'isActive' => 1 ) );
        foreach ($workrooms as $key => $workroom) {
            // Info
            $stocks[$workroom->getId()]['info'] = array('name' => $workroom->getName(), 'id' => $workroom->getId(), 'key' => $key);
            // Stockline
            $stocks[$workroom->getId()]['stock'] = $repoStock->findBy( array( 'workroom' => $workroom ) );

             // Set Id Compta
            $repositoryStockLog = $this->getDoctrine()
                ->getRepository(RarStockLog::class);
            $querySumStock = $repositoryStockLog->createQueryBuilder('sl')
                ->select("SUM(sl.quantity) as qt, c.name, c.sku")
                ->leftJoin('sl.matter', 'c')
                ->where('sl.workroom = :workroom')
                ->setParameter('workroom', $workroom)
                ->groupBy('sl.matter');
            $sumStock = $querySumStock->getQuery()->getResult();


            // Stock Réel
            $stocks[$workroom->getId()]['stockData'] = $sumStock;
        }

        if($user){
            //var_dump($users);
            return $this->render('stocks/list.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'title' => ' | Stocks',
                'h1title' => 'Bienvenue User',
                'p1h2' => $this->get('translator')->trans('Check all the stock logs'),
                'bodyClass' => 'nav-md',
                'stocks' => $stocks,
                'user' => $user,
            ));

        }else{
            return $this->redirect('login');
        }
    }
}