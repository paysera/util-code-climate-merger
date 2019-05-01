# util-code-climate-merger
merges checkstyle format to gitlab codeclimate supported format.

## installation

Clone repository and run `composer install`

## Merge

1. run `php code-climate-merger {/path/to/desired/target-file} 
--checkstyle {/path/to/checkstyle} 
--checkstyle {/path/to/checkstyle}`

This command will:
1. Will merge two checkstyle reports and generate gitlab codeclimate report to specified file.
2. Command accepts at least one file to be generated to aforementioned report.