<?php

namespace Admingenerator\DoctrineOrmDemoBundle\Controller\Post;

use Admingenerated\AdmingeneratorDoctrineOrmDemoBundle\BasePostController\ActionsController as BaseActionsController;
use Admingenerator\DoctrineOrmDemoBundle\Exception\InvalidForm;
use Admingenerator\DoctrineOrmDemoBundle\Exception\UnsubmittedForm;
use Admingenerator\DoctrineOrmDemoBundle\Form\Type\Post\SimpleEditType;
use Admingenerator\GeneratorBundle\Exception\ValidationException;

/**
 * ActionsController
 */
class ActionsController extends BaseActionsController {
	/**
	 * This function is for you to customize what action actually does
	 */
	protected function executeObjectExpire(\Admingenerator\DoctrineOrmDemoBundle\Entity\Post $Post) {
//    	$Post->setExpirationDate($)
		$this->getDoctrine()->getManager()->flush();
	}

	/**
	 * This function is for you to customize what action actually does
	 */
	protected function executeObjectSimpleedit(\Admingenerator\DoctrineOrmDemoBundle\Entity\Post $Post) {
		$form = $this->createForm(SimpleEditType::class, $Post);

		$form->handleRequest($this->request);
		if ($form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

		} elseif ($form->isSubmitted()) {
			throw new InvalidForm($form);
		} else {
			throw new UnsubmittedForm($form);
		}
	}

	protected function errorObjectSimpleedit(\Exception $e, \Admingenerator\DoctrineOrmDemoBundle\Entity\Post $Post = null) {
		if ($e instanceof ValidationException) {
			if (!$e instanceof UnsubmittedForm) {
		        $header = $this->get('translator')->trans(
		            "action.custom.error",
		            array('%name%' => 'Simpleedit'),
		            'Admingenerator'
		        );

		        $errors = $this->renderErrorsAsHTML($e, 'Admingenerator');

		        $this->get('session')->getFlashBag()->add('error', $header.' '.$errors);
		    }

			return $this->render(
				'AdmingeneratorDoctrineOrmDemoBundle:PostActions:index.html.twig',
				$this->getAdditionalRenderParameters($Post, 'simpleedit') + array(
					"Post" => $Post,
					"title" => $this->get('translator')->trans(
						"action.custom.title",
						array('%name%' => 'simpleedit'),
						'Admingenerator'
					),
					"actionRoute" => "Admingenerator_DoctrineOrmDemoBundle_Post_object",
					"actionParams" => array("pk" => $Post->getId(), "action" => "simpleedit"),
					'form' => $e->getForm()->createView(),
				)
			);
		} else {
			dump($e);
		}

		return parent::errorObjectSimpleedit($e, $Post);
	}

}
