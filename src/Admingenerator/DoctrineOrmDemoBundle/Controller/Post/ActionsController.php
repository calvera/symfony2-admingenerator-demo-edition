<?php

namespace Admingenerator\DoctrineOrmDemoBundle\Controller\Post;

use Admingenerated\AdmingeneratorDoctrineOrmDemoBundle\BasePostController\ActionsController as BaseActionsController;
use Admingenerator\DoctrineOrmDemoBundle\Exception\InvalidForm;
use Admingenerator\DoctrineOrmDemoBundle\Exception\UnsubmittedForm;
use Admingenerator\DoctrineOrmDemoBundle\Form\Type\Post\SimpleEditType;

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
	 * This function handles common object actions behaviour like
	 * checking CSRF protection token or credentials.
	 *
	 * To customize your action look into:
	 * executeObjectSimpleedit() - holds action logic
	 * successObjectSimpleedit() - called if action was successfull
	 * errorObjectSimpleedit()   - called if action errored
	 */
	protected function attemptObjectSimpleedit($pk) {
		$Post = $this->getObject($pk);

		try {
			$this->executeObjectSimpleedit($Post);

			return $this->successObjectSimpleedit($Post);
		} catch (\Exception $e) {
			return $this->errorObjectSimpleedit($e, $Post);
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
				"actionParams" => array("pk" => $pk, "action" => "simpleedit"),
			)
		);
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
		if ($e instanceof UnsubmittedForm) {
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
		} elseif ($e instanceof InvalidForm) {
			// Display the form for the first time...
		} else {
			dump($e);
		}

		return parent::errorObjectSimpleedit($e, $Post);
	}
}
