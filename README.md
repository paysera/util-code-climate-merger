# util-code-climate-merger
merges checkstyle format to gitlab codeclimate supported format.

## installation

Clone repository and run `composer install`

## Merge

1. run `php code-climate-merger {/path/to/desired/target-file} 
--checkstyle {/path/to/php-cs-fixer-checkstyle} 
--checkstyle {/path/to/eslint-checkstyle}`

This command will:
1. Will merge two checkstyle reports and generate gitlab codeclimate report to specified file.
