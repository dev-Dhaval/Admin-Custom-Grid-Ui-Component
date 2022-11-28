<?php
 
namespace Dynamic\Customgrid\Setup;
 
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
 
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $tableName = $installer->getTable('company');

        if ($installer->getConnection()->isTableExists($tableName) != true) {
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'department',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Department'
                )
                ->addColumn(
                    'employee',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'Employee'
                )
                ->addColumn(
                    'position',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'position'
                )
                ->addColumn(
                    'profile',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false, 'default' => ''],
                    'profile'
                )
                ->addColumn(
                    'salary',
                    Table::TYPE_INTEGER,
                    11,
                    ['nullable' => false],
                    'Salary'
                )
                ->addColumn(
                    'skill',
                    Table::TYPE_TEXT,
                    11,
                    ['nullable' => false],
                    'Skill'
                )
                ->setComment('Company')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');

            $setup->getConnection()->addIndex(
				    $setup->getTable('company'),
				    $setup->getIdxName('company', ['id']),
				    ['id']
				);
    
            $installer->getConnection()->createTable($table);
        }

        $installer->getConnection()
            ->addIndex(
                $tableName,
                $installer->getIdxName(
                    $tableName,
                    ['department', 'employee', 'position', 'skill'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['department', 'employee', 'position', 'skill'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );

        $installer->endSetup();
    }
}