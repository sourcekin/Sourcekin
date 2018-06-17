<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace App\Controller;

use Broadway\ReadModel\Repository;
use SourcekinBundle\ReadModel\User\SecurityUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfileController extends Controller
{
    /**
     * @Route("/profile")
     * @param Repository            $screenUserRepository
     *
     * @param TokenStorageInterface $storage
     *
     * @return Response
     */
    public function profile(Repository $screenUserRepository, TokenStorageInterface $storage)
    {
        /** @var SecurityUser $loginUser */
        $loginUser  = $storage->getToken()->getUser();
        $screenUser = $screenUserRepository->find($loginUser->getId());

        return new Response('<html><body>Admin page!</body></html>');
    }
}