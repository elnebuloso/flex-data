<?php
namespace Flex\Persistence\Command;

use Flex\Data\Command\GeneratorCommand as DataGeneratorCommand;

/**
 * Class GeneratorCommand
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class GeneratorCommand extends DataGeneratorCommand {

    /**
     * @var string
     */
    protected $xmlFileDefault = '.flex/persistence-models.xml';

    /**
     * @return void
     */
    public function generate() {
    }
}