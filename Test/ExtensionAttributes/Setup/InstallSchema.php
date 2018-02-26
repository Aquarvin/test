<?php

namespace Test\ExtensionAttributes\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('test_extension_attributes')
        )->addColumn(
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity Id'
        )->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true],
            'Product Id'
        )->addColumn(
            'custom_product_note',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['unsigned' => true],
            'Custom Product Note'
        )->addIndex(
            $installer->getIdxName(
                'test_extension_attributes',
                ['entity_id', 'product_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            ['entity_id', 'product_id'],
            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
        )->addForeignKey(
            $installer->getFkName('test_extension_attributes', 'product_id', 'catalog_product_entity', 'entity_id'),
            'product_id',
            $installer->getTable('catalog_product_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Product Extension Attribute Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}