<?php

declare(strict_types=1);

namespace Oro\Bundle\AlternativeCheckoutBundle\Tests\Functional\DataFixtures;

use Oro\Bundle\CheckoutBundle\Entity\Checkout;
use Oro\Bundle\CheckoutBundle\Tests\Functional\DataFixtures\AbstractLoadCheckouts;
use Oro\Bundle\CustomerBundle\Tests\Functional\DataFixtures\LoadCustomerUserData;
use Oro\Bundle\PaymentTermBundle\Tests\Functional\DataFixtures\LoadPaymentMethodsConfigsRuleData;
use Oro\Bundle\PaymentTermBundle\Tests\Functional\DataFixtures\LoadPaymentTermData;
use Oro\Bundle\PaymentTermBundle\Tests\Functional\DataFixtures\Traits\EnabledPaymentMethodIdentifierTrait;
use Oro\Bundle\SaleBundle\Tests\Functional\DataFixtures\LoadQuoteProductDemandData;

class LoadQuoteAlternativeCheckoutsData extends AbstractLoadCheckouts
{
    use EnabledPaymentMethodIdentifierTrait;

    public const CHECKOUT_1 = 'alternative.checkout.1';
    public const CHECKOUT_2 = 'alternative.checkout.2';

    /**
     * {@inheritDoc}
     */
    protected function getData(): array
    {
        $paymentMethodIdentifier = $this->getPaymentMethodIdentifier($this->container);

        return [
            self::CHECKOUT_1 => [
                'customerUser' => LoadCustomerUserData::EMAIL,
                'source' => LoadQuoteProductDemandData::QUOTE_DEMAND_1,
                'checkout' => ['payment_method' => $paymentMethodIdentifier],
            ],
            self::CHECKOUT_2 => [
                'source' => LoadQuoteProductDemandData::QUOTE_DEMAND_2,
                'checkout' => ['payment_method' => $paymentMethodIdentifier],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getWorkflowName(): string
    {
        return 'b2b_flow_alternative_checkout';
    }

    /**
     * {@inheritDoc}
     */
    protected function createCheckout(): Checkout
    {
        return new Checkout();
    }

    /**
     * {@inheritDoc}
     */
    protected function getCheckoutSourceName(): string
    {
        return 'quoteDemand';
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencies(): array
    {
        return array_merge(
            parent::getDependencies(),
            [
                LoadQuoteProductDemandData::class,
                LoadPaymentTermData::class,
                LoadPaymentMethodsConfigsRuleData::class,
            ]
        );
    }
}
