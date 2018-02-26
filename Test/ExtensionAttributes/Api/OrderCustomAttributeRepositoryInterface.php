<?php

namespace Test\ExtensionAttributes\Api;

/**
 * @api
 * Interface OrderCustomAttributeRepositoryInterface
 * @package Test\ExtensionAttributes\Api
 */
interface OrderCustomAttributeRepositoryInterface
{
    /**
     * @param \Test\ExtensionAttributes\Api\Data\OrderCustomAttributeInterface $orderCustomAttribute
     *
     * @return int
     */
    public function save(\Test\ExtensionAttributes\Api\Data\OrderCustomAttributeInterface $orderCustomAttribute);

    /**
     * @param int $orderCustomAttributeId
     *
     * @return \Namespace\Custom\Api\Data\CustomInterface int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($orderCustomAttributeId);

    /**
     * @param int $orderCustomAttributeId
     *
     * @return bool
     */
    public function delete($orderCustomAttributeId);

}