<?php

namespace Test\ExtensionAttributes\Api\Data;

interface OrderCustomAttributeInterface
{
    const ORDER_ID = "order_id";
    const CUSTOM_EXTENSION_ATTRIBUTE = "custom_extension_attribute";

    /**
     * Retrieve Provider link.
     *
     * @return string
     */
    public function getCustomExtensionAttribute();

    /**
     * Set Custom Extension Attribute.
     *
     * @param string $customExtensionAttribute
     *
     * @return self
     */
    public function setCustomExtensionAttribute($customExtensionAttribute);

    /**
     * Set order Id.
     *
     * @param int $id
     *
     * @return self
     */
    public function setOrderId($id);

    /**
     * Retrieve Order Id.
     *
     * @return int
     */
    public function getOrderId();
}