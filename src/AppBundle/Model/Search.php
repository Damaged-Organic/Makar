<?php
// src/AppBundle/Model/Search.php
namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Search
{
    /**
     * @Assert\NotBlank(
     *      message = "search.search_string.not_blank"
     * )
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "search.search_string.length_min",
     *      maxMessage = "search.search_string.length_max"
     * )
     */
    protected $searchString;

    public function setSearchString($searchString)
    {
        $this->searchString = $searchString;

        return $this;
    }

    public function getSearchString()
    {
        return $this->searchString;
    }
}
