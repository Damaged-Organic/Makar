<?php
// src/AppBundle/Controller/AjaxController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Controller\StateController;

class AjaxController extends Controller
{
    /**
     * @Method({"POST"})
     * @Route(
     *      "/getBlogArticles",
     *      name="get_blog_articles",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/getBlogArticles",
     *      name="get_blog_articles_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function getBlogArticlesAction(Request $request)
    {
		if( !$request->request->has('quantity') ) {
			$response = [ 'data' => [], 'code' => 500 ];
		} else {
			if( ($quantity = (int)$request->request->get('quantity')) <= 0 ) {
				$response = [ 'data' => [], 'code' => 500 ];
			} else {
				$articles = $this->getDoctrine()->getManager()->getRepository('AppBundle:BlogArticle')
                    ->findActiveBlogArticles(StateController::BLOG_ARTICLES_NUMBER, $quantity);

				if( !$articles ) {
					$response = [ 'data' => [], 'code' => 500 ];
				} else {
                    $isLast = ( count($articles) < StateController::BLOG_ARTICLES_NUMBER );

					$articlesFormatted = [];

                    foreach($articles as $article)
                    {
                        $link = $this->get('router')->generate('blog', [
                            'articleId' => $article->getId(),
                            'slug'      => $article->getSlug()
                        ]);

                        $articlesFormatted[] = [
                            'title'      => $article->getTitle(),
                            'date'       => $article->getDate()->format('Y-m-d'),
                            'link'       => $link,
                            'link_label' => $this->get('translator')->trans("blogList.details")
                        ];
                    }

                    $response = [
                        'data' => ['articles' => $articlesFormatted, 'isLast' => $isLast],
                        'code' => 200
                    ];
				}
			}
		}

        return new Response(json_encode($response['data']), $response['code']);
    }

    /**
     * @Method({"POST"})
     * @Route(
     *      "/getEventsItems",
     *      name="get_events_items",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/getEventsItems",
     *      name="get_events_items_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function getEventsItemsAction(Request $request)
    {
		if( !$request->request->has('quantity') ) {
			$response = [ 'data' => [], 'code' => 500 ];
		} else {
			if( ($quantity = (int)$request->request->get('quantity')) <= 0 ) {
				$response = [ 'data' => [], 'code' => 500 ];
			} else {
				$events = $this->getDoctrine()->getManager()->getRepository('AppBundle:Event')
                    ->findActiveEvents(StateController::EVENTS_NUMBER, $quantity);

				if( !$events ) {
					$response = [ 'data' => [], 'code' => 500 ];
				} else {
                    $isLast = ( count($events) < StateController::EVENTS_NUMBER );

					$eventsFormatted = [];

                    foreach($events as $event)
                    {
                        $time = ( ($event->getDatetime()->format('H') != 0) && ($event->getDatetime()->format('i') != 0) )
                            ? $event->getDatetime()->format('H:i') . " - "
                            : "";

                        $link_label = ( $event->getLink() )
                            ? $this->get('translator')->trans("events.details")
                            : $this->get('translator')->trans("events.no_details");

                        $eventsFormatted[] = [
                            'title'      => $time . $event->getTitle(),
							'date'       => $event->getDatetime()->format('Y-m-d'),
							'city'       => $event->getCity(),
							'address'    => ( $event->getAddress() ) ?: "",
							'link'       => ( $event->getLink() ) ?: "",
							'link_label' => $link_label
                        ];
                    }

                    $response = [
                        'data' => ['events' => $eventsFormatted, 'isLast' => $isLast],
                        'code' => 200
                    ];
				}
			}
		}
		
		return new Response(json_encode($response['data']), $response['code']);
    }
}
