<?php declare(strict_types=1);
/**
 * This file was created to add our new GraphQL type WarrantyProvider fields as attributes to Magento's argument resolver
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\ConfigInterface;
use Magento\Framework\GraphQl\Query\Resolver\Argument\FieldEntityAttributesInterface;

class FilterArgument implements FieldEntityAttributesInterface
{
    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * FilterArgument constructor.
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getEntityAttributes(): array
    {
        $fields = [];
        // retrieve each of the fields for our new GraphQL type WarrantyProvider (see schema.grahpqls)
        // then return the array containing the expected structure (similar to other getEntityAttributes methods)
        /** @var Field $field */
        foreach ($this->config->getConfigElement('WarrantyProvider')->getFields() as $field) {
            $fields[$field->getName()] = [
                'type' => 'String',
                'fieldName' => $field->getName()
            ];
        }
        return $fields;
    }
}
