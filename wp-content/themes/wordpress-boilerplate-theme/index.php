<?php if (!defined('ABSPATH')) { exit; } ?>
<?php get_header(); ?>
<main>
    <div class="container">
    <div class="my-4 p-5 bg-primary text-white rounded">
        <h1>Hello <?php echo $_SERVER['HTTP_HOST']; ?></h1>
        <?php
            function generateProgrammerLoremIpsum($numWords = 50) {
                $words = [
                    'algorithm', 'array', 'boolean', 'bug', 'cache', 'class', 'compile',
                    'constant', 'data', 'debug', 'exception', 'function', 'inheritance',
                    'interface', 'iteration', 'loop', 'method', 'object', 'operator', 'parameter',
                    'parse', 'pointer', 'recursion', 'reference', 'string', 'syntax', 'variable',
                    'version', 'while', 'closure', 'framework', 'script', 'repository', 'deployment',
                    'library', 'module', 'package', 'protocol', 'query', 'runtime', 'stack', 'thread',
                    'token', 'test', 'token', 'JSON', 'XML', 'endpoint', 'handler', 'middleware',
                    'constructor', 'destructor', 'inherit', 'serialization', 'validation', 'backend',
                    'frontend', 'REST', 'API', 'object-oriented', 'database', 'server', 'client', 'debugger'
                ];
                $numWords = max(1, $numWords);
                $text = '';
                for ($i = 0; $i < $numWords; $i++) {
                    $text .= $words[array_rand($words)] . ' ';
                }
                return trim($text) . '.';
            }
            echo generateProgrammerLoremIpsum(96);
        ?>
    </div>
    </div>
</main>
<?php get_footer(); ?>