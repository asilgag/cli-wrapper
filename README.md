# cli-wrapper

A simple PHP wrapper over CLI commands.

## Installation
    composer require asilgag/cli-wrapper

## Usage

    use Asilgag\CliWrapper\CliWrapper;
    use Asilgag\CliWrapper\CliCommand;
    
    // Create a new Cli Wrapper
    $cli = new CliWrapper();
    
    // Set environment variables if needed.
    $cli->setEnvironment('FOO', 'baz');
    
    // Set global options for specific commands.
    // In this example, all  "rsync" commands will be
    // suffixed with "--quiet".
    $cli->globalOptions('rsync')->add('--quiet');

    // Create new command.
    $command = new CliCommand('rsync', ['-avzh', '/source/path', '/target/path/']);
    
    // Execute commmand. Will throw a RuntimeException
    // if command exits with a non-zero code.
    try {
        $cli->exec($command);
    }
    catch (RuntimeException $e) {
        // Do some logging
    }
    
    
