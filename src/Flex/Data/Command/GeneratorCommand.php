<?php
namespace Flex\Data\Command;

use Exception;
use Flex\Data\ModelGenerator\Entity;
use Flex\Data\ModelGenerator\Entity\Field;
use Flex\Data\ModelGenerator\Generator;
use SimpleXMLElement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GeneratorCommand
 *
 * @author Jeff Tunessen <jeff.tunessen@gmail.com>
 */
class GeneratorCommand extends Command {

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var string
     */
    private $xmlFile;

    /**
     * @var SimpleXMLElement
     */
    private $xml;

    /**
     * @param string $xmlFile
     * @throws Exception
     */
    private function setxmlFile($xmlFile) {
        $this->xmlFile = realpath($xmlFile);

        if($this->xmlFile === false) {
            throw new Exception('invalid path to the model xmlFile: ' . $xmlFile, 1000);
        }
    }

    /**
     * @return void
     */
    private function loadXmlFile() {
        $this->xml = simplexml_load_file($this->xmlFile);
    }

    /**
     * @return void
     */
    protected function configure() {
        $this->setName('generate');
        $this->setDescription('generate data models');

        $this->addOption('xmlFile', 'path to xmlFile', InputOption::VALUE_OPTIONAL, 'the path to the xmlFile model definition', '.flex/data-models.xml');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->input = $input;
        $this->output = $output;

        $this->setxmlFile($this->input->getOption('xmlFile'));
        $this->loadXmlFile();
        $this->generate();
    }

    /**
     * @return void
     */
    private function generate() {
        $generator = new Generator();
        $generator->setNamespace((string) $this->xml->attributes()['namespace']);
        $generator->setTarget(dirname($this->xmlFile) . '/' . (string) $this->xml->attributes()['target']);

        foreach($this->xml->entity as $entityNode) {
            /** @var SimpleXMLElement $entityNode */
            $entity = new Entity();
            $entity->setNamespace($generator->getNamespace());
            $entity->setTarget($generator->getTarget());
            $entity->setClass((string) $entityNode->attributes()['class']);

            foreach($entityNode->fields->field as $fieldNode) {
                /** @var SimpleXMLElement $fieldNode */
                $field = new Field();
                $field->setName((string) $fieldNode->attributes()['name']);
                $field->setPhpMethod((string) $fieldNode->attributes()['phpMethod']);
                $field->setPhpType((string) $fieldNode->attributes()['phpType']);
                $field->setPhpTypeHinting((string) $fieldNode->attributes()['phpTypeHinting'] === 'true' ? true : false);

                $entity->getFields()
                       ->addElement($field, $field->getName());
            }

            $generator->getEntities()
                      ->addElement($entity, $entity->getClass());
        }

        $generator->generate();
    }
}