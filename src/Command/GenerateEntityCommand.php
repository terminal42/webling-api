<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Command;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;
use Terminal42\WeblingApi\Exception\HttpStatusException;

class GenerateEntityCommand extends ManagerAwareCommand
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    protected function configure(): void
    {
        $this
            ->setName('generate')
            ->setDescription('Generate entities for your Webling configuration.')
            ->addArgument('directory', InputArgument::REQUIRED, 'The directory to place generated files.')
            ->addOption('namespace', null, InputOption::VALUE_REQUIRED, 'The namespace for generated entities.')
            ->addOption('strict-types', null, InputOption::VALUE_NONE, 'Whether to enforce strict types on the entities.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $definition = $this->manager->getDefinition();
        } catch (HttpStatusException $e) {
            $output->writeln('Could not connect to the Webling API. Check your access details.');

            if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                $output->writeln($e->getMessage());
            }

            return 1;
        }

        $classes = [];
        $namespace = $this->getNamespace($input, $output);

        foreach ($this->getSupportedTypes($definition) as $entity) {
            $class = ucfirst($entity);
            $classes[$entity] = $namespace.'\\Entity\\'.$class;

            $this->generateEntity($namespace, $class, $input->getArgument('directory'), $definition[$entity]['properties'], $input->getOption('strict-types'));
        }

        $this->generateEntityFactory($namespace, $classes, $input->getArgument('directory'), $input->getOption('strict-types'));

        return 0;
    }

    private function getNamespace(InputInterface $input, OutputInterface $output): string
    {
        if ($namespace = $input->getOption('namespace')) {
            return $namespace;
        }

        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        $folders = [];
        $dir = rtrim($input->getArgument('directory'), \DIRECTORY_SEPARATOR);

        foreach (array_reverse(explode(\DIRECTORY_SEPARATOR, $dir)) as $folder) {
            if (!preg_match('/^[A-Z][A-Za-z0-9]*$/', $folder)) {
                break;
            }

            $folders[] = $folder;
        }

        $namespace = implode('\\', array_reverse($folders));

        return $helper->ask(
            $input,
            $output,
            new Question('Please enter a namespace ['.$namespace.']: ', $namespace)
        );
    }

    private function getSupportedTypes(array $definition): array
    {
        $entities = [];

        foreach (array_keys($definition) as $type) {
            if ($this->manager->getFactory()->supports($type)) {
                $entities[] = $type;
            }
        }

        return $entities;
    }

    private function generateEntityFactory($namespace, array $classes, $path, bool $strictTypes = false): void
    {
        $declare = $strictTypes ? "\ndeclare(strict_types=1);\n" : '';
        $var = var_export($classes, true);

        $buffer = <<<PHP
<?php
$declare
namespace $namespace;

use Terminal42\\WeblingApi\\EntityFactory as BaseFactory;

class EntityFactory extends BaseFactory
{
    protected static \$classes = $var;

PHP;

        $buffer .= "}\n";

        $this->filesystem->dumpFile($path.\DIRECTORY_SEPARATOR.'EntityFactory.php', $buffer);
    }

    private function generateEntity($namespace, $className, $path, array $properties, bool $strictTypes = false): void
    {
        $declare = $strictTypes ? "\ndeclare(strict_types=1);\n" : '';
        $buffer = <<<PHP
<?php
$declare
namespace $namespace\\Entity;

use Terminal42\\WeblingApi\\Entity\\DefinitionAwareInterface;
use Terminal42\\WeblingApi\\Entity\\GeneratorTrait;
use Terminal42\\WeblingApi\\Entity\\$className as BaseEntity;

class $className extends BaseEntity implements DefinitionAwareInterface
{
    use GeneratorTrait;

PHP;

        foreach ($properties as $name => $property) {
            $id = $property['id'];
            $method = $this->normalizeProperty($name);
            $type = $this->getType($property['datatype'], $name, $namespace);

            $isScalar = \in_array($type, ['int', 'float', 'bool', 'string'], true);
            $default = $isScalar ? '' : ' = null';
            $getter = '$this->valueFromProperty($name, $this->getProperty($name))';

            $typehint = $isScalar && !$strictTypes ? '' : $type.' ';
            $return = $strictTypes ? ': ?'.$type : '';
            $getDocs = $strictTypes ? '' : "\n    /**\n     * @return $type\n     */";
            $setDocs = $strictTypes ? '' : "\n    /**\n     * @param $type \$value\n     */";

            if ('enum' === $property['datatype'] || 'multienum' === $property['datatype']) {
                $this->generateEnum($namespace, $method, $path, $property, 'multienum' === $property['datatype'], $strictTypes);
                $default = '';
                $getter = 'new '.$type.'($this->getProperty($name))';
            }

            $buffer .= <<<PHP
$getDocs
    public function get$method()$return
    {
        \$name = \$this->getPropertyNameById($id);

        return $getter;
    }
$setDocs
    public function set$method($typehint\$value$default): self
    {
        \$name = \$this->getPropertyNameById($id);
        \$this->setProperty(\$name, \$value);

        return \$this;
    }

PHP;
        }

        $buffer .= "}\n";

        $this->filesystem->dumpFile(
            $path.\DIRECTORY_SEPARATOR.'Entity'.\DIRECTORY_SEPARATOR.$className.'.php',
            $buffer
        );
    }

    private function generateEnum($namespace, $className, $path, array $property, bool $multi = false, bool $strictTypes = false): void
    {
        $declare = $strictTypes ? "\ndeclare(strict_types=1);\n" : '';
        $parent = $multi ? 'Multienum' : 'Enum';
        $buffer = <<<PHP
<?php
$declare
namespace $namespace\\Property;

use Terminal42\\WeblingApi\\Property\\$parent;

class $className extends $parent
{

PHP;

        foreach ((array) $property['values'] as $value) {
            $name = $this->normalizeConstant($className, $value);

            $buffer .= <<<PHP
    const $name = '$value';

PHP;
        }

        $buffer .= "}\n";

        $this->filesystem->dumpFile(
            $path.\DIRECTORY_SEPARATOR.'Property'.\DIRECTORY_SEPARATOR.$className.'.php',
            $buffer
        );
    }

    private function normalizeProperty($name)
    {
        $name = preg_replace('/[^a-z0-9]/i', '_', $name);
        $parts = explode('_', $name);
        $parts = array_map('ucfirst', $parts);

        return implode('', $parts);
    }

    private function normalizeConstant($property, $value)
    {
        $value = str_replace(['ä', 'Ä', 'ö', 'Ö', 'ü', 'Ü'], ['ae', 'AE', 'oe', 'OE', 'ue', 'UE'], $value);
        $value = preg_replace('/[^a-z0-9]/i', '_', $value);
        $value = trim(str_replace('__', '_', $value), '_');

        if (is_numeric($value)) {
            $value = $property.'_'.$value;
        }

        return strtoupper($value);
    }

    private function getType($datatype, $name, $namespace)
    {
        switch ($datatype) {
            case 'autoincrement':
            case 'int':
                return 'int';

            case 'numeric':
                return 'float';

            case 'bool':
                return 'bool';

            case 'enum':
                return '\\'.$namespace.'\\Property\\'.$this->normalizeProperty($name);

            case 'multienum':
                return '\\'.$namespace.'\\Property\\'.$this->normalizeProperty($name);

            case 'file':
                return '\\Terminal42\\WeblingApi\\Property\\File';

            case 'image':
                return '\\Terminal42\\WeblingApi\\Property\\Image';

            case 'text':
            case 'longtext':
                return 'string';

            case 'date':
                return '\\Terminal42\\WeblingApi\\Property\\Date';

            case 'timestamp':
                return '\\Terminal42\\WeblingApi\\Property\\Timestamp';

            default:
                throw new \InvalidArgumentException(sprintf('Type "%s" is not supported (Property: %s).', $datatype, $name));
        }
    }
}
