<?php

namespace Test\ExtensionAttributes\Api\Data;

interface ProductCustomAttributeInterface
{
    const PRODUCT_ID = "product_id";
    const CUSTOM_PRODUCT_NOTE = "custom_product_note";

    /**
     * Retrieve Product Note.
     *
     * @return string
     */
    public function getCustomProductNote();

    /**
     * Set Custom Product Note.
     *
     * @param string $customProductNote
     *
     * @return self
     */
    public function setCustomProductNote($customProductNote);

    /**
     * Set Product Id.
     *
     * @param int $id
     *
     * @return self
     */
    public function setProductId($id);

    /**
     * Retrieve Product Id.
     *
     * @return int
     */
    public function getProductId();
}