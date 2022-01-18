<?php

/* 
 * Defines a grammatical representation for a language and provides an interpreter to deal with it
 *
 * ExpressionInterface: interpret(context)
 *   - NonTerminalExpression    -> maintain a child expressions container
 *   - TerminalExpression       -> interpret directly
 * 
 * Sample with AST (Abstract Syntax Tree) parsing
 */

namespace Phpatterns\Behavior;

interface ExprInterface { public function interpret(array $context): string; }

class FinalExpression implements ExprInterface
{
    private $text;
    public function __construct(string $text)
    {
        $this->text = $text;    
    }
    
    public function interpret(array $context): string
    {
        $text = str_replace(array_keys($context), array_values($context), $this->text);
        return $text;
    }
}

class BodyExpression implements ExprInterface
{
    private $children = [];
    
    public function add(ExprInterface $expression)
    {
        $this->children[] = $expression;
    }
    
    public function interpret(array $context): string
    {
        $result = '';
        $size = \count($this->children);
        $c = 0;
        foreach ($this->children as $child) {
            $separator = $c++ <= $size-2 ? ',' : '';
            $result .= $child->interpret($context) . $separator;
        }
        
        return "{".$result."}";
    }
}

class StringExpression implements ExprInterface
{
    private $expression;
    public function __construct(ExprInterface $expression)
    {
        $this->expression = $expression;
    }

    public function interpret(array $context): string
    {
        $text = $this->expression->interpret($context);
        $size = strlen($text);
        return '"string:'.$size.'":"'.$text.'"';
    }
}

class IntegerExpression implements ExprInterface
{
    private $expression;
    public function __construct(FinalExpression $expression)
    {
        $this->expression = $expression;
    }

    public function interpret(array $context): string
    {
        $text = $this->expression->interpret($context);
        $size = strlen($text);
        return '"integer:'.$size.'":"'.$text.'"';
    }
}

class YamlToJson
{
    public function parse(string $yaml): string
    {
        $string = preg_replace("/\s*\n\s+/", " ", $yaml);
        $tokens = array_reverse(explode(' ', $string));
        
        $stack = new \SplStack();
        foreach ($tokens as $token) {
            switch ($token) {
                case 'body': 
                    $body = new BodyExpression();
                    while (!$stack->isEmpty()) {
                        $exp = $stack->pop();
                        $body->add($exp);
                    }
                    $stack->push($body);
                    break;
                case 'text':
                    $stack->push(new StringExpression($stack->pop()));
                    break;
                case 'integer':
                    $stack->push(new IntegerExpression($stack->pop()));
                    break;
                default:
                    $stack->push(new FinalExpression($token));
                    break;
            }
        }
        
        $expression = $stack->pop();
        $context = ['%a%' => 'Postal', '%b%' => 'Try-it', '%c%' => 9876];
        $json = $expression->interpret($context);

        return $json;
    }
}

$yaml = <<<R
body
	text
		%a%
	text 
		%b%
	integer
		%c%
R;

$yamlToJson = new YamlToJson();
return '{"string:6":"Postal","string:6":"Try-it","integer:4":"9876"}' === $yamlToJson->parse($yaml);
