<?php

namespace Test\ExtensionAttributes\Api;

/**
 * @api
 * Interface ProductCustomAttributeRepositoryInterface
 * @package Test\ExtensionAttributes\Api
 */
interface ProductCustomAttributeRepositoryInterface
{
    /**
     * @param \Test\ExtensionAttributes\Api\Data\ProductCustomAttributeInterface $productCustomAttribute
     *
     * @return int
     */
    public function save(\Test\ExtensionAttributes\Api\Data\ProductCustomAttributeInterface $productCustomAttribute);

    /**
     * @param int $productCustomAttributeId
     *
     * @return \Test\ExtensionAttributes\Api\Data\ProductCustomAttributeInterface int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($productCustomAttributeId);

    /**
     * @param int $productCustomAttributeId
     *
     * @return bool
     */
    public function delete($productCustomAttributeId);

}