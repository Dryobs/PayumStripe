<?php

declare(strict_types=1);

namespace FluxSE\PayumStripe\Request\Api\Resource;

use Payum\Core\Model\ModelAggregateInterface;
use Payum\Core\Model\ModelAwareInterface;
use Payum\Core\Security\TokenAggregateInterface;
use Stripe\ApiResource;
use Stripe\Collection;

interface AllInterface extends OptionsAwareInterface, ModelAwareInterface, ModelAggregateInterface, TokenAggregateInterface
{
    /**
     * @return array
     */
    public function getParameters(): ?array;

    public function setParameters(array $parameters): void;

    /**
     * @return Collection<ApiResource>
     */
    public function getApiResources(): Collection;

    /**
     * @param Collection<ApiResource> $apiResources
     */
    public function setApiResources(Collection $apiResources): void;
}
