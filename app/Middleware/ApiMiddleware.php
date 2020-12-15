<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\ApiCode;
use App\Exception\ApiException;
use App\Model\Logic\UserLogic;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApiMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * @var UserLogic
     */
    protected $UserLogic;

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request, UserLogic $UserLogic)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
        $this->UserLogic = $UserLogic;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 根据具体业务判断逻辑走向，这里假设用户携带的token有效
        $isValid = $this->checkToken($this->request->header('token'));
        if ($isValid) {
            // add base userinfo
            $request = $request->withAttribute('userinfo', $isValid);
            $request = $request->withAttribute('user_id', $isValid->id);
            return $handler->handle($request);
        }

        throw new ApiException(ApiCode::AUTH_ERROR);
    }

    public function checkToken(string $token)
    {
        if ($token) {
            return $this->UserLogic->getUserInfoByToken($token);
        }
        return false;
    }
}
