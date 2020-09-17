<?php

declare(strict_types=1);

namespace FluxSE\PayumStripe\Action\Api\Resource;

use FluxSE\PayumStripe\Action\Api\StripeApiAwareTrait;
use FluxSE\PayumStripe\Request\Api\Resource\RetrieveInterface;
use Payum\Core\Exception\LogicException;
use Payum\Core\Exception\RequestNotSupportedException;
use Stripe\ApiOperations\Retrieve;
use Stripe\ApiResource;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

abstract class AbstractRetrieveAction implements RetrieveActionInterface
{
    use StripeApiAwareTrait;
    use ResourceAwareActionTrait;

    /**
     * {@inheritdoc}
     *
     * @param RetrieveInterface $request
     *
     * @throws ApiErrorException
     */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $this->checkRequest($request);

        $apiResource = $this->retrieveApiResource($request);

        $request->setApiResource($apiResource);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ApiErrorException
     */
    public function retrieveApiResource(RetrieveInterface $request): ApiResource
    {
        $apiResourceClass = $this->getApiResourceClass();
        if (false === method_exists($apiResourceClass, 'retrieve')) {
            throw new LogicException(sprintf('This class "%s" is not an instance of "%s"', (string) $apiResourceClass, Retrieve::class));
        }

        Stripe::setApiKey($this->api->getSecretKey());

        /** @see Retrieve::retrieve() */
        /** @var ApiResource $apiResource */
        $apiResource = $apiResourceClass::retrieve(
            $request->getId(),
            $request->getOptions()
        );

        return $apiResource;
    }

    /**
     * {@inheritdoc}
     *
     * @param RetrieveInterface $request
     */
    public function supports($request): bool
    {
        return
            $request instanceof RetrieveInterface &&
            $this->supportAlso($request)
        ;
    }

    protected function checkRequest(RetrieveInterface $request): void
    {
        // Silent is golden
    }
}
