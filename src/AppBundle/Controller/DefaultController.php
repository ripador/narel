<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller {

  /**
   * indexAction.
   *
   * @Route("/", name="homepage")
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function indexAction(Request $request) {

    return $this->render('default/index.html.twig', [
      'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
    ]);
  }

  /**
   * changeLocaleAction.
   * Set the given locale in the session and the LocaleSubscriber will handle it in all pages.
   *
   * @Route("/changeLocale/{locale}", name="change_locale")
   * @param Request $request
   * @param string $locale
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function changeLocaleAction(Request $request, $locale) {
    if (in_array($locale, ['en', 'es', 'ca'])) {
      $request->getSession()->set('_locale', $locale);
    }
    return $this->redirectToRoute('homepage');
  }

}
