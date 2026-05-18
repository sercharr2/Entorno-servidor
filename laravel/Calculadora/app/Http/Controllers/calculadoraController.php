<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class calculadoraController extends Controller
{
    public function getCalculadora()
    {
        return view('calculadora.calculadora', [
            'cur'       => '0',
            'n1'        => '',
            'op'        => '',
            'waitN2'    => false,
            'fresh'     => false,
            'resultado' => null,
            'expresion' => '',
            'isError'   => false,
        ]);
    }

    public function postOperacion(Request $request)
    {
        $action = (string) $request->input('action', '');
        $cur    = (string) $request->input('cur', '0');
        $n1     = (string) $request->input('n1', '');
        $op     = (string) $request->input('op', '');
        $waitN2 = (bool)(int) $request->input('waitN2', 0);
        $fresh  = (bool)(int) $request->input('fresh', 0);

        $resultado = null;
        $expresion = '';
        $isError   = false;

        if (str_starts_with($action, 'digit_')) {
            $d = substr($action, 6);
            if ($fresh && !$waitN2) {
                $cur = $d; $n1 = ''; $op = ''; $fresh = false;
            } elseif ($waitN2) {
                $cur = $d; $waitN2 = false; $fresh = false;
            } else {
                $cur = ($cur === '0') ? $d : (strlen($cur) < 13 ? $cur . $d : $cur);
            }

        } elseif ($action === 'decimal') {
            if ($fresh || $waitN2) {
                $cur = '0.'; $waitN2 = false; $fresh = false;
            } elseif (!str_contains($cur, '.')) {
                $cur .= '.';
            }

        } elseif (str_starts_with($action, 'op_')) {
            $newOp = substr($action, 3);
            if ($op !== '' && !$waitN2) {
                // Chain: calculate silently before setting the new operator
                [, $expresion, $isError, $formatted] = $this->doCalc((float) $n1, (float) $cur, $op);
                if ($isError) {
                    $resultado = $formatted;
                    $cur = '0'; $n1 = ''; $op = ''; $waitN2 = false; $fresh = false;
                    return view('calculadora.calculadora',
                        compact('cur', 'n1', 'op', 'waitN2', 'fresh', 'resultado', 'expresion', 'isError'));
                }
                $cur = $formatted;
                $n1  = $formatted;
            } else {
                $n1 = $cur;
            }
            $op = $newOp; $waitN2 = true; $fresh = false;

        } elseif ($action === 'clear') {
            $cur = '0'; $n1 = ''; $op = ''; $waitN2 = false; $fresh = false;

        } elseif ($action === 'backspace') {
            if (!$waitN2 && !$fresh) {
                $cur = strlen($cur) > 1 ? substr($cur, 0, -1) : '0';
            }

        } elseif ($action === 'equals') {
            if ($n1 !== '' && $op !== '') {
                [, $expresion, $isError, $formatted] = $this->doCalc((float) $n1, (float) $cur, $op);
                $resultado = $formatted;
                if (!$isError) {
                    $cur = $formatted; $fresh = true;
                } else {
                    $cur = '0'; $fresh = false;
                }
                $n1 = ''; $op = ''; $waitN2 = false;
            }
        }

        return view('calculadora.calculadora',
            compact('cur', 'n1', 'op', 'waitN2', 'fresh', 'resultado', 'expresion', 'isError'));
    }

    private function doCalc(float $a, float $b, string $op): array
    {
        switch ($op) {
            case '+': $v = $a + $b; $e = "$a + $b"; break;
            case '-': $v = $a - $b; $e = "$a − $b"; break;
            case '*': $v = $a * $b; $e = "$a × $b"; break;
            case '/':
                if ($b == 0) return [null, '', true, 'Error: división por cero'];
                $v = $a / $b; $e = "$a ÷ $b"; break;
            case '^':  $v = pow($a, $b); $e = "$a ^ $b"; break;
            case 'nrt':
                if ($a == 0) return [null, '', true, 'Error: índice de raíz no puede ser 0'];
                $v = pow($b, 1 / $a); $e = "raíz $a de $b"; break;
            case 'log':
                if ($a <= 0 || $a == 1 || $b <= 0) return [null, '', true, 'Error: parámetros inválidos para logaritmo'];
                $v = log($b, $a); $e = "log₍$a₎($b)"; break;
            default:
                return [null, '', true, 'Error: operación desconocida'];
        }
        $f = rtrim(rtrim(number_format($v, 10, '.', ''), '0'), '.');
        return [$v, $e, false, $f];
    }
}
