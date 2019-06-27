<?php

namespace AppBundle\Controller;

use AppBundle\Utils\MathService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\SumType;

/**
 * Class MathsController
 * @Route("/maths")
 */
class MathsController extends Controller {

  /**
   * sortAction.
   *
   * @Route("/sort", name="maths_sort")
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function sortAction(Request $request) {
    /* To define de difficulty levels use this array. The 'name' is shown in the selector.
     * 'max' is the highest possible number to appear.
     * 'rows' *4 will be the number of numbers to sort.
     *
     * If you define a max < rows*4 the page will not load. */
    $levels = [
      ['max' => 12, 'rows' => 1, 'name' => 'Easy'],
      ['max' => 30, 'rows' => 2, 'name' => 'Medium'],
      ['max' => 99, 'rows' => 3, 'name' => 'Hard'],
    ];
    $choices = $this->getChoicesFromLevels($levels);

    $number_array = [];

    $form = $this->createFormBuilder()
      ->add('difficult', ChoiceType::class, [
        'label'   => 'Difficulty level',
        'choices' => $choices
      ])->getForm();

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $d = $form->getData()['difficult'];

      $max = $levels[$d]['max'];
      $rows = $levels[$d]['rows'];

      do {
        $ran_num = rand(1, $max);
        if (!in_array($ran_num, $number_array)) {
          $number_array[] = $ran_num;
        }
      } while (count($number_array) < (4 * $rows));

      //get the elements in random order
      shuffle($number_array);
    }

    return $this->render('maths/sort.html.twig', [
      'numbers' => $number_array,
      'form'    => $form->createView()
    ]);
  }

  private function getChoicesFromLevels($levels) {
    $choices = $number_array = [];
    foreach ($levels as $k => $data) {
      $choices[$data['name']] = $k;
    }

    return $choices;
  }

  /**
   * sumsAction.
   *
   * @Route("/sums", name="maths_sums")
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function sumsAction(Request $request) {
    $mathService = new MathService();
    $num_operands = 2;

    $sum = $mathService->randomSum(10, 0, $num_operands);
    $form_data = $this->getFormDataFromOperation($sum);

    $form = $this->createForm(SumType::class, $form_data);

    if ($request->getMethod() == 'POST') { //If post check the operation
      $form->handleRequest($request);
      if ($form->isValid()) {
        $form_data = $form->getData();
        $success = $mathService->checkSum($form_data);
      }
    }

    return $this->render('maths/sums.html.twig', [
      'form'     => $form->createView(),
      'submited' => ($request->getMethod() == 'POST'),
      'success'  => isset($success) ? $success : false,
    ]);
  }

  /**
   * getFormDataFromOperation.
   * Extract data for the SumType form from a given operation (with operands and result) and hide
   * one of the elements.
   *
   * @param array $operation
   * @return array
   */
  private function getFormDataFromOperation($operation) {
    $num_operands = count($operation['operands']);
    $form_data = [];

    $ocult = rand(0, $num_operands); //the random element to hide
    $i = 0;
    foreach ($operation['operands'] as $op) {
      $form_data['operands'][] = ($i != $ocult) ? $op : null;
      $i++;
    }
    $form_data['result'] = ($ocult != $num_operands) ? $operation['result'] : null;

    return $form_data;
  }

}

