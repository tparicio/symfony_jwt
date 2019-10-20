<?php

namespace App\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * Class ApiController
 *
 * @Route("/api/v1/invoice")
 */
class ApiInvoiceController extends Controller
{
    /**
     * @Rest\Get("/", name="files_list_all", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Gets all files for current logged user."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error has occurred trying to get all user files."
     * )
     *
     * @SWG\Tag(name="Board")
     * @param Request $request
     * @return Response
     */
    public function listInvoices(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $files = [];
        $message = '';

        try {
            $code = 200;
            $error = false;

            $userId = $this->getUser()->getId();
            $service = $this->get('app.util.files.finder');
            $files = $service->listFiles();

            if (is_null($files)) {
                $boards = [];
            }

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Boards - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code === 200 ? $files : $message,
        ];

        return new Response($serializer->serialize($response, 'json'));
    }

    /**
     * @Rest\Get("/{invoice}", name="invoice_show_one", defaults={"_format":"json"})
     *
     * @SWG\Parameter(
     *     name="invoice",
     *     type="string",
     *     description="Invoice to return",
     *     schema={
     *     }
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Return one single invoice content"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error has occurred trying to get invoice."
     * )
     *
     * @SWG\Tag(name="Invoice")
     * @param Request $request
     * @param int $invoice
     * @return Response
     */
    public function getInvoice(Request $request, $invoice):Response {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $xml = null;
        $message = '';

        try {
            $code = 200;
            $error = false;

            $userId = $this->getUser()->getId();
            $service = $this->get('app.util.xml.parser');
            $invoice = $request->get('invoice');
            $message = $service->getContent($invoice);
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Boards - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $message,
        ];

        return new Response($serializer->serialize($response, 'json'));
    }

    /**
     * @Rest\Post("/{invoice}/node", name="invoice_node", defaults={"_format":"json"})
     *
     * @SWG\Parameter(
     *     name="invoice",
     *     type="string",
     *     description="Invoice to return",
     *     schema={
     *     }
     * )
     * @SWG\Parameter(
     *     name="node",
     *     in="body",
     *     type="string",
     *     description="Node to return",
     *     schema={}
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Return one single invoice content"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error has occurred trying to get invoice."
     * )
     *
     * @SWG\Tag(name="Invoice")
     * @param Request $request
     * @param int $invoice
     * @return Response
     */
    public function updateInvoice(Request $request, $invoice):Response {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $xml = null;
        $message = '';

        try {
            $code = 200;
            $error = false;

            $userId = $this->getUser()->getId();
            $service = $this->get('app.util.xml.parser');
            $invoice = $request->get('invoice');
            $node = $request->get('node');
            $message = $service->getNode($invoice, $node);
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Boards - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $message,
        ];

        return new Response($serializer->serialize($response, 'json'));
    }

    /**
     * @Rest\Delete("/{invoice}/node", name="invoice_delete_node", defaults={"_format":"json"})
     *
     * @SWG\Parameter(
     *     name="invoice",
     *     type="string",
     *     description="Invoice to return",
     *     schema={
     *     }
     * )
     * @SWG\Parameter(
     *     name="node",
     *     in="body",
     *     type="string",
     *     description="Node to delete",
     *     schema={}
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Return one single invoice content"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error has occurred trying to get invoice."
     * )
     *
     * @SWG\Tag(name="Invoice")
     * @param Request $request
     * @param int $invoice
     * @return Response
     */
    public function deleteNode(Request $request, $invoice):Response {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $xml = null;
        $message = '';

        try {
            $code = 200;
            $error = false;

            $userId = $this->getUser()->getId();
            $service = $this->get('app.util.xml.parser');
            $invoice = $request->get('invoice');
            $node = $request->get('node');
            $message = $service->deleteNode($invoice, $node);
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Boards - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $message,
        ];

        return new Response($serializer->serialize($response, 'json'));
    }

    /**
     * @Rest\Post("/{invoice}/node/add", name="invoice_add_node", defaults={"_format":"json"})
     *
     * @SWG\Parameter(
     *     name="invoice",
     *     type="string",
     *     description="Invoice to return",
     *     schema={
     *     }
     * )
     * @SWG\Parameter(
     *     name="node",
     *     in="body",
     *     type="string",
     *     description="Node to set",
     *     schema={}
     * )
     * @SWG\Parameter(
     *     name="value",
     *     in="body",
     *     type="string",
     *     description="Value node to set",
     *     schema={}
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Return one single invoice content"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error has occurred trying to get invoice."
     * )
     *
     * @SWG\Tag(name="Invoice")
     * @param Request $request
     * @param int $invoice
     * @return Response
     */
    public function addNode(Request $request, $invoice):Response {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $xml = null;
        $message = '';

        try {
            $code = 200;
            $error = false;

            $userId = $this->getUser()->getId();
            $service = $this->get('app.util.xml.parser');
            $invoice = $request->get('invoice');
            $node = $request->get('node');
            $value = $request->get('value');
            $message = $service->addNode($invoice, $node, $value);
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Boards - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $message,
        ];

        return new Response($serializer->serialize($response, 'json'));
    }

    /**
     * @Rest\Post("/{invoice}/node/set", name="invoice_set_node", defaults={"_format":"json"})
     *
     * @SWG\Parameter(
     *     name="invoice",
     *     type="string",
     *     description="Invoice to return",
     *     schema={
     *     }
     * )
     * @SWG\Parameter(
     *     name="node",
     *     in="body",
     *     type="string",
     *     description="Node to delete",
     *     schema={}
     * )
     * @SWG\Parameter(
     *     name="value",
     *     in="body",
     *     type="string",
     *     description="Value node to set",
     *     schema={}
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Return one single invoice content"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error has occurred trying to get invoice."
     * )
     *
     * @SWG\Tag(name="Invoice")
     * @param Request $request
     * @param int $invoice
     * @return Response
     */
    public function setNode(Request $request, $invoice):Response {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $xml = null;
        $message = '';

        try {
            $code = 200;
            $error = false;

            $userId = $this->getUser()->getId();
            $service = $this->get('app.util.xml.parser');
            $invoice = $request->get('invoice');
            $node = $request->get('node');
            $value = $request->get('value');
            $message = $service->setNode($invoice, $node, $value);
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Boards - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $message,
        ];

        return new Response($serializer->serialize($response, 'json'));
    }
}