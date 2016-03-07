<?php
namespace RemiSan\Serializer\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RemiSan\Serializer\Hydrator\HydratorFactory;

class HydratorGenerationCommand extends Command
{
    /**
     * @var HydratorFactory
     */
    private $hydratorFactory;

    /**
     * @var string[]
     */
    private $classes;

    /**
     * Constructor
     *
     * @param HydratorFactory $hydratorFactory
     * @param string[]        $classes
     * @param string          $name
     */
    public function __construct(HydratorFactory $hydratorFactory, array $classes = array(), $name = null)
    {
        $this->hydratorFactory = $hydratorFactory;
        $this->classes = $classes;

        parent::__construct($name);
    }

    /**
     * Configures the command
     */
    protected function configure()
    {
        $this->setDescription('Generates hydrators cache files');
    }

    /**
     * Code executed when command invoked
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classNames = $this->classes;
        foreach ($classNames as $className) {
            $output->write('Generating "<info>' . $className . '</info>" ');
            $this->hydratorFactory->getHydratorClassName($className, true);
            $output->writeLn('<comment>Done</comment>');
        }
    }
}
