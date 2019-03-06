<?php
namespace AppBundle\Utils;

/**
 * Class MathService
 *
 * @package AppBundle\Utils
 */
class MathService {

  /**
   * randomSum.
   * Generate a sum of random numbers.
   *
   * @param int $max
   * @param int $min
   * @param int $num_operands The number of operands in the sum operation
   * @return array with a sub-array of generated operands, and the final result
   */
  public function randomSum($max, $min = 0, $num_operands = 2) {
    $operands = [];
    $res = 0;

    for ($i=0; $i<$num_operands; $i++) {
      $operands[$i] = rand($min, $max);
      $res += $operands[$i];
    }

    return [
      'operands' => $operands,
      'result'   => $res
    ];
  }

  /**
   * checkSum.
   *
   * @param array $operation ['operands' => [<int>, <int>, ...], 'result' => <int>]
   * @return bool
   */
  public function checkSum($operation) {
    $total = 0;
    foreach ($operation['operands'] as $op) {
      $total += $op;
    }

    return ($total == $operation['result']);
  }
}