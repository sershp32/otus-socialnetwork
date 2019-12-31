<?php

declare(strict_types=1);

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

final class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private RouterInterface $router;

    private CsrfTokenManagerInterface $token;

    private UserPasswordEncoderInterface $encoder;

    private UserRepository $rep;

    public function __construct(
        RouterInterface $router,
        CsrfTokenManagerInterface $token,
        UserPasswordEncoderInterface $encoder,
        UserRepository $rep
    )
    {
        $this->router = $router;
        $this->token = $token;
        $this->encoder = $encoder;
        $this->rep = $rep;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login_action');
    }

    public function supports(Request $request): bool
    {
        return 'login_action' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'login' => $request->request->get('login'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
//        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
//
//        if (!$this->token->isTokenValid($token)) {
//            throw new InvalidCsrfTokenException();
//        }

        if (!$user = $this->rep->findUserByLogin($credentials['login'])) {
            return false;
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->encoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return new RedirectResponse($this->router->generate('home_action'));
    }
}
