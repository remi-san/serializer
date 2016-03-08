<?php
namespace RemiSan\Serializer\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RemiSan\Serializer\Hydrator\HydratorFactory;

class HydratorGenerationCommand extends Command
{
    /**
     * Configures the command
     */
    protected function configure()
    {
        $this->setDescription('Generates hydrators cache files')
             ->addArgument('cache-path', InputArgument::REQUIRED, 'The path of the directory for the cached files')
             ->addArgument('class', InputArgument::REQUIRED, 'The FQCN of the class to generate proxy for');
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

        $proxyPath = $input->getArgument('cache-path');
        $className = $input->getArgument('class');

        $hydratorFactory = new HydratorFactory($proxyPath);

        $output->write('Generating "<info>' . $className . '</info>" ');
        $hydratorFactory->getHydratorClassName($className, true);
        $output->writeLn('<comment>Done</comment>');
    }
}
