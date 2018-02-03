<?php
namespace AppBundle\Controller\Render;

use AppBundle\Entity\RarOrder;
use AppBundle\Entity\RarModelOrdered;
use AppBundle\Entity\RarShop;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class PdfController extends Controller
{
	/**
     * @Route("/{_locale}/rendering/{type}/{id}", name="renderingpdf")
     * 
     */
	public function indexAction($type = 'invoice', $id = 0, Request $request){

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $idUser = $this->getUser()->getId();
        $firstName = $this->getUser()->getLastName();
        $lastName = $this->getUser()->getFirstName();
        $role = $this->getUser()->getRole();
        $locale = $this->getUser()->getLocale();
        $name = $firstName.' '.$lastName;
        $configuration = $user->getConfiguration();
        $orderConditionEn = $configuration->getOrderConditionEn();
        $orderCondition = $configuration->getOrderCondition();
        $saleConditionEn = $configuration->getSaleConditionEn();
        $saleCondition = $configuration->getSaleCondition();

        // On ve récupérer les données de la commande
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('AppBundle:RarOrder')->find($id);
        // Data needed
        $modelsOrdered = $order->getmodelsOrdered();
        $shop = $order->getShop();
        $amountVAT = $shop->getAmountVat();
        $vatStatus = $shop->getIsVat();
        $paiment = $order->getPayments();





        $detailsOrder = array();
        $totalPrice = '';
        $totalVAT = '';
        $totalwVAT = '';
        $totalwoVAT = '';
        if($vatStatus == 1){
            foreach ($modelsOrdered as $key => $modelOrdered) {
                $totalPrice = $totalPrice + $modelOrdered->getPrixSoldHT();
                $totalwVAT = $totalVAT+$totalPrice;
                $totalwoVAT = $totalPrice/(1+($amountVAT/100));
                $totalVAT = $totalwoVAT*($amountVAT/ 100);
            }
        }else{
            foreach ($modelsOrdered as $key => $modelOrdered) {
                $totalPrice = $totalPrice + $modelOrdered->getPrixSoldHT();
            }
        }
        $detailsOrder = array(
            'totalPrice' => $totalPrice,
            'totalVAT' => $totalVAT,
            'totalHT' => $totalwoVAT
        );



        $totalPaiement = '';
        foreach ($paiment as $key => $paye) {
            $totalPaiement = $totalPaiement + $paye->getAmount();
        }


        // Chercher les données pour faire le tableau pour la facture et/ou le bon de commande
        if($type == 'invoice') {
    	    $html = $this->renderView( 'renders/pdf/invoice.html.twig', array(
    	            'name' => $name,
                    'locale' => $locale,
                    'order' => $order,
                    'paiment' => $paiment,
                    'detailsOrder' => $detailsOrder,
                    'totalPaiement' => $totalPaiement,
                    'documentRoot' => $_SERVER['DOCUMENT_ROOT'],
                    'configuration' => $configuration,
    	         )
    	    );
            $title = 'Invoice_'.$type.'-'.$id;
            $subject = 'Invoice '.$type.'-'.$id;
            $filename = $type.'-'.$id;
            $pdt_list = '';
        }else if($type == 'purchase-order') {
            $html = $this->renderView( 'renders/pdf/purchase-order.html.twig', array(
                    'name' => $name,
                    'locale' => $locale,
                    'order' => $order,
                    'paiment' => $paiment,
                    'detailsOrder' => $detailsOrder,
                    'totalPaiement' => $totalPaiement,
                    'documentRoot' => $_SERVER['DOCUMENT_ROOT'],
                    'configuration' => $configuration,
                    'orderConditionEn' => $orderConditionEn,
                    'orderCondition' => $orderCondition,
                    'saleConditionEn' => $saleConditionEn,
                    'saleCondition' => $saleCondition
                 )
            );
            $title = 'Purchase order_'.$type.'-'.$id;
            $subject = 'Purchase order '.$type.'-'.$id;
            $filename = $type.'-'.$id;
            $pdt_list = '';
        }elseif($type == 'qrcode'){

            $html="<p>BarCode Tracker</p>";
            $title = 'QRcode_'.$type.'-'.$id;
            $subject = 'Bar Code Tracker '.$type.'-'.$id;
            $filename = $type.'-'.$id;
            $pdt_list=$modelsOrdered;
        }
	    $this->returnPDFResponseFromHTML($html, $title, $subject, $filename, $type, $pdt_list, $locale);

        /*return $this->render( 'renders/pdf/purchase-order.html.twig', array(
                'name' => $name,
                'locale' => $locale,
                'order' => $order,
                'paiment' => $paiment,
                'detailsOrder' => $detailsOrder,
                'totalPaiement' => $totalPaiement,
                'documentRoot' => $_SERVER['DOCUMENT_ROOT'],
                'configuration' => $configuration,
                'orderConditionEn' => $orderConditionEn,
                'orderCondition' => $orderCondition,
                'saleConditionEn' => $saleConditionEn,
                'saleCondition' => $saleCondition
            )
         );*/
	}

	public function returnPDFResponseFromHTML($html, $title, $subject, $filename, $type, $pdt_list, $locale){

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Rime Arodaky');
        $pdf->SetTitle(($title));
        $pdf->SetSubject($subject);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 8, '', true);
        $pdf->SetPrintHeader(false);
        //$pdf->SetMargins(20,20,40, true);

        if($type == "qrcode"){
            $pdf->AddPage();
            $style = array(
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );
            /////////////////////////////////////////////////////////////////
            // ******** PENSER A GENERER l'URL DU PRODUIT *****************//
            /////////////////////////////////////////////////////////////////
            $p = 10;
            foreach ($pdt_list as $key => $modelOrdered) {
                $prodID = $modelOrdered->getId();
                $modelSize = $modelOrdered->getSize();
                $modelHeels = $modelOrdered->getHeels();
                $model = $modelOrdered->getModel();
                $modelName = $model->getName();
                $text = $modelName.' (size: '.$modelSize.' - heels: '.$modelHeels.')';
                $url = $this->generateUrl('viewproduction', array('id' => $prodID),UrlGeneratorInterface::ABSOLUTE_URL);
                $pdf->write2DBarcode($url, 'QRCODE,H', 20, $p, 40, 40, $style, 'N');
                $pdf->Text(70, $p, $text);
                $p=$p+50;
            }
        }else{
            $pdf->AddPage();
        }
        $filename = $title;
        
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }

}




