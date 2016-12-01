<?php
// src/AppBundle/Controller/Routing/RoutingController.php
namespace AppBundle\Controller\Routing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RoutingController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route(
     *      "/",
     *      name="index",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/",
     *      name="index_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function indexAction(Request $request)
    {
        return $this->forward('AppBundle:State:index', ['request' => $request]);
    }

    /**
     * @Method({"GET"})
     * @Route(
     *      "/events",
     *      name="events",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/events",
     *      name="events_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function eventsAction()
    {
        return $this->forward('AppBundle:State:events');
    }

    /**
     * @Method({"GET"})
     * @Route(
     *      "/blog/{articleId}/{slug}",
     *      name="blog",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%", "articleId" = null, "slug" = null},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%", "articleId": "\d+"}
     * )
     * @Route(
     *      "/blog/{articleId}/{slug}",
     *      name="blog_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%", "articleId" = null, "slug" = null},
     *      requirements={"domain" = "%domain%", "articleId": "\d+"}
     * )
     */
    public function blogAction($articleId)
    {
        return ( $articleId )
            ? $this->forward('AppBundle:State:blogArticle', ['articleId' => $articleId])
            : $this->forward('AppBundle:State:blogList');
    }

    /**
     * @Method({"GET"})
     * @Route(
     *      "/biography",
     *      name="biography",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/biography",
     *      name="biography_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function biographyAction()
    {
        return $this->forward('AppBundle:State:biography');
    }

    /**
     * @Method({"GET"})
     * @Route(
     *      "/music",
     *      name="music",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/music",
     *      name="music_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function musicAction()
    {
        return $this->forward('AppBundle:State:music');
    }

    /**
     * @Method({"GET"})
     * @Route(
     *      "/books",
     *      name="books",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/books",
     *      name="books_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function booksAction()
    {
        return $this->forward('AppBundle:State:books');
    }

    /**
     * @Method({"GET"})
     * @Route(
     *      "/pictures",
     *      name="pictures",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/pictures",
     *      name="pictures_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function picturesAction()
    {
        return $this->forward('AppBundle:State:pictures');
    }

    /**
     * @Method({"GET"})
     * @Route(
     *      "/feedback",
     *      name="feedback",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/feedback",
     *      name="feedback_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function feedbackAction()
    {
        return $this->forward('AppBundle:State:feedback');
    }

    /**
     * @Method({"GET"})
     * @Route(
     *      "/search",
     *      name="search",
     *      host="{_locale}.{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"_locale" = "%locale%|en", "domain" = "%domain%"}
     * )
     * @Route(
     *      "/search",
     *      name="search_default",
     *      host="{domain}",
     *      defaults={"_locale" = "%locale%", "domain" = "%domain%"},
     *      requirements={"domain" = "%domain%"}
     * )
     */
    public function searchAction()
    {
        return $this->forward('AppBundle:State:search');
    }
}
