<?php
namespace RemiSan\Serializer\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RemiSan\Serializer\Hydrator\HydratorFactory;
use Symfony\Component\Yaml\Yaml;

class HydratorGenerationCommand extends Command
{
    /**
     * Configures the command
     */
    protected function configure()
    {
        $this->setDescription('Generates hydrators cache files')
             ->addArgument('config', InputArgument::REQUIRED, 'The YAML configuration file for proxies generation');
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

        $configFile = $input->getArgument('config');

        if (!file_exists($configFile)) {
            $output->writeln('<error>The given configuration file does not exist!</error>');
            return;
        }

        $config = Yaml::parse(file_get_contents($configFile));

        $proxyPath = dirname($configFile) . DIRECTORY_SEPARATOR . $config['path'];
        $classNames = $config['classes'];

        $hydratorFactory = new HydratorFactory($proxyPath);

        foreach ($classNames as $className) {
            $output->write('Generating "<info>' . $className . '</info>" ');
            $hydratorFactory->getHydratorClassName($className, true);
            $output->writeLn('<comment>Done</comment>');
        }
    }
}
