<?php declare(strict_types=1);
/**
 * This file was created to add our new GraphQL type Invitation fields as attributes to Magento's argument resolver
 *
 * @package     Evozon_Invitation
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\Invitation\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\ConfigInterface;
use Magento\Framework\GraphQl\Query\Resolver\Argument\FieldEntityAttributesInterface;

class FilterArgument implements FieldEntityAttributesInterface
{
    const CUSTOMER_ID_FILTER = 'customer_id';

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
        // retrieve each of the fields for our new GraphQL type Invitation (see schema.graphqls)
        // then return the array containing the expected structure (similar to other getEntityAttributes methods)
        /** @var Field $field */
        foreach ($this->config->getConfigElement('Invitation')->getFields() as $field) {
            $fields[$field->getName()] = [
                'type' => 'String',
                'fieldName' => $field->getName()
            ];
        }
        // add the customer_id field manually so it doesn't have to be manually requested in the graphQL query in order
        // for the query to work
        $fields[self::CUSTOMER_ID_FILTER] = [
            'type' => 'String',
            'fieldName' => self::CUSTOMER_ID_FILTER
        ];
        return $fields;
    }
}
