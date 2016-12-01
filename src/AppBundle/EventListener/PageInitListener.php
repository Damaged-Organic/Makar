<?php
// src/AppBundle/EventListener/PageInitListener.php
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use AppBundle\Controller\Contract\PageInitInterface,
    AppBundle\Service\Metadata,
    AppBundle\Service\Backlink;

class PageInitListener
{
    private $_request;

    private $_metadata;
    private $_backlink;

    public function __construct(Request $request, Metadata $metadata, Backlink $backlink)
    {
        $this->_request  = $request;

        $this->_metadata = $metadata;
        $this->_backlink = $backlink;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if( !$event->getRequestType() )
            return FALSE;

        $controller = $event->getController();

        $this->_metadata->setCurrentRoute($this->_request->get('_route'));

        if( $controller[0] instanceof PageInitInterface )
        {
            if( !$this->_request->isXmlHttpRequest() )
            {
                $this->_metadata->setPreviousRoute($this->_backlink->getBacklink());

                $this->_backlink->setBacklink(
                    $this->_metadata->getCurrentRoute(), ["feedback", "search"]
                );

                $this->_metadata->setCurrentMetadata();
            }
        }
    }
}
