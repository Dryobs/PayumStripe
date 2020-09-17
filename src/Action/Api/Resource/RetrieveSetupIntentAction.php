<?php

declare(strict_types=1);

namespace FluxSE\PayumStripe\Action\Api\Resource;

use FluxSE\PayumStripe\Request\Api\Resource\RetrieveSetupIntent;
use Stripe\SetupIntent;

final class RetrieveSetupIntentAction extends AbstractRetrieveAction
{
    /** @var string|SetupIntent */
    protected $apiResourceClass = SetupIntent::class;

    /**
     * {@inheritdoc}
     */
    public function supportAlso($request): bool
    {
        return $request instanceof RetrieveSetupIntent;
    }
}
