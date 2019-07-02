<?php

namespace MallardDuck\LaravelTraits\Console;

/**
 * Easily add the ability to prefix command output for convenient logging.
 */
trait CommandOutputPrefix
{

  /**
   * The string used to prefix command output.
   *
   * @var string
   */
    protected $outputPrefix;

  /**
   * The config flag to dictate how and when to apply the prefix.
   *
   * @var int|bool
   */
    protected $prefixConfig = 0;

  /**
   * The timestamp used to ID groupped output.
   *
   * @var int
   */
    protected $runStart;

  /**
   * Called from a command constructor to bootstrap Output Prefixing.
   *
   * @param string $prefix
   * @param int|bool $config
   *
   * @return void
   */
    private function bootOutputPrefix(string $prefix, $config = null)
    {
        $this->outputPrefix = $prefix;
        $this->prefixConfig = $config;
      // Append the flag this trait needs to the signature.
        $this->signature .= " {--C|cron : Run the command in cron mode. [Prefixes output]}";
      // Use the start time as a unique identifier for each command instance.
        $this->runStart = time();
    }

  /**
   * Initilizes output prefixing when a command is envoked.
   *
   * To be called within the handle() method on the command.
   *
   * @return void
   */
    private function initOutputPrefix()
    {
        $this->prefixConfig = $this->option('cron');
    }

/**
 * Returns the rendered output prefix string.
 *
 * @return string
 */
    private function getOutputPrefix(): string
    {
        return "[{$this->outputPrefix} ID:{$this->runStart}] ";
    }

  /**
   * Returns the needed output string - with or without the prefix.
   *
   * @param  string  $string
   * @return string
   */
    private function renderOutputString($string): string
    {
        if (true == $this->prefixConfig) {
            return $this->getOutputPrefix() . $string;
        }
        return $string;
    }

  /**
   * Write a string as standard output.
   *
   * Overridden by the trait to accomplish output prefixing.
   *
   * @param  string  $string
   * @param  null|string  $style
   * @param  null|int|string  $verbosity
   * @return void
   */
    public function line($string, $style = null, $verbosity = null)
    {
        $string = $this->renderOutputString($string);
        $styled = $style ? "<$style>$string</$style>" : $string;

        $this->output->writeln($styled, $this->parseVerbosity($verbosity));
    }
}
