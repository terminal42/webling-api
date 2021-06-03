<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Terminal42\WeblingApi\Client;
use Terminal42\WeblingApi\EntityFactory;
use Terminal42\WeblingApi\EntityManager;

abstract class ManagerAwareCommand extends Command
{
    /**
     * @var EntityManager
     */
    protected $manager;

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        if (null === $this->manager) {
            /** @var QuestionHelper $helper */
            $helper = $this->getHelper('question');

            $subdomain = $helper->ask($input, $output, new Question('Please enter your Webling subdomain: '));
            $apiKey = $helper->ask($input, $output, new Question('Please enter your Webling API key: '));

            $this->manager = new EntityManager(new Client($subdomain, $apiKey, EntityManager::API_VERSION), new EntityFactory());
        }
    }
}
