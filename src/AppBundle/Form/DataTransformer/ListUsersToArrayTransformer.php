<?php
/**
 * Created by PhpStorm.
 * User: EravilleSteve
 * Date: 18/03/2018
 * Time: 10:19
 */

namespace AppBundle\Form\DataTransformer;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class ListUsersToArrayTransformer implements DataTransformerInterface
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an array to a string.
     *
     * @return string
     */
    public function transform($usersAsArray)
    {
        return implode('; ', $usersAsArray);
    }

    /**
     * Transforms a string (users) to an array.
     *
     */
    public function reverseTransform($usersAsString)
    {
        return explode('; ', $usersAsString);
    }
}