<?php
// src/AppBundle/Controller/FormController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Controller\Utility\FormErrorHandlerTrait;

use AppBundle\Model\Feedback,
    AppBundle\Form\Type\FeedbackType,
    AppBundle\Model\Search,
    AppBundle\Form\Type\SearchType;

class FormController extends Controller
{
    use FormErrorHandlerTrait;

    /**
     * @Method({"POST"})
     * @Route(
     *      "/feedbackSend",
     *      name="feedback_send",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/feedbackSend",
     *      name="feedback_send_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function feedbackSendAction(Request $request)
    {
        $feedbackForm = $this->createForm(new FeedbackType, ($feedback = new Feedback));

        $feedbackForm->handleRequest($request);

        if( !($feedbackForm->isValid()) ) {
            $response = [
                'data' => ['message' => $this->stringifyFormErrors($feedbackForm)],
                'code' => 500
            ];
        } else {
            $subject = ( $feedback->getSubject() ) ?: $this->get('translator')->trans("feedback.no_subject", [], 'emails');

            $body = $this->renderView('AppBundle:Email:feedback.html.twig', [
                'feedback'  => $feedback
            ]);

            if( $this->get('app.mailer_shortcut')->sendMail("no-reply@makar.info", "websecretary@makar.info", $subject, $body) ) {
                $response = [
                    'data' => ['message' => $this->get('translator')->trans("feedback.success", [], 'responses')],
                    'code' => 200
                ];
            } else {
                $response = [
                    'data' => ['message' => $this->get('translator')->trans("feedback.fail", [], 'responses')],
                    'code' => 500
                ];
            }
        }

        return new JsonResponse($response['data'], $response['code']);
    }

    public function feedbackFormAction($_locale)
    {
        $feedbackForm = $this->createForm(new FeedbackType, new Feedback, [
            'action' => '/feedbackSend'
        ]);

        return $this->render('AppBundle:Form:feedbackForm.html.twig', [
            '_locale'      => $_locale,
            'feedbackForm' => $feedbackForm->createView()
        ]);
    }

    /**
     * @Method({"POST"})
     * @Route(
     *      "/searchSend",
     *      name="search_send",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/searchSend",
     *      name="search_send_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function searchSendAction(Request $request)
    {
        $searchForm = $this->createForm(new SearchType, ($search = new Search));

        $searchForm->handleRequest($request);

        if( !($searchForm->isValid()) ) {
            $response = [
                'data' => ['message' => $this->stringifyFormErrors($searchForm)],
                'code' => 500
            ];
        } else {
            $searchResults = $this->getDoctrine()->getManager()->getRepository('AppBundle:BlogArticle')
                ->search($search->getSearchString());

            if( $searchResults )
            {
                $searchResultsFormatted = [];

                foreach($searchResults as $searchResult)
                {
                    $link = $this->get('router')->generate('blog', [
                        'articleId' => $searchResult->getId(),
                        'slug'      => $searchResult->getSlug()
                    ]);

                    $searchResultsFormatted[] = [
                        //Tricky: for now label is not specified, and replaced by date
                        'date'      => NULL,
                        'label'     => $searchResult->getDate()->format('d.m.Y'),
                        'title'     => $searchResult->getTitle(),
                        'link'      => $link,
                        'link_name' => $this->get('translator')->trans("search.details")
                    ];
                }

                $response = [
                    'data' => ['searchResults' => $searchResultsFormatted],
                    'code' => 200
                ];
            } else {
                $response = [
                    'data' => ['message' => $this->get('translator')->trans("search.no_results", [], 'responses')],
                    'code' => 500
                ];
            }
        }

        return new Response(json_encode($response['data']), $response['code']);
    }

    public function searchFormAction($_locale)
    {
        $searchForm = $this->createForm(new SearchType, new Search, [
            'action'  => '/searchSend'
        ]);

        return $this->render('AppBundle:Form:searchForm.html.twig', [
            '_locale'    => $_locale,
            'searchForm' => $searchForm->createView()
        ]);
    }
}
