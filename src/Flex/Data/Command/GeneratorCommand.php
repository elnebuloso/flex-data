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
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var string
     */
    protected $xmlFile;

    /**
     * @var string
     */
    protected $xmlFileDefault = '.flex/data-models.xml';

    /**
     * @var SimpleXMLElement
     */
    protected $xml;

    /**
     * @param string $xmlFile
     * @throws Exception
     */
    protected function setXmlFile($xmlFile) {
        $this->xmlFile = realpath($xmlFile);

        if($this->xmlFile === false) {
            throw new Exception('invalid path to the model xmlFile: ' . $xmlFile, 1000);
        }
    }

    /**
     * @return void
     */
    protected function loadXmlFile() {
        $this->xml = simplexml_load_file($this->xmlFile);
    }

    /**
     * @return void
     */
    protected function configure() {
        $this->setName('generate');
        $this->setDescription('generate models');

        $this->addOption('xmlFile', 'path to xmlFile', InputOption::VALUE_OPTIONAL, 'the path to the xmlFile model definition', $this->xmlFileDefault);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->input = $input;
        $this->output = $output;

        $this->output->writeln("<comment>generating models</comment>");
        $this->setXmlFile($this->input->getOption('xmlFile'));

        $this->output->writeln("<comment>load xml file</comment>");
        $this->output->writeln("<info>" . $this->xmlFile . "</info>");
        $this->loadXmlFile();

        $this->output->writeln("<comment>generating models</comment>");
        $this->generate();
        $this->output->writeln("<comment>generating models, done</comment>");
    }

    /**
     * @return void
     */
    protected function generate() {
        $generator = new Generator();
        $generator->setNamespace((string) $this->xml->attributes()['namespace']);
        $generator->setTarget(dirname($this->xmlFile) . '/' . (string) $this->xml->attributes()['target']);

        foreach($this->xml->entity as $entityNode) {
            /** @var SimpleXMLElement $entityNode */
            $entity = new Entity();
            $entity->setNamespace($generator->getNamespace());
            $entity->setTarget($generator->getTarget());
            $entity->setName((string) $entityNode->attributes()['name']);
            $entity->setClassName((string) $entityNode->attributes()['className']);

            foreach($entityNode->fields->field as $fieldNode) {
                /** @var SimpleXMLElement $fieldNode */
                $field = new Field();
                $field->setName((string) $fieldNode->attributes()['name']);
                $field->setDefaultValue((string) $fieldNode->attributes()['defaultValue']);
                $field->setPhpName((string) $fieldNode->attributes()['phpName']);
                $field->setPhpType((string) $fieldNode->attributes()['phpType']);
                $field->setPhpTypeHinting((string) $fieldNode->attributes()['phpTypeHinting'] === 'true' ? true : false);

                $fields = $entity->getFields();
                $fields->addElement($field, $field->getName());
            }

            $entities = $generator->getEntities();
            $entities->addElement($entity, $entity->getName());
        }

        $generator->generate();
    }
}