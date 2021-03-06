<?php

/**
 * TechDivision\Example\Services\SampleProcessor
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */
namespace TechDivision\Example\Services;

use TechDivision\Example\Entities\Sample;
use TechDivision\Example\Services\AbstractProcessor;

/**
 * A singleton session bean implementation that handles the
 * data by using Doctrine ORM.
 *
 * @package TechDivision\Example
 * @copyright Copyright (c) 2013 <info@techdivision.com> - TechDivision GmbH
 * @license http://opensource.org/licenses/osl-3.0.php
 *          Open Software License (OSL 3.0)
 * @author Tim Wagner <tw@techdivision.com>
 * @Singleton
 */
class SampleProcessor extends AbstractProcessor
{

    /**
     * Loads and returns the entity with the ID passed as parameter.
     *
     * @param integer $id
     *            The ID of the entity to load
     * @return object The entity
     */
    public function load($id)
    {
        $entityManager = $this->getEntityManager();
        return $entityManager->find('TechDivision\Example\Entities\Sample', $id);
    }

    /**
     * Persists the passed entity.
     *
     * @param Sample $entity
     *            The entity to persist
     * @return Sample The persisted entity
     */
    public function persist(Sample $entity)
    {
        // load the entity manager
        $entityManager = $this->getEntityManager();
        // check if a detached entity has been passed
        if ($entity->getSampleId()) {
            $merged = $entityManager->merge($entity);
            $entityManager->persist($merged);
        } else {
            $entityManager->persist($entity);
        }
        // flush the entity manager
        $entityManager->flush();
        // and return the entity itself
        return $entity;
    }

    /**
     * Deletes the entity with the passed ID.
     *
     * @param integer $id
     *            The ID of the entity to delete
     * @return array An array with all existing entities
     */
    public function delete($id)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($entityManager->merge($this->load($id)));
        $entityManager->flush();
        return $this->findAll();
    }

    /**
     * Returns an array with all existing entities.
     *
     * @return array An array with all existing entities
     */
    public function findAll()
    {
        $entityManager = $this->getEntityManager();
        $repository = $entityManager->getRepository('TechDivision\Example\Entities\Sample');
        return $repository->findAll();
    }
}