<?php

/* 
 * Defines a grammatical representation for a language and provides an interpreter to deal with it
 *
 * ExpressionInterface: interpret(context)
 *   - NonTerminalExpression    -> maintain a child expressions container
 *   - TerminalExpression       -> interpret directly
 */

namespace Phpatterns\Behavior;

interface ExpressionInterface { public function interpret(string $context): string; }

// No logic for this sample
class TerminalExpression implements ExpressionInterface
{
    public function interpret(string $context): string
    {
        return '['.$context.']';
    }
}

abstract class AbstractOperatorExpression implements ExpressionInterface
{
    protected $terminalExpression;
    
    public function __construct(TerminalExpression $terminalExpression)
    {
        $this->terminalExpression = $terminalExpression;
    }
    
    abstract public function interpret(string $context): string;
}

class SelectOperatorExpression extends AbstractOperatorExpression
{
    public function interpret(string $context): string
    {
        return '^' . $this->terminalExpression->interpret($context);
    }
}

class FromOperatorExpression extends AbstractOperatorExpression
{
    public function interpret(string $context): string
    {
        return '.' . $this->terminalExpression->interpret($context);
    }
}

class WhereOperatorExpression extends AbstractOperatorExpression
{
    public function interpret(string $context): string
    {
        return '.' . $this->terminalExpression->interpret($context);
    }
}

class LikeOperatorExpression extends AbstractOperatorExpression
{
    public function interpret(string $context): string
    {
        return '.' . $this->terminalExpression->interpret($context);
    }
}

class SqlToRegexpClient
{
    public function parse(string $sql): string
    {
        $sqlExpressions = explode(' ', $sql);
        
        $regexp = '';
        while (current($sqlExpressions)) {
            $operatorValue = current($sqlExpressions);
            $exValue = next($sqlExpressions);
            $expression = new TerminalExpression();

            switch ($operatorValue) {
                case 'SELECT': 
                    $operator = new SelectOperatorExpression($expression);
                    break;
                case 'FROM': 
                    $operator = new FromOperatorExpression($expression);
                    break;
                case 'WHERE': 
                    $operator = new WhereOperatorExpression($expression);
                    break;
                case 'LIKE': 
                    $operator = new LikeOperatorExpression($expression);
                    break;
            }

            $regexp .= $operator->interpret($exValue);
            next($sqlExpressions);
        }
        
        return '/'.$regexp.'/';
    }
}

$sqlToRegexp = new SqlToRegexpClient();

$sql = "SELECT user FROM file WHERE name LIKE 'alpha%'";
$sqlToRegexp->parse($sql);

return '@todo';
