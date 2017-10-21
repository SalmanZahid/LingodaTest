<?php

namespace LingodaBundle\Controller\WWW;

use LingodaBundle\BusinessObject\InquiryBusinessObject;
use LingodaBundle\Entity\Inquiry;
use LingodaBundle\Service\InquiryService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class DefaultController extends Controller
{

    /**
     * @return InquiryService
     */
    private function getInquiryService()
    {
        return $this->get('lingoda.lingoda_symfony.lingoda_bundle.service.inquiry_service');
    }

    /**
     * @Route("/", name="www")
     * @Route("/home", name="www_homepage")
     */
    public function indexAction()
    {
        return $this->render('Default/index.html.twig');
    }
}
