<?php
// src/AppBundle/Service/Backlink.php
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class Backlink
{
    const BACKLINK = 'backlink';

    private $_session;

    public function __construct(Session $session)
    {
        $this->_session = $session;
    }

    public function setBacklink($currentRoute, array $ignoreRoutes = NULL)
    {
        if( !$ignoreRoutes ) {
            $this->_session->set(self::BACKLINK, $currentRoute);
        } else {
            if( !in_array($currentRoute, $ignoreRoutes, TRUE) )
                $this->_session->set(self::BACKLINK, $currentRoute);
        }
    }

    public function getBacklink()
    {
        return ( $this->_session->has(self::BACKLINK) )
            ? $this->_session->get(self::BACKLINK)
            : FALSE;
    }
}
