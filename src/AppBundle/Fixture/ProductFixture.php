<?php

namespace AppBundle\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Component\Attribute\Factory\AttributeFactoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Model\Channel;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelPricing;
use Sylius\Component\Product\Model\ProductAttributeInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ProductFixture extends AbstractFixture implements FixtureInterface
{
    private $objectManager;

    /**
     * @var FactoryInterface
     */
    private $productFactory;

    /**
     * @var FactoryInterface
     */
    private $productVariantFactory;

    /**
     * @var FactoryInterface
     */
    private $channelPricingFactory;

    /*
     * @var ChannelRepositoryInterface
     */
    private $channelRepository;

    /**
     * @var AttributeFactoryInterface
     */
    private $productAttributeFactory;

    /**
     * @var FactoryInterface
     */
    private $productAttributeValueFactory;

    public function __construct(
        ObjectManager $objectManager,
        FactoryInterface $productFactory,
        FactoryInterface $productVariantFactory,
        FactoryInterface $channelPricingFactory,
        ChannelRepositoryInterface $channelRepository,
        AttributeFactoryInterface $productAttributeFactory,
        FactoryInterface $productAttributeValueFactory
    )
    {
        $this->objectManager = $objectManager;
        $this->productFactory = $productFactory;
        $this->productVariantFactory = $productVariantFactory;
        $this->channelPricingFactory = $channelPricingFactory;
        $this->channelRepository = $channelRepository;
        $this->productAttributeFactory = $productAttributeFactory;
        $this->productAttributeValueFactory = $productAttributeValueFactory;
    }

    public function getName() : string
    {
        return 'app_product';
    }

    public function load(array $options) : void
    {
        $productFactory = $this->productFactory;
        $product = $productFactory->createNew();
        $product->setName('Book Sylius');
        $product->setCode('book sylius');
        $product->setSlug('book-sylius');

        $productVariantFactory = $this->productVariantFactory;
        $productVariant = $productVariantFactory->createNew();
        $productVariant->setName('price');
        $productVariant->setCode('variant-code');
        $product->addVariant($productVariant);

        $channelPricingFactory = $this->channelPricingFactory;
        $channelPricing = $channelPricingFactory->createNew();
        $channelPricing->setPrice(999);
        $channelPricing->setOriginalPrice(998);
        $channelPricing->setChannelCode('US_WEB');
        $productVariant->addChannelPricing($channelPricing);

        $channelRepository = $this->channelRepository;
        $channel = $channelRepository->findOneByCode('US_WEB');
        $product->addChannel($channel);

        $productVariant->setProduct($product);

        $attributeFactory = $this->productAttributeFactory;
        $attribute = $attributeFactory->createTyped('text');
        $attribute->setName('Barcode');
        $attribute->setCode('bar_code');
        $attribute->setCode('bar_code');
        $attribute->setDisplayableInShop(true);
        $this->objectManager->persist($attribute);

        $attributeValueFactory = $this->productAttributeValueFactory;
        $attributeValue = $attributeValueFactory->createNew();

        $attributeValue->setAttribute($attribute);
        $attributeValue->setLocaleCode('en_US');
        $attributeValue->setValue('123456789');
        $product->addAttribute($attributeValue);

        $this->objectManager->persist($product);
        $this->objectManager->flush();
    }
}