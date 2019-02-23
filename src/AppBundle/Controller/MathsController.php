<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * If you define a max < rows*4 the page will not load.
     */
    $levels = [
      ['max' => 12, 'rows' => 1, 'name' => 'Easy'],
      ['max' => 30, 'rows' => 2, 'name' => 'Medium'],
      ['max' => 99, 'rows' => 3, 'name' => 'Hard'],
    ];

    $choices = $number_array = [];
    foreach ($levels as $k => $data) {
      $choices[$data['name']] = $k;
    }

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
}
