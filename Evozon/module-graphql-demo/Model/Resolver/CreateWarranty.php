<?php declare(strict_types=1);
/**
 * This file represents the Service implementation for the new createWarranty GraphQL mutation
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model\Resolver;

use Evozon\GraphQlDemo\Model\Warranty\CreateWarranty as CreateWarrantyProvider;
use Evozon\GraphQlDemo\Model\Warranty\ExtractWarrantyData;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class CreateWarranty implements ResolverInterface
{
    private CreateWarrantyProvider $createWarrantyProvider;
    /**
     * @var ExtractWarrantyData
     */
    private ExtractWarrantyData $extractWarrantyData;

    /**
     * CreateWarranty constructor.
     */
    public function __construct(
        CreateWarrantyProvider $createWarrantyProvider,
        ExtractWarrantyData $extractWarrantyData
    ) {
        $this->createWarrantyProvider = $createWarrantyProvider;
        $this->extractWarrantyData = $extractWarrantyData;
    }

    /**
     * Resolves adding a new warranty provider
     *
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlInputException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        $data = $args['input'];

        try {
            // create the warranty provider using GraphQL input data
            $warrantyProvider = $this->createWarrantyProvider->execute($data);
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        // return the warranty data as array, keys should match the ones defined in schema.graphqls
        return ['warranty' => $this->extractWarrantyData->execute($warrantyProvider)];
    }
}
