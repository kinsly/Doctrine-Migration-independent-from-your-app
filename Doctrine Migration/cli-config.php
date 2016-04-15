<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Application;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\QuestionHelper;

//Console Commands
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;


/*
 * Database connection
 */
$params = array(
    'host' => getenv("MYSQL_HOST"),
    'port' => getenv("MYSQL_PORT"),
    'user' => getenv("MYSQL_USER"),
    'password' => getenv("MYSQL_PASS"),
    'dbname' => 'smart_checkin',
    'driver' => 'pdo_mysql',  
);

$db = \Doctrine\DBAL\DriverManager::getConnection($params);

//creating entity manager instance
$paths = array(
    __DIR__. "/../../core/Domain/Entity", //Location to entities
    __DIR__."/../../core/Persistence/Doctrine/Mapping"); // location to mappings if you use yml or xml instead of Doctrine annotations
$config = Setup::createYAMLMetadataConfiguration($paths, false); //false = production, true = development
$em = EntityManager::create($params, $config);

$helperSet = new HelperSet(array(
    'db' => new ConnectionHelper($db),
    'em' => new EntityManagerHelper($em),
    'dialog' => new QuestionHelper("Support"),
));

// replace the ConsoleRunner::run() statement with:
$cli = new Application('Doctrine Command Line Interface', \Doctrine\ORM\Version::VERSION);
$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);

// Register All Doctrine Commands
ConsoleRunner::addCommands($cli);

// Register your own command
$cli->addCommands(array(
    // Migrations Commands
    new DiffCommand(),
    new ExecuteCommand(),
    new GenerateCommand(),
    new MigrateCommand(),
    new StatusCommand(),
    new VersionCommand()
));

// Runs console application
$cli->run();