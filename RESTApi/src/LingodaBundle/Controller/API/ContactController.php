<?php

namespace LingodaBundle\Controller\API;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use LingodaBundle\BusinessObject\InquiryBusinessObject;
use LingodaBundle\Service\InquiryService;
use LingodaBundle\Service\ServiceCodes;
use LingodaBundle\Utility\HTTPStatusCode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


/**
 * Class ContactController
 * @package LingodaBundle\Controller\API)
 * @RouteResource("contact")
 */
class ContactController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return InquiryService
     */
    private function getInquiryService()
    {
        return $this->get('lingoda.lingoda_symfony.lingoda_bundle.service.inquiry_service');
    }

    /**
     * @ApiDoc(
     *     description="Endpoint for Lingoda Contact form",
     *     input="LingodaBundle\BusinessObject\InquiryBusinessObject",
     *     statusCodes={
     *         200="Returned when inquiry is successfully saved",
     *         500="Returned when the failed to save inquiry",
     *         400={
     *           "Returned when the message parameter is not found",
     *           "Returned when the email address parameter is not found",
     *           "Returned when email address exceeds 50 characters",
     *           "Returned when name exceeds 100 characters",
     *           "Returned when message exceeds 1000 characters"
     *         }
     *     }
     * )
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        if (empty($request->getContent())) {
            throw new BadRequestHttpException("JSON request is required", null, HTTPStatusCode::BAD_REQUEST);
        }

        $requestObject = json_decode($request->getContent());

        if ($requestObject === null) {
            throw new BadRequestHttpException("JSON request decode failed", null, HTTPStatusCode::BAD_REQUEST);
        }

        $inquiryBusinessObject = new InquiryBusinessObject();
        $inquiryBusinessObject->setName(
            $requestObject->name
        );

        $inquiryBusinessObject->setEmail(
            $requestObject->email
        );

        $inquiryBusinessObject->setMessage(
            $requestObject->message
        );

        $validator = $this->get('validator');
        $errors = $validator->validate($inquiryBusinessObject);

        if (count($errors) > 0) {
            return $this->view(
                [
                    'errors' => $errors,
                    'code' => ServiceCodes::VALIDATION_ERROR
                ],
                HTTPStatusCode::BAD_REQUEST
            );
        }

        $response = $this->getInquiryService()->CreateInquiry($inquiryBusinessObject);

        switch ($response) {
            case ServiceCodes::INQUIRY_CREATE_SUCCESSFUL:
                $view = $this->view(
                    [
                        'message' => "Inquiry has been saved successfully",
                        'code' => ServiceCodes::INQUIRY_CREATE_SUCCESSFUL
                    ],
                    HTTPStatusCode::CREATED
                );
                break;
            case ServiceCodes::INQUIRY_CREATE_FAILED:
            default:
                $view = $this->view(
                    [
                        'message' => "Inquiry creation failed",
                        'code' => ServiceCodes::INQUIRY_CREATE_FAILED
                    ],
                    HTTPStatusCode::INTERNAL_SERVER_ERROR
                );
                break;
        }

        return $view;

    }
}
